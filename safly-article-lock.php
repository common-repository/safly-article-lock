<?php
/*
Plugin Name: SaFly Article Lock
Plugin URI: https://www.oranme.com
Description: A plug-in helps you disable the access to the articles in an appointed range.
Version: 1.1.0
Author: OranMe Ltd.
Author URI: https://blog.safly.org
License: MPL 2.0
Copyright: 2011-2018 OranMe Ltd.
*/

/*
This Source Code Form is subject to the terms of the Mozilla Public
License, v. 2.0. If a copy of the MPL was not distributed with this
file, You can obtain one at http://mozilla.org/MPL/2.0/.
Copyright 2011-2018 OranMe Ltd.
*/

//Debug
//ini_set('display_errors', 'On');

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if (!$GLOBALS['SaFly_AL']) {
	require(dirname(__FILE__)) . '/config.php';
}

//Add hook
add_action('wp', 'SaFly_Article_Lock_Hook');
function SaFly_Article_Lock_Hook() {
	if (SaFly_Article_Lock($GLOBALS['SaFly_AL'])) {
		if (!headers_sent()) {
			header($GLOBALS['SaFly_AL']['header']);
			header('Location: ' . $GLOBALS['SaFly_AL']['location']);
		}
		exit('SaFly Article Lock');
	}
}

function SaFly_Article_Lock($config)
{
	//home_excl
	if ($config['home_excl']) {
		if (is_front_page() || is_home()) {
			return false;
		}
	}

	$post = SaFly_AL_getPost();
	if (empty($post)) {
		return false;
	}

	//exclude_p
	if (in_array($post->ID, $config['exclude_p'])) {
		return false;
	}
	//include_p
	if (in_array($post->ID, $config['include_p'])) {
		return true;
	}

	$post_time = strtotime($post->post_date);
	//Initialize and avoid wrong time set
	$f_t    = explode(',', $config['f_t']);
	$from   = strtotime($config['from']);
	$to     = strtotime($config['to']);
	$f_t[0] = strtotime($f_t[0]);
	$f_t[1] = strtotime($f_t[1]);
	//1970-01-01
	$from   = ($from   === 0)?1:$from;
	$to     = ($to     === 0)?1:$to;
	$f_t[0] = ($f_t[0] === 0)?1:$f_t[0];
	$f_t[1] = ($f_t[1] === 0)?1:$f_t[1];
	//Mistakes check
	if ($from && $to && $f_t[0] && $f_t[1]) {
		//...
	}else {
		if (!empty($config['from']) && !empty($config['to']) && !empty($config['f_t'])) {
			//Wrong time set, please check
			error_log('SaFly Article Lock: Wrong time set');
		}
		return false;
	}

	if ($post_time > $from) {
		return true;
	}
	if ($post_time < $to) {
		return true;
	}
	if ($post_time > $f_t[0] && $post_time < $f_t[1]) {
		return true;
	}
}

function SaFly_AL_getPost()
{
	//Judge path first incase of bypass
	//https://developer.wordpress.org/reference/functions/get_page_by_path/
	$post = get_page_by_path(parse_url($_SERVER['REQUEST_URI'])['path'], 'OBJECT', array('post', 'page'));
	if (empty($post) && !empty($_GET['p'])) {
		//https://developer.wordpress.org/reference/functions/get_post/
		$post = get_post(intval($_GET['p']));
	}
	return $post;
}
