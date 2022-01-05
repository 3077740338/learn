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
| 时间戳小助手 
|----------------------------------------------------------------------------
*/
declare (strict_types=1);
use GuzzleHttp\Psr7\Uri;
if (!function_exists('getTime')) {
    /**
     * 获取当前请求的时间
     * 
     * @param  bool $float 是否使用浮点类型
     * @return integer|float
     */
    function getTime(bool $float = false)
    {
        return $float ? request()->server('REQUEST_TIME_FLOAT') : request()->server('REQUEST_TIME');
    }
}
if (!function_exists('getClientIp')) {
    /**
     * 获取客户端IP地址
     * 
     * @param  bool $all 是否返回所有地址
     * @return string|array|null
     */
    function getClientIp(bool $all = false)
    {
        $ipAddresses = request()->getClientIps();
        return $all ? $ipAddresses : $ipAddresses[0];
    }
}
if (!function_exists('getServerIp')) {
    /**
     * 获取服务器端IP
     * 
     * @param  string $hostname 主机名
     * @return string 失败时返回IPv4地址或当前主机IP地址
     */
    function getServerIp(string $hostname = '') : string
    {
        $uri = new Uri($hostname);
        if ($host = $uri->getHost()) {
            return gethostbyname($host);
        }
        if ('' == $hostname) {
            return gethostbyname(request()->server('SERVER_NAME'));
        }
        $serverIp = gethostbyname($hostname);
        return $serverIp === $hostname ? gethostbyname(request()->server('SERVER_NAME')) : $serverIp;
    }
}