<?php

namespace App\Websockets\handlers;

use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\QueryParameters;
use BeyondCode\LaravelWebSockets\WebSockets\Exceptions\UnknownAppKey;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use Illuminate\Support\Facades\Log;

class CustomHandler extends BaseSocketHandler implements MessageComponentInterface
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
        Log::debug("CustomHandler __construct");
    }

    function onOpen(ConnectionInterface $conn)
    {
        parent::onOpen($conn);
//        auth logic here
        //$this->verifyAppKey($conn)->generateSocketId($conn);
        $this->clients->attach($conn);
        Log::debug("NEW connection = {$conn->resourceId}");
        echo "NEW connection = {$conn->resourceId}";
    }

    function onMessage(ConnectionInterface $from, MessageInterface $msg) // сюди приходить повідомлення від клієнта
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n",
        $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's'
        );
        foreach ($this->clients as $client) {
            //$client->send($msg);
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    function onClose(ConnectionInterface $conn) //коли закривається з'єднання
    {
        //Log::debug("connection close = {$conn->resourceId}");
        echo "connection close = {$conn->resourceId}";
        $this->clients->detach($conn);
    }

    function onError(ConnectionInterface $conn, \Exception $e) //коли виникає якась помилка
    {
        //dump($e);
        //dump('onerror');
        //Log::debug("An error has occured: {$e->getMessage()}");
        echo "An error has occured: {$e->getMessage()}";
        $conn->close();
    }


    /*protected function verifyAppKey(ConnectionInterface $connection)
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

    function onOpen(ConnectionInterface $conn)
    {
        dump('on opened');

//        auth logic here

        $this->verifyAppKey($conn)->generateSocketId($conn);


    }

    function onClose(ConnectionInterface $conn)
    {
        dump('closed');
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        dump($e);
        dump('onerror');
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        // TODO: Implement onMessage() method.
    }*/
    /*function onMessage(ConnectionInterface $from, MessageInterface $msg) // сюди приходить повідомлення від клієнта
    {
        *
                $body = collect(json_decode($msg->getPayload(), true));

                $payload = $body->get('payload');
                $id = $body->get('id');

                dump($payload, $id);

                $post = Post::query()->findOrFail($id);

                $repo = new PostRepository();

                $updated = $repo->update($post, $payload);

                $response = (new PostResource($updated))->toJson();
        *
        $body = json_decode($msg->getPayload(), true);
        Log::debug("onMessage", [$body]);
        $body['answer'] = 1;
        $response = json_encode($body);
        $from->send($response);

    }*/
}
