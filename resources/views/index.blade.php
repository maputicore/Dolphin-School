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
        console.log(err);
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
          console.log(data);
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
        console.log(mute);
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
</html>
