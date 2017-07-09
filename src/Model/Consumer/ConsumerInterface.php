<?php

namespace Model\Consumer;

use Model\Topic\TopicInterface;

/**
 * Interface ConsumerInterface
 * @package Model
 */
interface ConsumerInterface
{
    /**
     * @return mixed
     */
    public function run();

    /**
     * @return mixed
     */
    public function getClient() : \RdKafka\Consumer;

    /**
     * @param string $brokers
     * @return $this
     */
    public function addBrokers(string $brokers);

    /**
     * @return string
     */
    public function getBrokers() : string;

    /**
     * @param TopicInterface $topic
     * @return $this
     */
    public function addTopic(TopicInterface $topic);

    /**
     * @return TopicInterface[]
     */
    public function getTopics();

    /**
     * @param int $failureBehavior
     * @return $this
     */
    public function setFailureBehavior(int $failureBehavior);

    /**
     * @return int
     */
    public function getFailureBehavior();
}