<?php
$GLOBALS['DB'] = new PDO('mysql:host=localhost;dbname=soluche', 'soluche', 'soluche');
$GLOBALS['DB']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
