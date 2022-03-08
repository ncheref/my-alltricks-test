<?php
require('LoadArticleInterface.php');

class LoadFromDB implements LoadArticleInterface
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
        // Get a connexion to DB
        $mysqli = Utils::getDbConnexion($this->params['hostname'], $this->params['username'], $this->params['password'], $this->params['database']);

        // Prepare the query to get articles to display
        $query = 'SELECT article.name, source.name as sourceName, article.content
                  from article
                inner join source on article.source_id = source.id
        ';

        // Execute query and get results
        $result = $mysqli->query($query);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Free the memory associated with a result
        mysqli_free_result($result);

        // Close connexion to DB
        mysqli_close($mysqli);

        return Utils::arrayToArticles($rows);
    }
}