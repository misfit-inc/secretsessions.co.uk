<?php
$token = '155129701-8l9Lkb8MWTPVhRmhJBdAdevUcT8ajMtX1uQvKVFd';
$token_secret = 'h7ffWjC4Q3bvAutl9OKk2IfWiLcmPow6HEuLepBbH4';
$consumer_key = 'ALfZCBwEQGjnq7fFCXg';
$consumer_secret = 'sVOVBewOMyx11JGQ3TANrRE9pV3m0RCd5xEbaHbZ0';

$host = 'api.twitter.com';
$method = 'GET';
$path = '/1.1/statuses/user_timeline.json'; // api call path
preg_match("/https:\/\/twitter.com\/(#!\/)?([^\/]*)/", $user_data['TWITTER_EMDED_CODE'], $matches);
if (count($matches) >= 3) {
    $query = array( // query parameters
        'screen_name' => $matches[2],
        'count' => '5',
        'include_entities' => 'true',
        'include_rts' => 'true',
    );
    $oauth = array(
        'oauth_consumer_key' => $consumer_key,
        'oauth_token' => $token,
        'oauth_nonce' => (string)mt_rand(), // a stronger nonce is recommended
        'oauth_timestamp' => time(),
        'oauth_signature_method' => 'HMAC-SHA1',
        'oauth_version' => '1.0'
    );

    $oauth = array_map("rawurlencode", $oauth); // must be encoded before sorting
    $query = array_map("rawurlencode", $query);

    $arr = array_merge($oauth, $query); // combine the values THEN sort

    asort($arr); // secondary sort (value)
    ksort($arr); // primary sort (key)

// http_build_query automatically encodes, but our parameters
// are already encoded, and must be by this point, so we undo
// the encoding step
    $querystring = urldecode(http_build_query($arr, '', '&'));

    $url = "https://$host$path";

// mash everything together for the text to hash
    $base_string = $method . "&" . rawurlencode($url) . "&" . rawurlencode($querystring);

// same with the key
    $key = rawurlencode($consumer_secret) . "&" . rawurlencode($token_secret);

// generate the hash
    $signature = rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));

// this time we're using a normal GET query, and we're only encoding the query params
// (without the oauth params)
    $url .= "?" . http_build_query($query);
    $url = str_replace("&amp;", "&", $url); //Patch by @Frewuill

    $oauth['oauth_signature'] = $signature; // don't want to abandon all that work!
    ksort($oauth); // probably not necessary, but twitter's demo does it

// also not necessary, but twitter's demo does this too
    function add_quotes($str)
    {
        return '"' . $str . '"';
    }

    $oauth = array_map("add_quotes", $oauth);

// this is the full value of the Authorization line
    $auth = "OAuth " . urldecode(http_build_query($oauth, '', ', '));

// if you're doing post, you need to skip the GET building above
// and instead supply query parameters to CURLOPT_POSTFIELDS
    $options = array(CURLOPT_HTTPHEADER => array("Authorization: $auth"),
        //CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HEADER => false,
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false);
// do our business
    $feed = curl_init();
    curl_setopt_array($feed, $options);
    $json = curl_exec($feed);
    curl_close($feed);
    $tweet = json_decode($json);
    function twitterify($ret)
    {
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
        $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
        $ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
        return $ret;
    }

    $count = 5;
    for ($i = 1; $i <= $count; $i++) {
        echo '<li>' . twitterify(@$tweet[($i - 1)]->text) . '<span>' . date('d F', strtotime($tweet[$i - 1]->created_at)) . '</span> </li>';
    }

}
?>