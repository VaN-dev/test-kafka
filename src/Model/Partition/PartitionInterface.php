<?php

namespace Model\Partition;

/**
 * Interface PartitionInterface
 * @package Model\Partition
 */
interface PartitionInterface
{
    /**
     * PartitionInterface constructor.
     * @param int $id
     */
    public function __construct(int $id);

    /**
     * @return int
     */
    public function getId() : int;
}