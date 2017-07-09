<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Model\Consumer\BaseConsumer;
use Model\Topic\BaseTopic;
use Model\Topic\Configuration\StorageAwareTopicConfiguration;

try {
    // init consumer
    $consumer = new BaseConsumer();
    $consumer->addBrokers('127.0.0.1:9092');

    // loading conf
    $configuration = new StorageAwareTopicConfiguration();
    $configuration->setStorageMethod('file');

    // loading topics
    $topic1 = new BaseTopic('topic-test-callback', [0], $configuration);
    $topic1->setCallback(function () {
        echo nl2br(PHP_EOL . '<em>-- I\'m a callback!</em>' . PHP_EOL);
    });
    $consumer->addTopic($topic1);

    // uncomment the following line to start a queue consumption
    // $consumer->addTopic(new BaseTopic('topic-test', [0]));

    // consuming
    $consumer->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

echo '<h1>Kafka Consumer Framework</h1>';
echo '<h2>Concrete Consumer</h2>';
dump($consumer);

echo '<h2>Available methods</h2>';
dump(get_class_methods($consumer));