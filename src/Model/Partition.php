<?php

namespace Model;

/**
 * Class Partition
 * @package Model
 */
class Partition
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Partition constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}