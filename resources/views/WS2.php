<?php

var pusher = new Pusher("MYAPPKEY", {
    wsHost: '127.0.0.1',
                wsPort: '6001',
                httpHost: '127.0.0.1',
                httpPort: 8000,
                cluster: "eu",
                forceTLS: false
            });
            //NAME CHANEL = broadcastOn
            // підписка на канал
            var channel = pusher.subscribe("SendMessageChanel");
            // EVENT
            // підписка на подію
            channel.bind("SendMessageChanel-data", (data) => {
    //console.error("NewBroadcast=", data.details.includes('SendMessageChanel'), data.data);
    console.error("NewBroadcast=", data.message);
    alert("Broadcast Message="+data.message);
});


            //pusher.trigger("SendMessageChanel", "NewBroadcast", { message: "Hello World!" });

            function sendBroadcastData() {
                var msg = $('#input-message').val();
                $.ajax({
                    type: "POST",
                    url: "/broadcast",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                    'msg': msg
                    },
                    success: function(msg){
                    console.error( "Data: " + msg );
                },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.error("some error", XMLHttpRequest, textStatus, errorThrown);
                }
                });
            }
