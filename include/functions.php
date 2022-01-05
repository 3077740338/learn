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
| 全局函数存放文件
|----------------------------------------------------------------------------
*/
define('LOADER_START', true);
if (!function_exists('make')) {
    /**
     * 创建密码的散列
     * @param  string $password 用户的密码
     * @param  mixed  $algo     一个用来在散列密码时指示算法的密码算法常量
     * @param  array  $options  一个包含有选项的关联数组
     * @return string
     * @throws RuntimeException
     */
    function make($password, $algo = \PASSWORD_BCRYPT, $options = ['cost' => 10])
    {
        $hash = password_hash(mb_strtolower($password, 'UTF-8'), $algo, $options);
        if ($hash === false) {
            throw new \RuntimeException('Bcrypt hashing not supported.');
        }
        return $hash;
    }
}
if (!function_exists('check')) {
    /**
     * 验证密码是否和散列值匹配
     * @param  string $password 用户的密码
     * @param  string $hash     一个由 make() 创建的散列值
     * @return bool 
     */
    function check($password, $hash)
    {
        if (strlen($hash) === 0) {
            return false;
        }
        return password_verify(mb_strtolower($password, 'UTF-8'), $hash);
    }
}
if (!function_exists('write_file')) {
    /**
     * 以安全的方式将文件写入磁盘
     * @param string $_filepath   完整的文件路径
     * @param string $_contents   文件内容
     * @param int    $_file_perms 文件权限   
     * @param int    $dir_perms   目录权限
     * @throws \RuntimeException
     * @return boolean 
     */
    function write_file($_filepath, $_contents, $_file_perms = null, $_dir_perms = null)
    {
        $_filepath = _realpath($_filepath);
        $_error_reporting = error_reporting();
        error_reporting($_error_reporting & ~\E_NOTICE & ~\E_WARNING);
        $_file_perms = is_int($_file_perms) ? $_file_perms : 0644;
        $_dir_perms = !is_null($_dir_perms) ? is_int($_dir_perms) ? $_dir_perms : 0777 : 0771;
        if ($_file_perms !== null) {
            $old_umask = umask(0);
        }
        $_dirpath = dirname($_filepath);
        // if subdirs, create dir structure
        if ($_dirpath !== '.') {
            $i = 0;
            // loop if concurrency problem occurs
            while (!is_dir($_dirpath)) {
                if (@mkdir($_dirpath, $_dir_perms, true)) {
                    break;
                }
                clearstatcache();
                if (++$i === 3) {
                    error_reporting($_error_reporting);
                    throw new \RuntimeException(sprintf('unable to create directory :"%s" .', $_dirpath));
                }
                sleep(1);
            }
        }
        // write to tmp file, then move to overt file lock race condition
        $_tmp_file = $_dirpath . DIRECTORY_SEPARATOR . str_replace(array('.', ','), '_', uniqid('wrt', true));
        if (!file_put_contents($_tmp_file, $_contents)) {
            error_reporting($_error_reporting);
            throw new \RuntimeException(sprintf('unable to write file :"%s" .', $_tmp_file));
        }
        /*
         * Windows' rename() fails if the destination exists,
         * Linux' rename() properly handles the overwrite.
         * Simply unlink()ing a file might cause other processes
         * currently reading that file to fail, but linux' rename()
         * seems to be smart enough to handle that for us.
         */
        if (strpos(\PHP_OS, 'WIN') !== false || \PHP_OS_FAMILY === 'Windows') {
            // remove original file
            if (is_file($_filepath)) {
                @unlink($_filepath);
            }
            // rename tmp file
            $success = @rename($_tmp_file, $_filepath);
        } else {
            // rename tmp file
            $success = @rename($_tmp_file, $_filepath);
            if (!$success) {
                // remove original file
                if (is_file($_filepath)) {
                    @unlink($_filepath);
                }
                // rename tmp file
                $success = @rename($_tmp_file, $_filepath);
            }
        }
        if (!$success) {
            error_reporting($_error_reporting);
            throw new \RuntimeException(sprintf('unable to write file :"%s" .', $_filepath));
        }
        if ($_file_perms !== null) {
            // set file permissions
            chmod($_filepath, $_file_perms);
            umask($old_umask);
        }
        error_reporting($_error_reporting);
        return true;
    }
}
if (!function_exists('_realpath')) {
    /**
     * 规范化路径-删除/-如果需要，将其设为绝对值
     * @param string $path     文件路径
     * @param bool   $realpath if true-转换为绝对值false-转换为相对,空-保持原样，但是删除/
     * @return string
     */
    function _realpath($path, $realpath = null)
    {
        $resolver = function ($path, $realpath) {
            $nds = array('/' => '\\', '\\' => '/');
            \preg_match('%^(?<root>(?:[[:alpha:]]:[\\\\/]|/|[\\\\]{2}[[:alpha:]]+|[[:print:]]{2,}:[/]{2}|[\\\\])?)(?<path>(.*))$%u', $path, $parts);
            $path = $parts['path'];
            if ($parts['root'] === '\\') {
                $parts['root'] = \substr(\getcwd(), 0, 2) . $parts['root'];
            } else {
                if ($realpath !== null && !$parts['root']) {
                    $path = \getcwd() . \DIRECTORY_SEPARATOR . $path;
                }
            }
            // 规范化目录分隔符
            $path = \str_replace($nds[\DIRECTORY_SEPARATOR], \DIRECTORY_SEPARATOR, $path);
            $parts['root'] = \str_replace($nds[\DIRECTORY_SEPARATOR], \DIRECTORY_SEPARATOR, $parts['root']);
            do {
                $path = \preg_replace(array('#[\\\\/]{2}#', '#[\\\\/][.][\\\\/]#', '#[\\\\/]([^\\\\/.]+)[\\\\/][.][.][\\\\/]#'), \DIRECTORY_SEPARATOR, $path, -1, $count);
            } while ($count > 0);
            return $realpath !== false ? $parts['root'] . $path : \str_ireplace(\getcwd(), '.', $parts['root'] . $path);
        };
        try {
            return call_user_func($resolver, $path, $realpath);
        } catch (\Throwable $e) {
            try {
                return call_user_func($resolver, pathinfo($path, PATHINFO_DIRNAME), $realpath) . DIRECTORY_SEPARATOR . pathinfo($path, PATHINFO_BASENAME);
            } catch (\Throwable $e) {
                throw $e;
            }
        }
    }
}
if (!function_exists('parse_name')) {
    /**
     * 字符串命名风格转换
     * type 0 将 Java 风格转换为 C 的风格 1 将 C 风格转换为 Java 的风格
     * @param  string  $name    字符串
     * @param  integer $type    转换类型
     * @param  bool    $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    function parse_name($name, $type = 0, $ucfirst = true)
    {
        $name = str_replace('-', '_', $name);
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}
if (!function_exists('helper')) {
    /**
     *  载入小助手,系统默认载入小助手
     *  在/include/helper.conf.php中进行默认小助手初始化的设置
     *  使用示例:
     *      在开发中,首先需要创建一个小助手函数,目录在\include\helpers中
     *  例如,我们创建一个示例为test.helper.php,文件基本内容如下:
     *  <code>
     *  if ( ! function_exists('Hello'))
     *  {
     *      function Hello()
     *      {
     *          echo "Hello! ...";
     *      }
     *  }
     *  </code>
     *  则我们在开发中使用这个小助手的时候直接使用函数helper('test');初始化它
     *  然后在文件中就可以直接使用:Hello();来进行调用.
     *
     * @param     string   $helper  小助手名称
     * @return    void
     */
    function helper(string $helper)
    {
        static $_helpers = [];
        if (isset($_helpers[$helper])) {
            return;
        }
        if (is_file($helper_file = _realpath(__DIR__ . '/helpers/' . $helper . '.helper.php'))) {
            __require_file($helper_file);
            $_helpers[$helper] = 'Helper::[' . $helper . ']->isLoadTrue';
        }
        // 无法载入小助手
        if (!isset($_helpers[$helper])) {
            throw new \RuntimeException(sprintf('File "%s" could not be found.', $helper));
        }
    }
}
if (!function_exists('helpers')) {
    /**
     *  载入小助手,这里用户可能用helps载入多个小助手
     *
     * @access    public
     * @param     array $helpers
     * @return    void
     */
    function helpers(array $helpers)
    {
        foreach ($helpers as $helper) {
            helper($helper);
        }
    }
}
if (!function_exists('__include_file')) {
    /**
     * 作用范围隔离
     * include
     * @param  string $file 文件路径
     * @return mixed
     */
    function __include_file($file)
    {
        return include $file;
    }
}
if (!function_exists('__require_file')) {
    /**
     * 作用范围隔离
     * require
     * @param  string $file 文件路径
     * @return mixed
     */
    function __require_file($file)
    {
        return require $file;
    }
}