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
class ShlHtmlContentRemoteimage_Streamtransport
{
	/**
	 * The default timeout
	 *
	 * @var int
	 */
	protected $timeout = 10;
	protected $stream  = null;
	protected $parser  = null;
	protected $result  = false;

	// file handle
	protected $handle = null;

	public function __construct($stream, $parser)
	{
		// get stream and parser
		$this->stream = $stream;
		$this->parser = $parser;
	}

	/**
	 * Create the handle for the curl request
	 *
	 * @param $url
	 * @param $result
	 *
	 * @return resource
	 */
	public function getSize($url)
	{
		// result init
		$this->result = array();
		$this->result['type'] = '';
		$this->result['rounds'] = 0;
		$this->result['bytes'] = 0;
		$this->result['size'] = 'failed';

		// fetch and get size
		$this->query($url);

		return $this->result['size'];
	}

	/**
	 * @param $seconds
	 */
	public function setTimeout($seconds)
	{
		$this->timeout = $seconds;

		return $this;
	}

	protected function query($url)
	{
		if ($this->fileExists($url))
		{
			$opened = $this->open($url);
			if ($opened)
			{
				try
				{
					// read an arbitrary number of bytes
					$imageData = fread($this->handle, 256);
					if (!empty($imageData))
					{
						// load some part of the image
						$this->stream->write($imageData);

						// parse it
						$this->result['type'] = $this->parser->parseType();
						$parsedSize = $this->parser->parseSize();
						$this->result['size'] = empty($parsedSize) ? 'failed' : $parsedSize;
					}

					return $this;
				}
				catch (ShlStreamBufferTooSmallException $e)
				{
				}
				catch (ShlInvalidImageException $e)
				{
					$this->result['size'] = 'invalid';
				}
			}
		}

		return $this;
	}

	protected function fileExists($url)
	{
		$headers = @get_headers($url);

		return wbContains($headers[0], array('200', '304'));
	}

	protected function open($url)
	{
		if (!empty($this->handle))
		{
			$this->close();
		}

		$this->handle = fopen($url, 'r');

		return $this;
	}

	protected function close()
	{
		if (!empty($this->handle))
		{
			fclose($this->handle);
			$this->handler = null;
		}
	}
}
