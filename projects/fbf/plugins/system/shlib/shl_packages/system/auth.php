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

defined('_JEXEC') or die;

/**
 * Simple external authentication system
 *
 */
class ShlSystem_Auth
{
	const UUID4_WITH_DASHES = 1;
	const UUID4_NO_DASHES = 2;
	const UUID4_UPPERCASE = 1;
	const UUID4_LOWERCASE = 2;

	/**
	 * Sign an outgoing request with (our) standard headers
	 *
	 * Note that they query should be used to send the request without being modified or added to, at least if the
	 * signature is being checked by the receiving end.
	 *
	 * Also, the query variables are alphabetically sorted on the array key (ie the query variable name)
	 * prior to signature being computed so as to normalize the input and insure repeatability on both ends
	 *
	 * @param array  $query Key/value array of query variables
	 * @param string $authKey A secret key shared between emitter and receiver
	 * @param string $origin Optional. the origin making the request. Formatted as scheme://full.host.tld[/path] No
	 *     trailing slash
	 * @param string $extra Optional. A string passed  as-is (and signed) with the request as X-WBLR-AUTH-EXTRA header
	 *
	 * @return Object  'query' => built query string (ie p1=123&p2=456...), 'urlEncodedQuery' => same as query but url
	 *     encoded, 'headers' => key/value array of headers to be sent
	 */
	public static function signRequest(
		$query,
		$authKey,
		$origin = '',
		$extra = ''
	)
	{
		$accessKey = self::splitAuthKey($authKey);
		$origin = JString::rtrim($origin, '/');
		$extra = is_string($extra) ? JString::trim($extra) : 'n/a';

		$request = new stdClass();
		$headers = array(
			'X-WBLR-AUTH-TS' => time(),
			'X-WBLR-AUTH-ID' => $accessKey['key'],
			'X-WBLR-AUTH-TOKEN' => self::uuidv4(self::UUID4_NO_DASHES),
			'X-WBLR-AUTH-ORIGIN' => empty($origin) ? '' : hash('sha256', $origin),
			'X-WBLR-AUTH-EXTRA' => empty($extra) ? '' : $extra
		);

		// normalize
		ksort($query);

		// build the request, to be signed
		$queryString = array();
		$queryUrlEncoded = array();
		foreach ($query as $key => $value)
		{
			$queryString[] = $key . '=' . $value;
			$queryUrlEncoded[] = $key . '=' . urlencode($value);
		}
		$queryString = implode('&', $queryString);
		$queryUrlEncoded = implode('&', $queryUrlEncoded);

		$base = $headers['X-WBLR-AUTH-TS']
			. $headers['X-WBLR-AUTH-ID']
			. $headers['X-WBLR-AUTH-TOKEN']
			. $headers['X-WBLR-AUTH-ORIGIN']
			. $headers['X-WBLR-AUTH-EXTRA']
			. $accessKey['secret']
			. $queryString;
		$headers['X-WBLR-AUTH-SIG'] = hash('sha256', $base);

		$request->query = $queryString;
		$request->urlEncodedQuery = $queryUrlEncoded;
		$request->headers = $headers;

		return $request;
	}

	/**
	 * Split user-provided weeblrpress.com access key in
	 * 2 parts: public and private
	 *
	 * @param $authKey
	 *
	 * @return array
	 */
	private static function splitAuthKey($authKey)
	{
		$authKey = JString::trim($authKey);
		$splitKey = array('key' => '', 'secret' => '');
		if (64 != strlen($authKey))
		{
			return $splitKey;
		}

		$splitKey['key'] = substr($authKey, 0, 32);
		$splitKey['secret'] = substr($authKey, 32);

		return $splitKey;
	}

	/**
	 * Verify the integrity of an incoming request
	 *
	 * @param string $secretKey the user secret key
	 * @param array  $query Key/value array of query variables
	 * @param array  $incomingHeaders
	 * @param bool   $urlDecodeBeforeVerify Whether query string should be urldecode-d before auth is verified
	 *
	 * @return Object  'status' => HTTP status code, 'message' => Description of the response status
	 */
	public static function verifyRequest(
		$secretKey,
		$query,
		$incomingHeaders,
		$allowedTimeSkew,
		$urlDecodeBeforeVerify = true
	)
	{
		$verifiedRequest = new stdClass();
		$verifiedRequest->code = 200;
		$verifiedRequest->message = 'OK';

		$headers = array_merge(
			array(
				'X-WBLR-AUTH-TS' => '',
				'X-WBLR-AUTH-ID' => '',
				'X-WBLR-AUTH-TOKEN' => '',
				'X-WBLR-AUTH-ORIGIN' => '',
				'X-WBLR-AUTH-EXTRA' => '',
				'X-WBLR-AUTH-SIG' => '',
			),
			$incomingHeaders
		);

		// prevent edge cases when values are not supplied
		// NB: origin and extra are optional, depends on use case
		if (
			empty($headers['X-WBLR-AUTH-TS'])
			||
			empty($headers['X-WBLR-AUTH-ID'])
			||
			empty($headers['X-WBLR-AUTH-TOKEN'])
			||
			empty($headers['X-WBLR-AUTH-SIG'])
		)
		{
			$verifiedRequest->message = 'Not authorized (invalid headers).';
			$verifiedRequest->code = 403;
		}

		if (!self::hasValidTimeSkew(
			$headers['X-WBLR-AUTH-TS'],
			$allowedTimeSkew
		)
		)
		{
			$verifiedRequest->message = 'Not authorized (invalid timestamp).';
			$verifiedRequest->code = 403;
		}

		if (!self::hasValidSignature($secretKey, $query, $headers, $urlDecodeBeforeVerify))
		{
			$verifiedRequest->message = 'Not authorized (invalid signature).';
			$verifiedRequest->code = 403;
		}

		return $verifiedRequest;
	}

	/**
	 * Check whether the request time stamp is older than a given threshold
	 *
	 * An allowedTimeStamp value of 0 disables the test
	 *
	 * @param int $requestTimeStamp
	 * @param int $allowedTimeSkew
	 *
	 * @return bool
	 */
	private static function hasValidTimeSkew($requestTimeStamp, $allowedTimeSkew)
	{
		$skew = time() - (int) $requestTimeStamp;
		if (!empty($allowedTimeSkew) && abs($skew) > $allowedTimeSkew)
		{
			return false;
		}

		return true;
	}

	/**
	 * Run signing method on query to verify it matches the passed signature
	 *
	 * @param string $secretKey the user secret key
	 * @param array  $request Key/value array of query variables
	 * @param array  $headers
	 * @param bool   $urlDecodeBeforeVerify Whether query string should be urldecode-d before auth is verified
	 */
	private static function hasValidSignature($secretKey, $query, $headers, $urlDecodeBeforeVerify = false)
	{
		$base = $headers['X-WBLR-AUTH-TS']
			. $headers['X-WBLR-AUTH-ID']
			. $headers['X-WBLR-AUTH-TOKEN']
			. $headers['X-WBLR-AUTH-ORIGIN']
			. $headers['X-WBLR-AUTH-EXTRA']
			. $secretKey;

		// sort query array by key, to normalize hash building
		ksort($query);

		// build up query string
		$queryString = array();
		foreach ($query as $key => $value)
		{
			$queryString[] = $key . '=' . ($urlDecodeBeforeVerify ? urldecode($value) : $value);
		}
		$base .= implode('&', $queryString);

		// now verify signature against the one passed in the request
		$computedSignature = hash('sha256', $base);
		if ($computedSignature != $headers['X-WBLR-AUTH-SIG'])
		{
			return false;
		}

		return true;
	}

	/**
	 * From http://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
	 *
	 * @param bool   $dashes If true, dashes are removed from output (default is to keep them)
	 * @param bool   $case If true, uuid is lowercased (default is to uppercase if)
	 * @param string $data 16 characters of random data. If not provided, openssl_random_pseudo_bytes(16) is used
	 *
	 * @return string
	 */
	public static function uuidv4($dashes = self::UUID4_WITH_DASHES, $case = self::UUID4_UPPERCASE, $data = null)
	{
		if (is_null($data))
		{
			$data = openssl_random_pseudo_bytes(16);
		}

		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

		$template = self::UUID4_WITH_DASHES == $dashes ? '%s%s-%s-%s-%s-%s%s%s' : '%s%s%s%s%s%s%s%s';
		$uuid = self::UUID4_UPPERCASE == $case ? strtoupper(vsprintf($template, str_split(bin2hex($data), 4))) : strtolower(vsprintf($template, str_split(bin2hex($data), 4)));

		return $uuid;
	}
}
