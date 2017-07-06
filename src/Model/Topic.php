<?php

namespace Model;

/**
 * Class Topic
 * @package Model
 */
class Topic
{
    /**
     * @var int
     */
    protected $offset;

    /**
     * @var Partition[]
     */
    protected $partitions;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * Topic constructor.
     */
    public function __construct()
    {
        $this->offset = 0;
        $this->partitions = [];
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return Topic
     */
    public function setOffset(int $offset): Topic
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param Partition $partition
     * @return Topic
     */
    public function addPartition(Partition $partition): Topic
    {
        $this->partitions[] = $partition;

        return $this;
    }

    /**
     * @return Partition[]
     */
    public function getPartitions(): array
    {
        return $this->partitions;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     * @return Topic
     */
    public function setCallback(callable $callback): Topic
    {
        $this->callback = $callback;

        return $this;
    }
}