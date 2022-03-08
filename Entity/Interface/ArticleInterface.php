<?php

/**
 * Interface ArticleInterface
 * If we add a new article type, we are sure that our code will work
 */
interface ArticleInterface
{
    public function getName(): string;
    public function getSource(): Source;
    public function getContent(): string;
}