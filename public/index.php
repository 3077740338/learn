<?php
/*
|----------------------------------------------------------------------------
| TopWindow [ Internet Ecological traffic aggregation and sharing platform ]
|----------------------------------------------------------------------------
| Copyright (c) 2006-2019 http://yangrong1.cn All rights reserved.
|----------------------------------------------------------------------------
| Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
|----------------------------------------------------------------------------
| Author: yangrong <yangrong2@gmail.com>
|----------------------------------------------------------------------------
| 应用入口
|----------------------------------------------------------------------------
*/

use Learn\Foundation\Application;

/*
|----------------------------------------------------------------------------
| Load the base configuration file
|----------------------------------------------------------------------------
|
| Before running the program, we need to configure some global parameters,
| which can be reflected in the basic configuration file.
|
*/

if (!is_file($baseFile = realpath($raw = dirname(__DIR__) . '/include/base.php') ?: $raw)) {
    exit(sprintf('Unable to load the requested file:"%s" .', $baseFile));
}
require $baseFile;

/*
|----------------------------------------------------------------------------
| Run The Application
|----------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

return Application::run();

/*
|----------------------------------------------------------------------------
| The End
|----------------------------------------------------------------------------
*/