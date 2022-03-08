<?php

/**
 * Class Source
 */
class Source
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /**
     * Source constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     *
     * @return Source
     */
    public function setName(string $name): Source
    {
        $this->name = $name;

        return $this;
    }
}