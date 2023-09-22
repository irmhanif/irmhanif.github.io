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
class ShlHtmlContentRemoteimage_Curltransport
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

	// curl handle
	protected $ch = null;

	public function __construct($stream, $parser)
	{
		// get stream and parser
		$this->stream = $stream;
		$this->parser = $parser;

		// curl init ops
		$this->initCurl();
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

	protected function initCurl()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_HEADER, 0);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->ch, CURLOPT_BUFFERSIZE, 256);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);

		#  Some web servers require the useragent to be not a bot. So we are liars.
		curl_setopt(
			$this->ch,
			CURLOPT_USERAGENT,
			'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36'
		);
		curl_setopt(
			$this->ch,
			CURLOPT_HTTPHEADER,
			array(
				"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
				"Cache-Control: max-age=0",
				"Connection: keep-alive",
				"Keep-Alive: 300",
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
				"Accept-Language: en-us,en;q=0.5",
				"Pragma: ", // browsers keep this blank.
			)
		);
		curl_setopt(
			$this->ch,
			CURLOPT_ENCODING,
			''
		);

		curl_setopt(
			$this->ch,
			CURLOPT_WRITEFUNCTION,
			array(
				$this,
				'curlWriteHandler'
			)
		);

		return $this;
	}

	protected function query($url)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_exec($this->ch);

		return $this;
	}

	protected function curlWriteHandler($ch, $str)
	{
		$this->result['rounds']++;
		$this->result['bytes'] += strlen($str);

		$this->stream->write($str);

		try
		{
			/*
			 * We try here to parse the buffer of characters we already have
			 * for the size.
			 */
			$this->result['type'] = $this->parser->parseType();
			$parsedSize = $this->parser->parseSize();
			$this->result['size'] = empty($parsedSize) ? 'failed' : $parsedSize;
		}
		catch (ShlStreamBufferTooSmallException $e)
		{
			/*
			 * If this exception is thrown, we don't have enough of the stream buffered
			 * so in order to tell curl to keep streaming we need to return the number
			 * of bytes we have already handled
			 *
			 * We set the 'size' to 'failed' in the case that we've done
			 * the entire image and we couldn't figure it out. Otherwise
			 * it'll get overwritten with the next round.
			 */
			$this->result['size'] = 'failed';

			return strlen($str);
		}
		catch (ShlInvalidImageException $e)
		{

			/*
			 * This means we've determined that we're lost and don't know
			 * how to parse this image.
			 *
			 * We set the size to invalid and move on
			 */
			$this->result['size'] = 'invalid';

			return -1;
		}

		/*
		 * We return -1 to abort the transfer when we have enough buffered
		 * to find the size
		 */
		//
		// hey curl! this is an error. But really we just are stopping cause
		// we already have what we wwant
		return -1;
	}
}
