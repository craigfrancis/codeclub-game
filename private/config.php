<?php

	ini_set('session.use_only_cookies', true);
	ini_set('session.cookie_secure', true);
	ini_set('session.cookie_httponly', true);
	ini_set('session.use_strict_mode', true);
	session_name('__Host-s');

	session_start();

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$db = new mysqli('localhost', 'stage', 'st8ge', 's-codeclub-game');
	$db->set_charset('utf8mb4');

	function html($text) {
		return htmlspecialchars($text, (ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE | ENT_DISALLOWED), 'UTF-8');
	}

	$now = new DateTime();

	$errors = [];

?>