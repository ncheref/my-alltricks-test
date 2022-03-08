<?php
require('Utils/Utils.php');
require('Entity/Article.php');
require('LoadArticle/LoadFromDB.php');
require('LoadArticle/LoadFromFluxRSS.php');

class ArticleAgregator implements IteratorAggregate
{
    /** @var array $articles */
    private $articles = [];

    /**
     * @inheritDoc
     * When looping over an ArticleAgregator object, we browse the property items.
     */
    public function getIterator()
    {
        return new ArrayIterator($this->articles);
    }

    /**
     * @param string $type
     * @param array $params
     * @throws Exception
     */
    public function appendArticles(string $type, array $params)
    {
        switch ($type) {
            case FROM_BDD:
                $load = new LoadFromDB($params);
                break;
            case FROM_FLUX_RSS:
                $load = new LoadFromFluxRSS($params);
                break;
            default:
                throw new Exception('Unknown param');
        }

        $this->articles = array_merge($this->articles, $load->getArticles());
    }
}
