<?php

namespace yunasoft\schema;

class Container
{
    private static $components = [];

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public static function getValue(string $name)
    {
        if (!array_key_exists($name, self::$components)) {
            throw new \Exception(sprintf('Class %s not found', $name));
        }

        return self::$components[$name];
    }

    public static function setValue(string $name, $value)
    {
        self::$components[$name] = $value;
    }

    public function get($name)
    {
        return static::getValue($name);
    }

    public function set(string $name, $value)
    {
        static::setValue($name, $value);
    }
}