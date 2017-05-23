<?php
$pdo = new PDO('mysql:dbname=corentinnrgsb;host=corentinnrgsb.mysql.db', 'corentinnrgsb', 'HMch4ju5Qu3P');

$pdo->exec("SET CHARACTER SET utf8");

$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);