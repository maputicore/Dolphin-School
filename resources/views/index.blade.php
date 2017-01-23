<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <script src="https://skyway.io/dist/0.3/peer.min.js"></script>
        <script src="https://skyway.io/dist/multiparty.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

        <style>
          body {
            margin: 0;
          }
          #message {
            width: 190px;
            margin: 10px;
          }
          #streams {
            position: absolute;
            top: 10px;
            margin-left: 200px;
          }
          .video{
            margin: 0px 0px 0px 5px;
            width: 300px;
            border: 1px solid #000000;
            border-radius: 10px;
          }
          #streams .my-video {
            -webkit-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -moz-transform: scaleX(-1);
            transform: scaleX(-1);
          }
        </style>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

        <!-- <script>
            // Compatibility shim
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            // Peer object
            var peer = new Peer({
              key: '{{ env('WEB_RTC_APIKEY') }}',
              debug: 3
            });
            var room;
            peer.on('open', function(){
              $('#my-id').text(peer.id);
              // Get things started
              step1();
            });
            peer.on('error', function(err){
              alert(err.message);
              // Return to step 2 if error occurs
              step2();
            });
            // Click handlers setup
            $(function(){
              $('#make-call').submit(function(e){
                e.preventDefault();
                // Initiate a call!
                var roomName = $('#join-room').val();
                if (!roomName) {
                  return;
                }
                room = peer.joinRoom('sfu_video_' + roomName, {mode: 'sfu', stream: window.localStream});
                $('#room-id').text(roomName);
                step3(room);
              });
              $('#end-call').click(function(){
                room.close();
                step2();
              });
              // Retry if getUserMedia fails
              $('#step1-retry').click(function(){
                $('#step1-error').hide();
                step1();
              });
            });
            function step1 () {
              // Get audio/video stream
              navigator.getUserMedia({audio: true, video: true}, function(stream){
                // Set your video displays
                $('#my-video').prop('src', URL.createObjectURL(stream));
                $('#my-label').text(peer.id + ':' + stream.id);
                window.localStream = stream;
                step2();
              }, function(){ $('#step1-error').show(); });
            }
            function step2 () {
              $('#step1, #step3').hide();
              $('#step2').show();
              $('#join-room').focus();
            }
            function step3 (room) {
              // Wait for stream on the call, then set peer video display
              room.on('stream', function(stream){
                const streamURL = URL.createObjectURL(stream);
                const peerId = stream.peerId;
                $('#their-videos').append($(
                  '<div>' +
                    '<label id="label_' + peerId + '">' + stream.peerId + ':' + stream.id + '</label>' +
                    '<video autoplay class="remoteVideos" src="' + streamURL + '" id="video_' + peerId + '">' +
                  '</div>'));
              });
              room.on('removeStream', function(removedStream) {
                $('#video_' + removedStream.peerId).remove();
                $('#label_' + removedStream.peerId).remove();
              });
              // UI stuff
              room.on('close', step2);
              $('#step1, #step2').hide();
              $('#step3').show();
            }
        </script> -->

        <script>

        var multiparty;
        // MultiParty インスタンスを生成

        function start() {
          // MultiParty インスタンスを生成
          multiparty = new MultiParty( {
            "key": "{{ env('WEB_RTC_APIKEY') }}",
            "reliable": true,
            "debug": 3
          });
          /////////////////////////////////
          // for MediaStream
          multiparty.on('my_ms', function(video) {
            // 自分のvideoを表示
            var vNode = MultiParty.util.createVideoNode(video);
            vNode.setAttribute("class", "video my-video");
            vNode.volume = 0;
            $(vNode).appendTo("#streams");
          }).on('peer_ms', function(video) {
            console.log("video received!!")
            // peerのvideoを表示
            console.log(video);
            var vNode = MultiParty.util.createVideoNode(video);
            vNode.setAttribute("class", "video peer-video");
            $(vNode).appendTo("#streams");
            console.log($("#streams"))
          }).on('ms_close', function(peer_id) {
            // peerが切れたら、対象のvideoノードを削除する
            $("#"+peer_id).remove();
          })
          ////////////////////////////////
          // for DataChannel
          multiparty.on('message', function(mesg) {
            // peerからテキストメッセージを受信
            $("p.receive").append(mesg.data + "<br>");
          });
          ////////////////////////////////
          // Error handling
          multiparty.on('error', function(err) {
            alert(err);
          });
          multiparty.start();
          //////////////////////////////////////////////////////////
          // テキストフォームに入力されたテキストをpeerに送信
          $("#message form").on("submit", function(ev) {
            ev.preventDefault();  // onsubmitのデフォルト動作（reload）を抑制
            // テキストデータ取得
            var $text = $(this).find("input[type=text]");
            var data = $text.val();
            if(data.length > 0) {
              data = data.replace(/</g, "&lt;").replace(/>/g, "&gt;");
              $("p.receive").append(data + "<br>");
              // メッセージを接続中のpeerに送信する
              multiparty.send(data);
              $text.val("");
            }
          });
          ///////////////////////////////////////////////////
          // handle mute/unmute
          $("#video-mute").on("click", function(ev) {
            var mute = !$(this).data("muted");
            multiparty.mute({video: mute});
            $(this).text("video " + (mute ? "unmute" : "mute")).data("muted", mute);
          });
          $("#audio-mute").on("click", function(ev) {
            var mute = !$(this).data("muted");
            multiparty.mute({audio: mute});
            $(this).text("audio " + (mute ? "unmute" : "mute")).data("muted", mute);
          });
        }
        start();
        </script>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">

            </div>

            <div id="message">
              <form>
                <input type="text"><button type="submit">send</button>
              </form>
              <p class="receive">
              </p>
            </div>
            <div id="streams">
              <div>
                <button id="video-mute" data-muted="false">video mute</button>
                <button id="audio-mute" data-muted="false">audio mute</button>
            </div>

        </div>
    </body>
</html>
