<?php

class LoadFromFluxRSS implements LoadArticleInterface
{
    /** @var array $params */
    private $params = [];

    /**
     * LoadFromDB constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get array of Articles
     * @return array
     */
    public function getArticles(): array
    {
        // Load XML object
        $xml = simplexml_load_file($this->params['url']);
        // XML object to a php array
        $articlesArrayFromXml = Utils::xmlToArray($xml);

//        Problem with CDATA
//        $articlesArrayFromXml =json_decode(json_encode((array) simplexml_load_file($sourceWebsite)), 1);
        $articlesInfos = [];

        // Format data
        foreach ($articlesArrayFromXml['channel']['item'] as $articleFromXml) {
            $articlesInfos[] = [
                'name' => $articleFromXml['title'],
                'sourceName' => $this->params['sourceName'],
                'content' => $articleFromXml['description'],
            ];
        }

        return Utils::arrayToArticles($articlesInfos);
    }
}