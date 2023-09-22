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
class ShlStreamBufferTooSmallException extends Exception
{

}

/**
 * Class Stream
 *
 * @package FasterImage
 */
class ShlHtmlContentRemoteimage_Stream
{
	/**
	 * The string that we have downloaded so far
	 */
	protected $stream_string = '';

	/**
	 * The pointer in the string
	 *
	 * @var int
	 */
	protected $strpos = 0;

	/**
	 * Get characters from the string but don't move the pointer
	 *
	 * @param $characters
	 *
	 * @return string | false
	 */
	public function peek($characters)
	{
		if (strlen($this->stream_string) < $this->strpos + $characters)
		{
			throw new ShlStreamBufferTooSmallException();
		}

		return substr($this->stream_string, $this->strpos, $characters);
	}

	/**
	 * Get Characters from the string
	 *
	 * @param $characters
	 *
	 * @return string
	 * @throws StreamBufferTooSmallException
	 */
	public function read($characters)
	{
		$result = $this->peek($characters);

		$this->strpos += $characters;

		return $result;
	}

	/**
	 * Completely reset the stream
	 */
	public function reset()
	{
		$this->resetPointer();
		$this->stream_string = '';
	}

	/**
	 * Resets the pointer to the 0 position
	 *
	 * @return mixed
	 */
	public function resetPointer()
	{
		$this->strpos = 0;
	}

	/**
	 * Append to the stream string
	 *
	 * @param $string
	 */
	public function write($string)
	{
		$this->stream_string .= $string;
	}
}
