<?php

namespace yunasoft\schema;

class Widget extends BaseObject
{
    /**
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public static function widget(array $params = [])
    {
        return (new static($params))->run();
    }

    /**
     * @return string
     */
    public function run()
    {
        return '';
    }

}