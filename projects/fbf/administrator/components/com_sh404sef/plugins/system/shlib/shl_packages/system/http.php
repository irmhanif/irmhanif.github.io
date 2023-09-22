<?php
/**
 * Shlib - programming library
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2017
 * @package     shlib
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     0.3.1.661
 * @date                2018-01-15
 */

// no direct access
defined('_JEXEC') or die;

class ShlSystem_Http
{

	// return code
	const RETURN_OK = 200;
	const RETURN_BAD_REQUEST = 400;
	const RETURN_UNAUTHORIZED = 401;
	const RETURN_FORBIDDEN = 403;
	const RETURN_NOT_FOUND = 404;
	const RETURN_PROXY_AUTHENTICATION_REQUIRED = 407;
	const RETURN_SERVICE_UNAVAILABLE = 503;

	public static function abort($code = self::RETURN_NOT_FOUND, $cause = '')
	{

		$header = self::getHeader($code, $cause);

		// clean all buffers
		ob_end_clean();

		$msg = empty($cause) ? $header->msg : $cause;
		if (!headers_sent())
		{
			header($header->raw);
		}
		die($msg);
	}

	public static function getHeader($code, $cause)
	{

		$code = intval($code);
		$header = new stdClass();

		switch ($code)
		{

			case self::RETURN_BAD_REQUEST:
				$header->raw = 'HTTP/1.0 400 BAD REQUEST';
				$header->msg = '<h1>Unauthorized</h1>';
				break;
			case self::RETURN_UNAUTHORIZED:
				$header->raw = 'HTTP/1.0 401 UNAUTHORIZED';
				$header->msg = '<h1>Unauthorized</h1>';
				break;
			case self::RETURN_FORBIDDEN:
				$header->raw = 'HTTP/1.0 403 FORBIDDEN';
				$header->msg = '<h1>Forbidden access</h1>';
				break;
			case self::RETURN_NOT_FOUND:
				$header->raw = 'HTTP/1.0 404 NOT FOUND';
				$header->msg = '<h1>Page not found</h1>';
				break;
			case self::RETURN_PROXY_AUTHENTICATION_REQUIRED:
				$header->raw = 'HTTP/1.0 407 PROXY AUTHENTICATION REQUIRED';
				$header->msg = '<h1>Proxy authentication required</h1>';
				break;
			case self::RETURN_SERVICE_UNAVAILABLE:
				$header->raw = 'HTTP/1.0 503 SERVICE UNAVAILABLE';
				$header->msg = '<h1>Service unavailable</h1>';
				break;

			default:
				$header->raw = 'HTTP/1.0 ' . $code;
				$header->msg = $cause;
				break;
		}

		return $header;
	}

	public static function getAllHeaders($prefix = '')
	{
		static $headers = null;

		if (is_null($headers))
		{
			if (strpos(php_sapi_name(), 'cgi') !== false)
			{
				$rawHeaders = $_SERVER;
				$cgiPrefix = 'http_';
			}
			else
			{
				$rawHeaders = getallheaders();
				$cgiPrefix = '';
			}

			// loop, keep only relevant headers
			if (empty($prefix))
			{
				$headers = $rawHeaders;
			}
			else
			{
				$headers = array();
				foreach ($rawHeaders as $headerKey => $headerValue)
				{
					$headerKey = strtoupper($headerKey);
					if (strpos($headerKey, strtoupper($cgiPrefix . $prefix)) === 0)
					{
						// removed HTTP_, only for cgi-types, just in case a header would start with HTTP_
						$headerKey = empty($cgiPrefix) ? $headerKey : preg_replace('/^HTTP_/', '', $headerKey);
						// replace _ with -. We only use dashes (-) but when under *-CGI, dashes in headers are turned
						// (by nginx for instance) into underscores when mapped to CGI variables, HTTP_.....
						// so we just revert that
						$headers[str_replace('_', '-', $headerKey)] = $headerValue;
					}
				}
			}
		}

		return $headers;
	}

	/**
	 * Renders an http response and end processing of request
	 *
	 * @param int    $code http status to use for response
	 * @param string $cause Optional text to use as response body
	 */
	public static function render($code = self::RETURN_NOT_FOUND, $cause = '', $type = 'text/html')
	{
		$header = self::getHeader($code, $cause);

		// clean all buffers
		ob_end_clean();

		$msg = empty($cause) ? $header->msg : $cause;
		if (!headers_sent())
		{
			header($header->raw);
			header('Content-type: ' . $type);
		}

		die($msg);
	}

	/**
	 * Perform a server-side 301 redirect to the target URL.
	 *
	 * @param string $target
	 */
	public static function redirectPermanent($target)
	{
		@ob_end_clean();
		if (headers_sent())
		{
			echo '<html><head><meta http-equiv="content-type" content="text/html; charset="UTF-8"'
				. '" /><script>document.location.href=\'' . $target . '\';</script></head><body></body></html>';
		}
		else
		{
			header('Cache-Control: no-cache'); // prevent Firefox5+ and IE9+ to consider this a cacheable redirect
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $target);
		}
		exit();
	}

	/**
	 * Collect a visitor IP address, including best guesses when site is behind a proxy.
	 *
	 * @return string
	 */
	public static function getVisitorIpAddress()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}
