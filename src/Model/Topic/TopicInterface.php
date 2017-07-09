<?php

namespace Model\Topic;

use Model\Consumer\ConsumerInterface;
use Model\Partition\PartitionInterface;
use Model\Topic\Configuration\TopicConfigurationInterface;

/**
 * Interface TopicInterface
 * @package Model\Topic
 */
interface TopicInterface
{
    /**
     * TopicInterface constructor.
     * @param string $name
     * @param array $partitions
     * @param TopicConfigurationInterface $topicConfiguration
     * @param $offsetType
     */
    public function __construct(string $name, array $partitions, TopicConfigurationInterface $topicConfiguration, $offsetType);

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param PartitionInterface $partition
     * @param $timeout
     */
    public function consume(PartitionInterface $partition, int $timeout);

    /**
     * @param PartitionInterface $partition
     * @param $offsetType
     */
    public function consumeStart(PartitionInterface $partition, $offsetType);

    /**
     * @param PartitionInterface $partition
     * @param int $offsetType
     * @param \RdKafka\Queue $queue
     */
    public function consumeQueueStart(PartitionInterface $partition, int $offsetType, \RdKafka\Queue $queue);

    /**
     * @param ConsumerInterface $consumer
     * @return TopicInterface
     */
    public function setConsumer(ConsumerInterface $consumer) : TopicInterface;

    /**
     * @return ConsumerInterface
     */
    public function getConsumer() : ConsumerInterface;

    /**
     * @return TopicInterface
     */
    public function setKafkaTopic(\RdKafka\Topic $kafkaTopic) : TopicInterface;

    /**
     * @param $offsetType
     * @return TopicInterface
     */
    public function setOffsetType($offsetType): TopicInterface;

    /**
     * @return int
     */
    public function getOffsetType() : int;

    /**
     * @param PartitionInterface $partition
     * @return TopicInterface
     */
    public function addPartition(PartitionInterface $partition) : TopicInterface;

    /**
     * @return PartitionInterface[]
     */
    public function getPartitions();

    /**
     * @param callable $callback
     * @return TopicInterface
     */
    public function setCallback(callable $callback) : TopicInterface;
}