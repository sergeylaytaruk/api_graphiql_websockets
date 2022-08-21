<?php

namespace App\Console\Commands;

use App\Websockets\handlers\WebsocketsHandler;
use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Illuminate\Support\Facades\Log;
use Ratchet\WebSocket\WsServer;

class Websockets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websockets:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Websocket server run';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Websocket server started.");
        $server = IoServer::factory (
            new HttpServer(
                new WsServer(
                    new WebsocketsHandler()
                )
            ),
            8080
        );
        $server->run();
        return 0;
    }
}
