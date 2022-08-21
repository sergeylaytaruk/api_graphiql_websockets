<?php

use App\Events\NewBroadcast;
use App\Events\NewMessage;
use App\Websockets\handlers\CustomHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use BeyondCode\LaravelWebSockets\Server\Logger\WebsocketsLogger;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Output\NullOutput;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/message', function (\Illuminate\Http\Request $request) {
    $message = $request->input('message');
    event(new NewMessage($message));
    return null;
    //return $message;
});
Route::post('/broadcast', function (\Illuminate\Http\Request $request) {
    $message = $request->input('msg');
    //$message = "test";
    //event(new NewBroadcast($message));
    NewBroadcast::dispatch($message);
    return null;
    //return $message;
});


Route::get('/broadcast2', function (\Illuminate\Http\Request $request) {
    $message = $request->input('msg');
    $connect = \Ratchet\Client\connect('ws://127.0.0.1:8080')->then(function($conn) use ($message) {
    //$connect = \Ratchet\Client\connect('ws://local.test:8080')->then(function($conn) use ($message) {
//        $conn->on('message', function($msg) use ($conn) {
//            echo "Received: {$msg}\n";
//            $conn->close();
//        });
        $jsonData = [
            'body' => ["command" => "update_data", "user" => "tester01"],
            'channel' => 'NewBroadcast',
            'event' => 'send_data',
            'data' => $message,
        ];
        $conn->send(json_encode($jsonData));
        $conn->close();

    }, function ($ex) {
        echo "Could not connect: {$ex->getMessage()}\n";
    });
    return null;
});


/*
app()->singleton(WebsocketsLogger::class, function () {
    return (new WebsocketsLogger(new NullOutput()))->enable(false);
});
*/
//WebSocketsRouter::webSocket('/my-broadcast', CustomHandler::class);
//WebSocketsRouter::webSocket('/app/{appkey}/my-broadcast', CustomHandler::class);
WebSocketsRouter::webSocket('/test', CustomHandler::class);
/*
        $this->get('/app/{appKey}', WebSocketHandler::class);
        $this->post('/apps/{appId}/events', TriggerEventController::class);
        $this->get('/apps/{appId}/channels', FetchChannelsController::class);
        $this->get('/apps/{appId}/channels/{channelName}', FetchChannelController::class);
        $this->get('/apps/{appId}/channels/{channelName}/users', FetchUsersController::class);
*/
