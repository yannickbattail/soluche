<?php
$GLOBALS['DB'] = new PDO('mysql:host=localhost;dbname=soluche', 'soluche', 'soluche');
$GLOBALS['DB']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$GLOBALS['DB']->query("SET character_set_results=utf8");
$GLOBALS['DB']->query("set names 'utf8'");
