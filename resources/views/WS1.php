<?php
var conn = new WebSocket('ws://127.0.0.1:8080');
conn.onopen = function (e) {
    console.error("CONNECTION ESTABLISHED.");
}
            conn.onmessage = function (e) {
                console.error("DATA RECEIVED: " + e.data);
                console.error("NewBroadcast DATA=", e.data);
                var jsonData = JSON.parse(e.data);
                $('#reseived-message').val("DATA RECEIVED: "+jsonData.data);
                alert(jsonData.data);
            }

            function sendData() {
                var data = {
                    "key": "MYAPPKEY",
                    "secret": "MYAPPSECRET",
                    "appId": "MYAPPID",
                    "channel": "NewBroadcast",
                    "event": "send_data",
                    "data": "Data: " + $('#input-message').val()
                };

                var jsonstr = JSON.stringify(data);
                conn.send(jsonstr);
                console.error("SENDED: " + jsonstr);
            }
