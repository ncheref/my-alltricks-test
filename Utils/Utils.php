<?php

class Utils
{
    /**
     * Get a new connection to the MySQL server
     *
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $database
     *
     * @return false|mysqli
     */
    public static function getDbConnexion(string $hostname, string $username, string $password, string $database)
    {
        $mysqli = mysqli_connect($hostname, $username, $password, $database);
        if ($mysqli->connect_errno) {
            throw new RuntimeException('mysqli connection error: ' . $mysqli->connect_error);
        }
        return $mysqli;
    }

    /**
     * Search element in DB by $field with a specific $value
     * @param $field
     * @param $value
     * @param $tableName
     * @return array|null
     */
    public static function searchElementInDB($field, $value, $tableName)
    {
        $mysqli = self::getDbConnexion(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $query = "
            SELECT *
            FROM $tableName
            WHERE $field = '$value'
        ";

        $result = $mysqli->query($query);

        // Close connexion to DB
        mysqli_close($mysqli);

        return $result->fetch_assoc();
    }

    /**
     * @param string $name
     */
    public static function insertSource(string $name)
    {
        $mysqli = self::getDbConnexion(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $query = "INSERT INTO source (NAME) VALUES (?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $name);
        $stmt->execute();

        // Close connexion to DB
        mysqli_close($mysqli);
    }

    /**
     * Transform XML to array
     * @param $xml
     * @return array|string
     */
    public static function xmlToArray($xml)
    {
        $array = (array)$xml;

        if (count($array) === 0) {
            return (string)$xml;
        }

        foreach ($array as $key => $value) {
            if (is_object($value) && strpos(get_class($value), 'SimpleXML') > -1) {
                $array[$key] = self::xmlToArray($value);
            } else if (is_array($value)) {
                $array[$key] = self::xmlToArray($value);
            } else {
                continue;
            }
        }

        return $array;
    }

    /**
     * $rows array of arrays : each array contains at least 3 informations (keys) : name, sourceName, content
     * @param array $rows
     * @return array
     */
    public static function arrayToArticles(array $rows)
    {
        $articles = [];

        // Instantiate $articles objects and add them to $this->articles
        foreach ($rows as $row) {
            $source = self::searchElementInDB('name', $row['sourceName'], 'source');

            if ($source) {
                $source = new Source($source['name']);
            } else {
                // Insert source to DB if not exists
                self::insertSource($row['sourceName']);
                $source = new Source($row['sourceName']);
            }

            $article = new Article($row['name'], $source, $row['content']);
            $articles[] = $article;
        }

        return $articles;
    }
}