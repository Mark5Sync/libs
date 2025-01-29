<?php

namespace marksync_libs\Redis;

use marksync\provider\Mark;
use Redis;
/**
 * RedisProvider предоставляет доступ к Redis через магический метод __call.
 * 
 * @method bool set(string $key, mixed $value, int $timeout = 0)
 * @method mixed get(string $key)
 * @method bool del(string $key)
 * @method bool expire(string $key, int $seconds)
 * @method array keys(string $pattern)
 * @method bool exists(string $key)
 * @method int incr(string $key)
 * @method int decr(string $key)
 * @method bool hSet(string $key, string $field, mixed $value)
 * @method mixed hGet(string $key, string $field)
 * @method array hGetAll(string $key)
 * @method bool hDel(string $key, string $field)
 * @method bool flushAll()
 */
#[Mark('redis')]
class RedisProvider {
    private Redis $redis;

    function __construct()
    {
        $this->redis = new Redis();
        if (!$this->redis->connect('127.0.0.1')) {
            throw new \RuntimeException('Не удалось подключиться к Redis');
        }
    }

    /**
     * Магический метод для вызова методов Redis.
     * 
     * @param string $name Название метода Redis.
     * @param array $arguments Аргументы метода.
     * @return mixed
     * @throws \BadMethodCallException Если метод не существует.
     */
    public function __call(string $name, array $arguments)
    {
        if (!method_exists($this->redis, $name)) {
            throw new \BadMethodCallException("Метод $name не существует в Redis");
        }

        return $this->redis->{$name}(...$arguments);
    }
}