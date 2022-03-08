<?php

require('Interface/ArticleInterface.php');
require('Trait/ArticleTrait.php');

class Article implements ArticleInterface
{
    use ArticleTrait;

    /** @var int $id */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}