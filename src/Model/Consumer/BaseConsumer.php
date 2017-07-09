<?php

namespace Model\Consumer;

use Model\Topic\TopicInterface;

/**
 * Class BaseConsumer
 * @package Model
 */
class BaseConsumer implements ConsumerInterface
{
    CONST FAILURE_BEHAVIOR_IGNORE = 1;
    CONST FAILURE_BEHAVIOR_EXCEPTION = 2;

    /**
     * @var \RdKafka\Consumer
     */
    protected $client;

    /**
     * @var int
     */
    protected $failureBehavior;

    /**
     * @var string
     */
    protected $brokers;

    /**
     * @var TopicInterface[]
     */
    protected $topics;

    /**
     * @var \RdKafka\Queue
     */
    protected $queue;

    /**
     * AbstractConsumer constructor.
     * @param int $failureBehavior
     */
    public function __construct($failureBehavior = self::FAILURE_BEHAVIOR_EXCEPTION)
    {
        $this->client = new \RdKafka\Consumer();
        $this->failureBehavior = $failureBehavior;
        $this->queue = $this->client->newQueue();
    }

    /**
     * Starts consuming
     */
    public function run()
    {
        if (empty($this->brokers)) {
            throw new \Exception('No broker found. Did you forget to add a broker ? Add a broker with $consumer->addBrokers(string $brokers) method.');
        }

        if (empty($this->topics)) {
            throw new \Exception('No topic found. Did you forget to add a topic ? Add a topic with $consumer->addTopic(TopicInterface $topic) method.');
        }

        try {
            if (count($this->topics) > 1) {
                echo nl2br('starting consuming queue...' . PHP_EOL);
                foreach ($this->topics as $topic) {
                    foreach ($topic->getPartitions() as $partition) {
                        $topic->consumeQueueStart($partition, $topic->getOffsetType(), $this->queue);
                    }
                }

                while (true) {
                    $msg = $this->queue->consume(1000);
                    if ($msg->err) {
                        throw new \Exception($msg->errstr());
                        break;
                    } else {
                        echo nl2br($msg->payload . "\n");
                    }
                }
            } else {
                $topic = $this->topics[0];
                echo sprintf(nl2br('starting consuming topic "%s"...' . PHP_EOL), $topic->getName());
                if (empty($topic->getPartitions())) {
                    throw new \Exception(sprintf('No partition found for topic "%s". Did you forget to add a partition to this topic ? Add a partition with $topic->addPartition(new DefaultPartition($identifier)).', $topic->getName()));
                }

                foreach ($topic->getPartitions() as $partition) {
                    $topic->consumeStart($partition, $topic->getOffsetType());
                    $topic->consume($partition, 1000);
                }
            }
        } catch (\Exception $e) {
            if (self::FAILURE_BEHAVIOR_EXCEPTION === $this->failureBehavior) {
                throw $e;
            }
        }
    }

    /**
     * @param string $brokers
     * @return $this
     */
    public function addBrokers(string $brokers)
    {
        $this->brokers = $brokers;
        $this->client->addBrokers($this->brokers);

        return $this;
    }

    /**
     * @return string
     */
    public function getBrokers(): string
    {
        return $this->client->getBrokers();
    }

    /**
     * @return \RdKafka\Consumer
     */
    public function getClient(): \RdKafka\Consumer
    {
        return $this->client;
    }

    /**
     * @param TopicInterface $topic
     * @return $this
     */
    public function addTopic(TopicInterface $topic)
    {
        $topic->setConsumer($this);
        $topic->setKafkaTopic($this->getClient()->newTopic($topic->getName()));
        $this->topics[] = $topic;

        return $this;
    }

    /**
     * @return TopicInterface[]
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * @param int $failureBehavior
     * @return $this
     */
    public function setFailureBehavior(int $failureBehavior)
    {
        $this->failureBehavior = $failureBehavior;

        return $this;
    }

    /**
     * @return int
     */
    public function getFailureBehavior()
    {
        return $this->failureBehavior;
    }


}