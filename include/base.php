<?php
/*
|----------------------------------------------------------------------------
| TOP-WINDOW [ Internet Ecological traffic aggregation and sharing platform ]
|----------------------------------------------------------------------------
| Copyright (c) 2006-2019 http://yangrong1.cn All rights reserved.
|----------------------------------------------------------------------------
| Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
|----------------------------------------------------------------------------
| Author: yangrong <yangrong2@gmail.com>
|----------------------------------------------------------------------------
| 框架引导文件
|----------------------------------------------------------------------------
*/

define('CFG_SOFTNAME', 'TOP-WINDOW');
define('LARAVEL_START', microtime(true));
define('LARAVEL_START_MEM', memory_get_usage(true));

/*
|----------------------------------------------------------------------------
| 支付宝 - 是否处于开发模式
|----------------------------------------------------------------------------
*/
defined('AOP_SDK_DEV_MODE') or define('AOP_SDK_DEV_MODE', false);

/*
|----------------------------------------------------------------------------
| 间隔符
|----------------------------------------------------------------------------
*/
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('PS') or define('PS', PATH_SEPARATOR);

/*
|----------------------------------------------------------------------------
| 安装程序定义
|----------------------------------------------------------------------------
*/
define('DEFAULT_INSTALL_DATE', 1586690572);

/*
|----------------------------------------------------------------------------
| 序列号
|----------------------------------------------------------------------------
*/
define('DEFAULT_SERIALNUMBER', '20200412072200oCWIoa');

/*
|----------------------------------------------------------------------------
| 缓存时间
|----------------------------------------------------------------------------
*/
defined('CACHE_TIME') or define('CACHE_TIME', 86400);

/*
|----------------------------------------------------------------------------
| 编辑器图片上传相对路径
|----------------------------------------------------------------------------
*/
defined('UPLOAD_NAME') or define('UPLOAD_NAME', 'uploads');
defined('UPLOAD_PATH') or define('UPLOAD_PATH', UPLOAD_NAME . DS);

/*
|----------------------------------------------------------------------------
| 网站根目录
|----------------------------------------------------------------------------
*/
defined('ROOT') or define('ROOT', realpath(dirname(__DIR__)));

/*
|----------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|----------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (is_file($mainTenanceFile = realpath($raw = ROOT . '/storage/framework/maintenance.php') ?: $raw) && (\PHP_SAPI !== 'cli' || \PHP_SAPI !== 'phpdbg')) {
    require $mainTenanceFile;
}

/*
|----------------------------------------------------------------------------
| Global common functions
|----------------------------------------------------------------------------
|
| Global functions should be as concise as possible.
|
*/

if (!is_file($globalFunctionsFile = __DIR__ . DIRECTORY_SEPARATOR . 'functions.php')) {
    exit(sprintf('Unable to load the requested file:"%s" .', $globalFunctionsFile));
}
require $globalFunctionsFile;

/*
|----------------------------------------------------------------------------
| Loading assistant configuration
|----------------------------------------------------------------------------
|
| After loading, initialize it by default. If there is no loading 
| configuration, initialize a default helper configuration
|
*/

if (is_file($helper_conf = __DIR__ . DIRECTORY_SEPARATOR . 'helper.conf.php') && function_exists('helper') && function_exists('helpers')) {
    $cfg_helper_autoload = __include_file($helper_conf);
    // If no configuration is loaded, a default helper configuration is initialized
    $cfg_helper_autoload = is_array($cfg_helper_autoload) ? $cfg_helper_autoload : array($cfg_helper_autoload);
    // Initialization assistant
    helpers($cfg_helper_autoload);
    unset($cfg_helper_autoload);
}

/*
|----------------------------------------------------------------------------
| Register The Auto Loader
|----------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

if (!is_file($vendorAutoLoadFile = realpath($raw = ROOT . '/vendor/autoload.php') ?: $raw)) {
    exit(sprintf('Unable to load the requested file:"%s" .', $vendorAutoLoadFile));
}
__require_file($vendorAutoLoadFile);

unset($mainTenanceFile, $globalFunctionsFile, $helper_conf, $vendorAutoLoadFile, $raw);

/*
|----------------------------------------------------------------------------
| The End
|----------------------------------------------------------------------------
*/