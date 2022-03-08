<?php
require('Entity/Source.php');

trait ArticleTrait
{
    /** @var string $name */
    private $name;

    /** @var Source $sourceId */
    private $source;

    /** @var string $content */
    private $content;

    /**
     * ArticleTrait constructor.
     * @param string $name
     * @param Source $source
     * @param string $content
     */
    public function __construct(string $name, Source $source, string $content)
    {
        $this->name = $name;
        $this->source = $source;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }

    /**
     * @param Source $source
     */
    public function setSource(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSourceName(): string
    {
        return $this->source ? $this->source->getName() : null;
    }

    /**
     * @return string
     */
    public function getContent() :string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}