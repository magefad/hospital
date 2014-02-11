<?php
error_reporting(E_ALL);
defined('YII_DEBUG') or define('YII_DEBUG', false);

require_once('phar://' . __DIR__ . '/yii.phar/yiilite.php');
Yii::createWebApplication(__DIR__ . '/protected/config/main.php')->run();
