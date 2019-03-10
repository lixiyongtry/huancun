<?php


namespace Driver\Cache;
use Config;

class Memcached
{
    private static $handle = null;

    public static function init()
    {
        $option = array(
            'host' => Config::get('cache.MEMCACHED_HOST') ?? '127.0.0.1',
            'port' => Config::get('cache.MEMCACHED_PORT') ?? 11211,
        );

        if (!self::$handle){
            self::$handle = new \Memcached();
            self::$handle->addServer($option['host'], $option['port']);
        }
        return self::$handle;
    }

//        $m -> set($key,$value,$expire)
    public static function set($key, $value, $expire = 0)
    {
        if (!self::init()) return false;
        $res = self::init()->set($key,$value,$expire);
        return $res;
    }

    public static function get($key)
    {
        $func = is_array($key)?'getMulti':'get';
        return self::init()->{$func}($key);
    }

//        $m->increment($key)
    public static function incr($key)
    {
        if (!self::init()) return false;
        self::init()->add($key,0);
        return self::init()->increment($key);

    }
}