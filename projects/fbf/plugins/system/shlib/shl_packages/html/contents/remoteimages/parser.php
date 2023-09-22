<?php
/**
 * Shlib - programming library
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2017
 * @package     shlib
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     0.3.1.661
 * @date        2018-01-15
 */

// Security check to ensure this file is being included by a parent file.
defined('_JEXEC') or die();

/**
 * Derived from:
 *
 * FastImage - Because sometimes you just want the size!
 * Based on the Ruby Implementation by Steven Sykes (https://github.com/sdsykes/fastimage)
 *
 * Copyright (c) 2012 Tom Moor
 * Tom Moor, http://tommoor.com
 *
 * MIT Licensed
 * @version 0.1
 *
 * and
 *
 * FasterImage - Because sometimes you just want the size, and you want them in
 * parallel!
 *
 * Based on the PHP stream implementation by Tom Moor (http://tommoor.com)
 * which was based on the original Ruby Implementation by Steven Sykes
 * (https://github.com/sdsykes/fastimage)
 *
 * MIT Licensed
 *
 * @version 0.01
 */
class ShlInvalidImageException extends Exception
{

}

/**
 * Parses the stream of the image and determines the size and type of the image
 *
 * @package FasterImage
 */
class ShlHtmlContentRemoteimage_Parser
{
	/**
	 * The type of image we've determined this is
	 *
	 * @var string
	 */
	protected $type;
	/**
	 * @var StreamableInterface $stream
	 */
	private $stream;

	/**
	 * ImageParser constructor.
	 *
	 * @param StreamableInterface $stream
	 */
	public function __construct(& $stream)
	{
		$this->stream = $stream;
	}

	public function reset()
	{
		$this->type = null;
		$this->stream->reset();
	}

	/**
	 * Reads and returns the type of the image
	 *
	 * @return bool|string
	 */
	public function parseType()
	{
		if (empty($this->type))
		{
			switch ($this->stream->read(2))
			{
				case "BM":
					return $this->type = 'bmp';
				case "GI":
					return $this->type = 'gif';
				case chr(0xFF) . chr(0xd8):
					return $this->type = 'jpeg';
				case "\0\0":
					switch ($this->readByte($this->stream->peek(1)))
					{
						case 1:
							return $this->type = 'ico';
						case 2:
							return $this->type = 'cur';
					}

					return false;

				case chr(0x89) . 'P':
					return $this->type = 'png';
				case "RI":
					if (substr($this->stream->read(10), 6, 4) == 'WEBP')
					{
						return $this->type = 'webp';
					}

					return false;
				case'8B':
					return $this->type = 'psd';
				case "II":
				case "MM":
					return $this->type = 'tiff';
				default:
					return false;
			}
		}

		return $this->type;
	}

	/**
	 * @return array|bool|null
	 */
	public function parseSize()
	{
		$this->stream->resetPointer();

		switch ($this->type)
		{
			case 'png':
				return $this->parseSizeForPNG();
			case 'ico':
			case 'cur':
				return $this->parseSizeForIco();
			case 'gif':
				return $this->parseSizeForGIF();
			case 'bmp':
				return $this->parseSizeForBMP();
			case 'jpeg':
				return $this->parseSizeForJPEG();
			case 'tiff':
				return $this->parseSizeForTiff();
			case 'psd':
				return $this->parseSizeForPSD();
			case 'webp':
				return $this->parseSizeForWebp();
		}

		return null;
	}

	/**
	 * @return array
	 */
	public function parseSizeForIco()
	{
		$this->stream->read(6);

		$b1 = $this->getByte();
		$b2 = $this->getByte();

		return array(
			$b1 == 0 ? 256 : $b1,
			$b2 == 0 ? 256 : $b2
		);
	}

	/**
	 * @return array
	 */
	protected function parseSizeForPSD()
	{
		$this->stream->read(14);
		$sizes = unpack("N*", $this->stream->read(12));

		return array(
			$sizes[2],
			$sizes[1]
		);
	}

	/**
	 * Getter for the last image type
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return array
	 */
	protected function parseSizeForBMP()
	{
		$chars = $this->stream->read(29);
		$chars = substr($chars, 14, 14);
		$type = unpack('C', $chars);

		$size = (reset($type) == 40) ? unpack('l*', substr($chars, 4)) : unpack('l*', substr($chars, 4, 8));

		return array(
			current($size),
			abs(next($size))
		);
	}

	/**
	 * @return array
	 */
	protected function parseSizeForGIF()
	{
		$chars = $this->stream->read(11);

		$size = unpack("S*", substr($chars, 6, 4));

		return array(
			current($size),
			next($size)
		);
	}

	/**
	 * @return array|bool
	 */
	protected function parseSizeForJPEG()
	{
		$state = null;

		while (true)
		{
			switch ($state)
			{
				default:
					$this->stream->read(2);
					$state = 'started';
					break;

				case 'started':
					$b = $this->getByte();
					if ($b === false)
					{
						return false;
					}

					$state = $b == 0xFF ? 'sof' : 'started';
					break;

				case 'sof':
					$b = $this->getByte();

					if ($b === 0xe1)
					{
						$data = $this->stream->read($this->readInt($this->stream->read(2)) - 2);

						$stream = new ShlHtmlContentRemoteimage_Stream;
						$stream->write($data);

						if ($stream->read(4) === 'Exif')
						{
							$stream->read(2);
							$exif = new ShlHtmlContentRemoteimage_ExifParser($stream);
						}

						break;
					}

					if (in_array($b, range(0xe0, 0xef)))
					{
						$state = 'skipframe';
						break;
					}

					if (in_array($b, array_merge(range(0xC0, 0xC3), range(0xC5, 0xC7), range(0xC9, 0xCB), range(0xCD, 0xCF))))
					{
						$state = 'readsize';
						break;
					}
					if ($b == 0xFF)
					{
						$state = 'sof';
						break;
					}

					$state = 'skipframe';
					break;

				case 'skipframe':
					$skip = $this->readInt($this->stream->read(2)) - 2;
					$this->stream->read($skip);
					$state = 'started';
					break;

				case 'readsize':
					$c = $this->stream->read(7);

					$size = array($this->readInt(substr($c, 5, 2)), $this->readInt(substr($c, 3, 2)));

					if (isset($exif) && $exif->isRotated())
					{
						return array_reverse($size);
					}

					return $size;
			}
		}

		return false;
	}

	/**
	 * @return array
	 */
	protected function parseSizeForPNG()
	{
		$chars = $this->stream->read(25);

		$size = unpack("N*", substr($chars, 16, 8));

		return array(
			current($size),
			next($size)
		);
	}

	/**
	 * @return array|bool
	 * @throws WblInvalidImageException
	 * @throws StreamBufferTooSmallException
	 */
	protected function parseSizeForTiff()
	{
		$exif = new ShlHtmlContentRemoteimage_ExifParser($this->stream);

		if ($exif->isRotated())
		{
			return array($exif->getHeight(), $exif->getWidth());
		}

		return array($exif->getWidth(), $exif->getHeight());
	}

	/**
	 * @return null
	 * @throws StreamBufferTooSmallException
	 */
	protected function parseSizeForWebp()
	{
		$vp8 = substr($this->stream->read(16), 12, 4);
		$len = unpack("V", $this->stream->read(4));

		switch (trim($vp8))
		{

			case 'VP8':
				$this->stream->read(6);

				$width = current(unpack("v", $this->stream->read(2)));
				$height = current(unpack("v", $this->stream->read(2)));

				return array(
					$width & 0x3fff,
					$height & 0x3fff
				);

			case 'VP8L':
				$this->stream->read(1);

				$b1 = $this->getByte();
				$b2 = $this->getByte();
				$b3 = $this->getByte();
				$b4 = $this->getByte();

				$width = 1 + ((($b2 & 0x3f) << 8) | $b1);
				$height = 1 + ((($b4 & 0xf) << 10) | ($b3 << 2) | (($b2 & 0xc0) >> 6));

				return array($width, $height);

			case 'VP8X':

				$flags = current(unpack("C", $this->stream->read(4)));

				$b1 = $this->getByte();
				$b2 = $this->getByte();
				$b3 = $this->getByte();
				$b4 = $this->getByte();
				$b5 = $this->getByte();
				$b6 = $this->getByte();

				$width = 1 + $b1 + ($b2 << 8) + ($b3 << 16);

				$height = 1 + $b4 + ($b5 << 8) + ($b6 << 16);

				return array($width, $height);
			default:
				return null;
		}
	}

	/**
	 * @return mixed
	 */
	private function getByte()
	{
		return $this->readByte($this->stream->read(1));
	}

	/**
	 * @param $string
	 *
	 * @return mixed
	 */
	private function readByte($string)
	{
		return current(unpack("C", $string));
	}

	/**
	 * @param $str
	 *
	 * @return int
	 */
	private function readInt($str)
	{
		$size = unpack("C*", $str);

		return ($size[1] << 8) + $size[2];
	}
}
