<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WebsocketsServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocketserver:run';

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
        $server = new WebSocket\Server([
            'filter' => ['text', 'binary', 'ping'], // Specify message types for receive() to return
            //'logger' => $my_psr3_logger, // Attach a PSR3 compatible logger
            'port' => 6002, // Listening port
            'return_obj' => true, // Return Message insatnce rather than just text
            'timeout' => 60, // 1 minute time out
        ]);
        return 0;
    }
}
