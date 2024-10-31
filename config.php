<?php
//SaFly suggests you copy the following code to the bottom of wp-config.php to escape upgrade coverage.

$SaFly_AL = array(
	'header'    => 'HTTP/1.1 302 Found',    //HTTP/1.1 301 Moved Permanently
	'location'  => defined('WP_HOME')       //Location: {WP_HOME}
					?WP_HOME
					:'https://example.com/',
	'from'      => '2037-01-01',            //...|...,     the right part will be locked
	'to'        => '1970-01-01',            //...|...,     the left part will be locked
	'f_t'       => '1970-01-01,1970-01-02', //...|...|..., the middle part will be locked
	'home_excl' => true,                    //If true the homepage won't be locked
	'exclude_p' => [],                      //[4,5,6] (Supreme Priority)
	'include_p' => [],                      //[1,2,3]
);

$GLOBALS['SaFly_AL'] = $SaFly_AL;

//Wordpress Multisite Example
$SaFly_AL_site1 = array(
	'header'    => 'HTTP/1.1 302 Found',    //HTTP/1.1 301 Moved Permanently
	'location'  => defined('WP_HOME')       //Location: {WP_HOME}
					?WP_HOME
					:'https://example.com/',
	'from'      => '2037-01-01',            //...|...,     the right part will be locked
	'to'        => '1970-01-01',            //...|...,     the left part will be locked
	'f_t'       => '1970-01-01,1970-01-02', //...|...|..., the middle part will be locked
	'home_excl' => true,                    //If true the homepage won't be locked
	'exclude_p' => [],                      //[4,5,6] (Supreme Priority)
	'include_p' => [],                      //[1,2,3]
);
$SaFly_AL_site2 = array(
	'header'    => 'HTTP/1.1 302 Found',    //HTTP/1.1 301 Moved Permanently
	'location'  => defined('WP_HOME')       //Location: {WP_HOME}
					?WP_HOME
					:'https://example.com/',
	'from'      => '2037-01-01',            //...|...,     the right part will be locked
	'to'        => '1970-01-01',            //...|...,     the left part will be locked
	'f_t'       => '1970-01-01,1970-01-02', //...|...|..., the middle part will be locked
	'home_excl' => true,                    //If true the homepage won't be locked
	'exclude_p' => [],                      //[4,5,6] (Supreme Priority)
	'include_p' => [],                      //[1,2,3]
);

if (strstr($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'site1')) {
	$GLOBALS['SaFly_AL'] = $SaFly_AL_site1;
}elseif (strstr($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'site2')) {
	$GLOBALS['SaFly_AL'] = $SaFly_AL_site2;
}else {
	$GLOBALS['SaFly_AL'] = $SaFly_AL;
}
