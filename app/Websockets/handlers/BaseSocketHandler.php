<?php

namespace App\Websockets\handlers;

use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\QueryParameters;
use BeyondCode\LaravelWebSockets\WebSockets\Exceptions\UnknownAppKey;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

abstract class BaseSocketHandler implements MessageComponentInterface
{

    protected function verifyAppKey(ConnectionInterface $connection)
    {
        $appKey = QueryParameters::create($connection->httpRequest)->get('appKey');

        if (! $app = App::findByKey($appKey)) {
            throw new UnknownAppKey($appKey);
        }

        $connection->app = $app;

        return $this;
    }

    protected function generateSocketId(ConnectionInterface $connection)
    {
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));

        $connection->socketId = $socketId;

        return $this;
    }

    function onOpen(ConnectionInterface $conn) // коли відкривається нове з'єднання
    {
        dump('on opened');

//        auth logic here

        $this->verifyAppKey($conn)->generateSocketId($conn);


    }

    function onClose(ConnectionInterface $conn) //коли закривається з'єднання
    {
        dump('closed');
    }

    function onError(ConnectionInterface $conn, \Exception $e) //коли виникає якась помилка
    {
        dump($e);
        dump('onerror');
    }
}
