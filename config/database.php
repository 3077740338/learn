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
| 数据库连接配置信息
|----------------------------------------------------------------------------
*/
use Illuminate\Support\Str;
return [
    /*
    |--------------------------------------------------------------------------
    | 默认数据库连接名称
    |--------------------------------------------------------------------------
    |
    | 在这里，您可以指定以下哪种数据库连接是您想要的用作所有数据库工作的默认连接。当然
    | 您可以使用数据库库同时使用多个连接。
    |
    */
    'default' => env('DB_CONNECTION', 'mysql'),
    /*
    |--------------------------------------------------------------------------
    | mysql的sql-mode模式参数
    |--------------------------------------------------------------------------
    */
    'mode' => env('DB_SQLMODE'),
    /*
    |--------------------------------------------------------------------------
    | 数据库连接
    |--------------------------------------------------------------------------
    |
    | 下面是为应用程序设置的每个数据库连接。当然，配置每个数据库平台的示例如下：
    | 下面显示了Laravel的支持，以简化开发。
    |
    | Laravel中的所有数据库工作都是通过PHP PDO工具完成的
    | 因此，请确保您拥有特定数据库的驱动程序
    | 在开始开发之前，请选择安装在计算机上的选项。
    |
    */
    'connections' => [
        //
        'sqlite' => [
            //
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => env('DB_PREFIX'),
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
        'mysql' => [
            //
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'unix_socket' => env('DB_SOCKET'),
            'charset' => env('DB_CHARSET'),
            'collation' => env('DB_COLLATION'),
            'prefix' => env('DB_PREFIX'),
            'prefix_indexes' => env('DB_PREFIX_INDEXES', true),
            'strict' => env('DB_STRICT', true),
            'engine' => env('DB_ENGINE'),
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                //
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                PDO::ATTR_CASE => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES => true,
            ]) : [],
        ],
        'pgsql' => [
            //
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => env('DB_CHARSET'),
            'prefix' => env('DB_PREFIX'),
            'prefix_indexes' => env('DB_PREFIX_INDEXES', true),
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],
        'sqlsrv' => [
            //
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => env('DB_CHARSET'),
            'prefix' => env('DB_PREFIX'),
            'prefix_indexes' => env('DB_PREFIX_INDEXES', true),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | 迁移存储表
    |--------------------------------------------------------------------------
    |
    | 此表跟踪已运行的所有迁移你的申请。利用这些信息，我们可以确定
    | 磁盘上的迁移实际上还没有在数据库中运行。
    |
    */
    'migrations' => 'migrations',
    /*
    |--------------------------------------------------------------------------
    | Redis数据库
    |--------------------------------------------------------------------------
    |
    | Redis是一个开源的、快速的、高级的键值存储，同时
    | 提供比典型的键值系统更丰富的命令体
    | 例如APC或Memcached。Laravel使挖掘变得很容易。
    |
    */
    'redis' => [
        //
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            //
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],
        'default' => [
            //
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],
        'cache' => [
            //
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
    ],
];