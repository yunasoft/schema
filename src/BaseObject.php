<?php

namespace yunasoft\schema;

/**
 * Class BaseObject
 * @package yunasoft\schema
 *
 * @property Container $container
 */
class BaseObject extends Object
{
    public $container;

    private $containerParams = [
        '__class' => Container::class
    ];

    /**
     * Breadcrumbs constructor.
     * @param array $params
     * @throws \Exception
     */
    public function __construct(array $params = [])
    {
        if (
            !array_key_exists('container', $params)
            || (is_array($params['container']) && !array_key_exists('__class', $params['container']))
        ) {
            $params['container'] = $this->createObject($this->containerParams);
        }

        $this->container = $params['container'];

        $objectParams = $this->createObjectParams($params, $this->container);
        foreach ($objectParams as $key => $value) {
            $this->{$key} = $value;
        }
    }

    private function createObject($params)
    {
        $class = $params['__class'];
        unset($params['__class']);
        return new $class($params);
    }

    private function createObjectParams($params, $container)
    {
        $result = [];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('__class', $value)) {
                    $value['container'] = $container;
                    $result[$key] = $this->createObject($value);
                } else {
                    $property = [];
                    foreach ($value as $k => $v) {
                        if (is_array($v)) {
                            $property[$k] = $this->createObjectParams($v, $container);
                        }
                    }
                    $result[$key] = $property;
                }
            } else {
                $result[$key] = $params;
            }
        }

        return $result;
    }
}