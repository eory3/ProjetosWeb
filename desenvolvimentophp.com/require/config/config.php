<?php
	define('REDIRECT_QUERY_STRING',isset($_SERVER['REDIRECT_QUERY_STRING'])?$_SERVER['REDIRECT_QUERY_STRING']:NULL);
	define('REDIRECT_URL',isset($_SERVER['REDIRECT_URL'])? substr($_SERVER['REDIRECT_URL'],32):NULL);
	
	#Header
	define('PROJETO','require/img/projeto/');
	define('LOGO','require/img/logos/');
	define('PRODUTO','require/img/produtos/');
?>