<?php

namespace Model\Topic\Configuration;

interface StorageAwareTopicConfigurationInterface
{
    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value);
}