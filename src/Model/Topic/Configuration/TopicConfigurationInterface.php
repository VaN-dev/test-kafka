<?php

namespace Model\Topic\Configuration;

interface TopicConfigurationInterface
{
    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value);
}