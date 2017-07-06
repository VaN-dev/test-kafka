<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Model\AbstractConsumer;
use Model\Consumer;
use Model\Partition;
use Model\Topic;

$partition = new Partition('partition-1');
$topic = new Topic();
$topic
    ->addPartition($partition)
    ->setCallback(function () {
        echo 'I\'m a callback!';
    })
;

$consumer = new Consumer(AbstractConsumer::FAILURE_BEHAVIOR_EXCEPTION);
$consumer->addTopic($topic);

dump($consumer);

echo $consumer->getFailureBehavior();