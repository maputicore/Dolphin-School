@extends('layouts.student')

@section('content')
<h1>タイトル : {{ $lesson->name }}
    <small>{{ date("Y年 m月 d日 H時 i分", strtotime($lesson->start_time)) }} to {{ date("H時 i分", strtotime($lesson->finish_time)) }}</small>
</h1>
<p>{{ $lesson->description }}</p>
@if($isRegistered)
{!! Form::open(['url' => '/lesson/'.$lesson->id.'/cancel', 'method' => 'delete']) !!}
{!! Form::submit('UnRegister', ['class' => 'UnRegisterBtn', 'id' => $lesson->id ]) !!}
{!! Form::close() !!}
@else
{!! Form::open(['url' => '/lesson/'.$lesson->id.'/register']) !!}
{!! Form::submit('Register', ['class' => 'registerBtn', 'id' => $lesson->id ]) !!}
{!! Form::close() !!}
@endif

<style> video { width:200px; } </style>
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
        <button id="video-mute" data-muted="false">video mute</button>
        <button id="audio-mute" data-muted="false">audio mute</button>
    </div>
</div>

<script>

var multiparty;
// MultiParty インスタンスを生成
var room_name = "{{ $sessionId }}";

console.log(room_name);

function start() {
  // MultiParty インスタンスを生成
  multiparty = new MultiParty( {
    "key": "{{ env('WEB_RTC_APIKEY') }}",
    "reliable": true,
    "debug": 3,
    "room": room_name
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
@endsection
