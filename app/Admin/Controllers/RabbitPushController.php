<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/29
 * Time: 10:11
 */

namespace App\Admin\Controllers;

use App\Jobs\SendWelcomeEmail;CallQueuedHandler
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitPushController
{
    public function send()
    {
        $connection = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false,  false, false, false);

        $msg = new AMQPMessage('Hello Message');
        $channel->basic_publish($msg, '', 'hello');

        dump("[x] Sent 'Hello Message!'\n");

        $channel->close();
        $connection->close();
    }

    public function receive()
    {
        $connection = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

    public function queue()
    {
        dispatch(new SendWelcomeEmail('Hello Message'));
    }
}