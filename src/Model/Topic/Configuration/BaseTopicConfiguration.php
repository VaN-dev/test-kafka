<?php

namespace Model\Topic\Configuration;

/**
 * Class BaseTopicConfiguration
 * @package Model\Topic
 */
class BaseTopicConfiguration
{
    protected $_storeMethods = [
        'file',
        'broker',
    ];

    /**
     * @var \RdKafka\TopicConf
     */
    protected $kafkaTopicConfiguration;

    /**
     * AbstractTopicConfiguration constructor.
     */
    public function __construct()
    {
        $this->kafkaTopicConfiguration = new \RdKafka\TopicConf();
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->kafkaTopicConfiguration->set($key, $value);

        return $this;
    }
}