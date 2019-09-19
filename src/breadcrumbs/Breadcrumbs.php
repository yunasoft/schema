<?php

namespace yunasoft\schema\breadcrumbs;

use yunasoft\schema\Widget;

/**
 * Class Breadcrumbs
 * @package yunasoft\schema\breadcrumbs
 *
 * @property array $links
 */
class Breadcrumbs extends Widget
{
    public $links;
    public $options = [];
    public $itemOptions = [];
    public $linkOptions = [];
    public $spanOptions = [];

    public $defaultParams = [
        'options' => [
            'tag' => 'ul',
            'class' => 'breadcrumbs'
        ],
        'itemOptions' => [
            'tag' => 'li'
        ],
        'linkOptions' => [

        ]
    ];

    public function __construct(array $params = [])
    {
        $arrayHelper = $this->container->get('arrayHelper');

        $params = $arrayHelper::merge($this->defaultParams, $params);

        parent::__construct($params);
    }


    public function run()
    {
        $html = $this->container->get('Html');

        $content = '';

        $itemOptions = $this->itemOptions;
        $itemTag = $itemOptions['tag'];

        unset($itemOptions['tag']);

        foreach ($this->links as $params) {

            $model = new Link($params);

            $content .= $html::tag(
                $itemTag,
                $this->createLink($model),
                $itemOptions
            );

        }

        $options = $this->options;
        $tag = $options['tag'];

        return $html::tag($tag, $content, $options);
    }

    /**
     * @param Link $link
     * @return string
     */
    private function createLink($link)
    {
        $html = $this->container->get('Html');
        $arrayHelper = $this->container->get('arrayHelper');

        $options = trim($link->url) !== '' ? $this->linkOptions : $this->spanOptions;
        $options = $arrayHelper::merge($options, $link->options);

        $tag = $options['tag'];

        return $html::tag($tag, $link->label, $options);
    }
}