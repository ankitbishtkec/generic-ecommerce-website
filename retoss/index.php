<!--Author: Ankit Bisht
Author email: ankit.bisht.kec@gmail.com, ankit.bisht.com@gmail.com
Author LinkedIn profile: https://in.linkedin.com/pub/ankit-bisht/16/a6/167
License: Apache License 2.0
License URL: http://www.apache.org/licenses/LICENSE-2.0.html
-->
<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/protected/extensions/bootstrap');//ankit

Yii::createWebApplication($config)->run();
