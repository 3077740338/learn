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
| 小助手 
|----------------------------------------------------------------------------
*/
declare (strict_types=1);

if (!function_exists('getPath')) {
    /**
     * 获取格式化目录路径
     *
     * @param  string $path
     * @param  bool   $realpath if true-转换为绝对值false-转换为相对,空-保持原样，但是删除////
     * @return string 
     */
    function getPath(string $path = '', bool $realpath = null, $isds = false) : string
    {
        $path = \str_replace(\DIRECTORY_SEPARATOR, \DS, _realpath($path, $realpath));
        $path = $path ? \rtrim($path, '\/') : $path;
        return $isds ? $path . \DS : $path;
    }
}

if (!function_exists('getsiaPath')) {
    /**
     * 获取标准内部访问路径
     *
     * @param  string $path
     * @param  bool   $realpath if true-转换为绝对值false-转换为相对,空-保持原样，但是删除////
     * @return string 
     */
    function getsiaPath(string $path = '', bool $realpath = null) : string
    {
        return \str_replace(\DIRECTORY_SEPARATOR, \DS, _realpath($path, $realpath));
    }
}

if (!function_exists('getseaPath')) {
    /**
     * 获取标准外部访问路径
     *
     * @param  string $path
     * @param  bool   $realpath if true-转换为绝对值false-转换为相对,空-保持原样，但是删除////
     * @return string 
     */
    function getseaPath(string $path = '', bool $realpath = null) : string
    {
        return \str_replace(\DIRECTORY_SEPARATOR, '/', _realpath($path, $realpath));
    }
}