<?php

namespace Model\Topic;

use Model\Consumer\ConsumerInterface;
use Model\Partition\BasePartition;
use Model\Partition\PartitionInterface;
use Model\Topic\Configuration\TopicConfigurationInterface;

/**
 * Class BaseTopic
 * @package Model
 */
class BaseTopic implements TopicInterface
{
    /**
     * @var ConsumerInterface
     */
    protected $consumer;

    /**
     * @var \RdKafka\Topic
     */
    protected $kafkaTopic;

    /**
     * @var TopicConfigurationInterface
     */
    protected $configuration;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $offsetType;

    /**
     * @var PartitionInterface[]
     */
    protected $partitions;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * BaseTopic constructor.
     * @param string $name
     * @param array $partitions
     * @param TopicConfigurationInterface|null $configuration
     * @param int $offsetType
     */
    public function __construct(string $name, array $partitions, TopicConfigurationInterface $configuration = null, $offsetType = RD_KAFKA_OFFSET_BEGINNING)
    {
        $this->name = $name;
        $this->configuration = $configuration;
        $this->offsetType = $offsetType;

        foreach ($partitions as $partition) {
            $this->addPartition(new BasePartition($partition));
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param PartitionInterface $partition
     * @param int $timeout
     * @throws \Exception
     */
    public function consume(PartitionInterface $partition, int $timeout)
    {
        while (true) {
            $msg = $this->kafkaTopic->consume($partition->getId(), $timeout);

            if (null !== $msg ) {
                if ($msg->err) {
                    throw new \Exception($msg->errstr());
                } else {
                    echo nl2br($msg->payload . "\n");

                    if (null !== $this->callback) {
                        call_user_func($this->callback);
                    }
                }
            }
        }
    }

    /**
     * @param PartitionInterface $partition
     * @param $offsetType
     */
    public function consumeStart(PartitionInterface $partition, $offsetType)
    {
        $this->kafkaTopic->consumeStart($partition->getId(), $offsetType);
    }

    /**
     * @param PartitionInterface $partition
     * @param int $offsetType
     * @param \RdKafka\Queue $queue
     */
    public function consumeQueueStart(PartitionInterface $partition, int $offsetType, \RdKafka\Queue $queue)
    {
        $this->kafkaTopic->consumeQueueStart($partition->getId(), $offsetType, $queue);
    }

    /**
     * @param ConsumerInterface $consumer
     * @return TopicInterface
     */
    public function setConsumer(ConsumerInterface $consumer): TopicInterface
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * @return ConsumerInterface
     */
    public function getConsumer(): ConsumerInterface
    {
        return $this->consumer;
    }

    /**
     * @param \RdKafka\Topic $kafkaTopic
     * @return TopicInterface
     */
    public function setKafkaTopic(\RdKafka\Topic $kafkaTopic): TopicInterface
    {
        $this->kafkaTopic = $kafkaTopic;

        return $this;
    }

    /**
     * @param $offsetType
     * @return TopicInterface
     */
    public function setOffsetType($offsetType): TopicInterface
    {
        $this->offsetType = $offsetType;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffsetType(): int
    {
        return $this->offsetType;
    }

    /**
     * @param PartitionInterface $partition
     * @return TopicInterface
     */
    public function addPartition(PartitionInterface $partition): TopicInterface
    {
        $this->partitions[] = $partition;

        return $this;
    }

    /**
     * @return PartitionInterface[]
     */
    public function getPartitions()
    {
        return $this->partitions;
    }

    /**
     * @param callable $callback
     * @return TopicInterface
     */
    public function setCallback(callable $callback): TopicInterface
    {
        $this->callback = $callback;

        return $this;
    }
}