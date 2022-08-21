<?php

namespace App\Websockets\handlers;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Facades\Log;

class WebsocketsHandler implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        //parent::onOpen($conn);
//        auth logic here
        //$this->verifyAppKey($conn)->generateSocketId($conn);
        $this->clients->attach($conn);
        Log::debug("NEW connection = {$conn->resourceId}");
        echo "\n NEW connection = {$conn->resourceId} \n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo "\n connection close = {$conn->resourceId} \n";
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        //dump($e);
        //dump('onerror');
        //Log::debug("An error has occured: {$e->getMessage()}");
        echo "\n An error has occured: {$e->getMessage()} \n";
        $conn->close();
    }
    //http://socketo.me/docs/hello-world
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's'
        );
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }
}
