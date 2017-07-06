<?php

namespace Model;

/**
 * Interface ConsumerInterface
 * @package Model
 */
interface ConsumerInterface
{
    /**
     * @return void
     */
    public function run();

    /**
     * @param Topic $topic
     * @return $this
     */
    public function addTopic(Topic $topic);

    /**
     * @return Topic[]
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