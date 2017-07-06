<?php

namespace Model;

/**
 * Class AbstractConsumer
 * @package Model
 */
abstract class AbstractConsumer implements ConsumerInterface
{
    CONST FAILURE_BEHAVIOR_IGNORE = 1;
    CONST FAILURE_BEHAVIOR_EXCEPTION = 2;

    /**
     * @var int
     */
    protected $failureBehavior;

    /**
     * @var Topic[]
     */
    protected $topics;

    /**
     * AbstractConsumer constructor.
     * @param int $failureBehavior
     */
    public function __construct($failureBehavior = self::FAILURE_BEHAVIOR_IGNORE)
    {
        $this->failureBehavior = $failureBehavior;
    }

    /**
     *
     */
    public function run()
    {
        // TODO: Implement run() method.
    }

    /**
     * @param Topic $topic
     * @return $this
     */
    public function addTopic(Topic $topic)
    {
        $this->topics[] = $topic;

        return $this;
    }

    /**
     * @return Topic[]
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