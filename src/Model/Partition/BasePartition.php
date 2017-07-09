<?php

namespace Model\Partition;

/**
 * Class BasePartition
 * @package Model\Partition
 */
class BasePartition implements PartitionInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * AbstractPartition constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }
}