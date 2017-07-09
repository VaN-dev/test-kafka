<?php

namespace Model\Topic\Configuration;

/**
 * Class StorageAwareTopicConfiguration
 * @package Model\Topic
 */
class StorageAwareTopicConfiguration extends BaseTopicConfiguration  implements TopicConfigurationInterface, StorageAwareTopicConfigurationInterface
{
    /**
     * @param $method
     * @return $this
     * @throws \Exception
     */
    public function setStorageMethod($method)
    {
        if (false === in_array($method, $this->_storeMethods)) {
            throw new \Exception(sprintf('Offset storage method "%s" unavailable. Available storage methods are: %s', $method, implode(', ', $this->_storeMethods)));
        }

        $this->setOption('offset.store.method', $method);

        return $this;
    }

    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function setStoragePath($path)
    {
        if (false === is_dir($path)) {
            throw new \Exception(sprintf('%s is not a valid directory.', $path));
        }

        if (false === is_writable($path)) {
            throw new \Exception(sprintf('%s is not writable.', $path));
        }

        $this->setOption('offset.store.path', $path);

        return $this;
    }
}