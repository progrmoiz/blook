<?php

function plural( $amount, $singular = '', $plural = 's' ) {
    if ( $amount === 1 ) {
        return $singular;
    }
    return $plural;
}

function current_url( $trim_query_string = false ) {
    $pageURL = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";

    if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
        $port = ":$_SERVER[SERVER_PORT]";
    } else {
        $port = '';
    }
    $pageURL .= $_SERVER["SERVER_NAME"] . $port . $_SERVER["REQUEST_URI"];
    if( ! $trim_query_string ) {
        return $pageURL;
    } else {
        $url = explode( '?', $pageURL );
        return $url[0];
    }
}

function merge_querystring($url = null,$query = null,$recursive = false)
{
  // $url = 'http://www.google.com.au?q=apple&type=keyword';
  // $query = '?q=banana';
  // if there's a URL missing or no query string, return
  if($url == null)
    return false;
  if($query == null)
    return $url;
  // split the url into it's components
  $url_components = parse_url($url);
  // if we have the query string but no query on the original url
  // just return the URL + query string
  if(empty($url_components['query']))
    return $url.'?'.ltrim($query,'?');
  // turn the url's query string into an array
  parse_str($url_components['query'],$original_query_string);
  // turn the query string into an array
  parse_str(parse_url($query,PHP_URL_QUERY),$merged_query_string);
  // merge the query string
  if($recursive == true)
    $merged_result = array_merge_recursive($original_query_string,$merged_query_string);
  else
    $merged_result = array_merge($original_query_string,$merged_query_string);
  // Find the original query string in the URL and replace it with the new one
  return str_replace($url_components['query'],http_build_query($merged_result),$url);
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function isUserLoggedIn() {
    return isset($_SESSION['login_user']) && $_SESSION['login_user'] != '';
}

function setLocation($location) {
    $_SESSION['location'] = $location;
}