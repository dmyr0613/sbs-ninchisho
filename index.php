<?php

// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

// アクセストークンを使いCurlHTTPClientをインスタンス化
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
// CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
// LINE Messaging APIがリクエストに付与した署名を取得
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

// 署名が正当かチェック。正当であればリクエストをパースし配列へ
// 不正であれば例外の内容を出力
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}

// 配列に格納された各イベントをループで処理
foreach ($events as $event) {
  // MessageEventクラスのインスタンスでなければ処理をスキップ
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }
  // TextMessageクラスのインスタンスでなければ処理をスキップ
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    error_log('Non text message has come');
    continue;
  }
  // オウム返し
  //$bot->replyText($event->getReplyToken(), $event->getText());

  //if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
    //入力されたテキストを取得
    $MsgText = $event->getText();
  //}

  if ($MsgText=='使い方') {
    //リッチメニューから「使い方」
    $messageStr = '入力されたテキストから利用者の認知症判定を行います。 ';
    $messageStr = $messageStr . "\r\n";
    $messageStr = $messageStr . "\r\n" . '左下のキーボードアイコンを押して、利用者の状況を入力してください。';
    $bot->replyText($event->getReplyToken(), $messageStr);
  } elseif ($MsgText=='サンプル') {
      //リッチメニューから「使い方」
      //$messageStr = '言葉で意思を伝達できている。日課を尋ねると「ご飯は嫁がやってくれるの」等昔の話をする。日課の理解はできず、日頃もできていないと聞く。調査前何をしていたかの問いかけに「事務仕事」と答える。３つの品物を覚えてもらい後から２つを提示し残りの１つを問うが質問が理解できなかった。短期記憶はできないと判断する。日頃も同様と聞く。「わからないねえ」「春かねえ」と答える。「ここへは通って事務仕事をしている」と答える。毎日施設内を歩き回る。帰りの出口を探しながら当てもなく歩き回り、他の居室に入ってしまうこともあると聞く。夜になるとトイレの場所が分からなくなり探している。職員が声かけし誘導する（週５日以上）。トイレや食堂から居室に戻ることはできると聞く。週２回の入浴を毎回強く拒否する。職員の手を払いのけたり「いいわよ！」と声を荒げたりする。職員は色々話しかけたり入浴の話をしないで誘導したりの工夫をして浴室まで連れて行く。時には職員２人がかりの時もあると聞く。脱衣所に入ればそのまま入浴になるという。毎日、夕方から寝るまで「帰らなきゃならない」と施設内を歩き回る。色々なドアを開けようとし「開かないわ」と言いまた他の場所を開けようとすることを繰り返す。職員は遠めに見守り、時折声をかけている。帰宅願望をそらすためにタオルたたみ等の仕事を頼んだりしている。 ';

      //$messageStr = '昼間は20回以上トイレ排尿。夜間は5,6回位、ポータブルトイレで排尿。毎日トイレで排便。';
      //$messageStr = $messageStr . "\r\n" . '夜間ポータブルトイレがあることは分からず、1,2回トイレでも排尿している。';
      //$messageStr = $messageStr . "\r\n" . '拭き取りは自分で行うが、部屋にあるいろいろな紙を持っていってしまうため、毎回職員がトイレットペーパーを渡している。';

      //$messageStr = $messageStr . "\r\n" . '便は自分では拭ききれず、下着を汚しているため毎日下着の取り替えを職員が行う。';
      //$messageStr = $messageStr . "\r\n" . 'ズボンの下げは自分で行い、上げは途中までしか出来ないため職員が上げている。';
      //$messageStr = $messageStr . "\r\n" . '水洗は自分で行うこともあるが職員が行うほうが多いときく。尿失禁はないと聞く。';
      //$messageStr = $messageStr . "\r\n" . '便失禁は月に1,2回あり、下着の取替は職員が行う。捨尿は朝まとめて職員が行う。';

      $messageStr = '昼間は20回以上トイレ排尿。夜間は5,6回位、ポータブルトイレで排尿。毎日トイレで排便。夜間ポータブルトイレがあることは分からず、1,2回トイレでも排尿している。奥さんが手伝おうとすると、手を払いのけ拒否をする。怒って手がつけられないこともあり、何を言っても納得しないで、おかしな行動をすることがある。時間がわからず、室内をウロウロと歩き回り、外に出て警察に保護されることもある。';

      $bot->replyText($event->getReplyToken(), $messageStr);
  } elseif ($MsgText=='判定値') {
    // 判定値画像を返信
    replyImageMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/img/hantei.png', 'https://' . $_SERVER['HTTP_HOST'] . '/img/hantei.png');
  } elseif ($MsgText=='チャート') {
    // チャート画像を返信
    replyImageMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/img/chart.png', 'https://' . $_SERVER['HTTP_HOST'] . '/img/chart.png');
  } else {
    //実際にテキストが入力された。本来はAPIを実行して判定値を戻す。

    //APIをコール
    $jsonString = file_get_contents('https://PrimeArch.jp/Ninchisho/judgment/?str=' . $MsgText);

    $messageStr = "【認知症判定結果】";
    // 文字列を連想配列に変換
    $obj = json_decode($jsonString, true);
    $chartURL = $obj['RadarChartURL'];
    foreach ($obj['HanteiResult'] as $key => $val){
      $messageStr = $messageStr . "\r\n" . $val["BunruiName"] . "：" . $val["HanteiCode"];
    }
    error_log($chartURL);
    error_log($messageStr);

    //$bot->replyText($event->getReplyToken(), $messageStr);
    //replyImageMessage($bot, $event->getReplyToken(), $chartURL, $chartURL);
    /*
    $bot->replyMessage($event->getReplyToken(),
      (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
        ->add(replyImageMessage($bot, $event->getReplyToken(), $chartURL, $chartURL))
        ->add($bot->replyText($event->getReplyToken(), $messageStr))
    );
    */


    $bot->replyMessage($event->getReplyToken(),
      (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($messageStr))
        ->add(new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($chartURL, $chartURL))
    );


    // 判定値画像を返信
    //replyImageMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/img/hantei.png', 'https://' . $_SERVER['HTTP_HOST'] . '/img/hantei.png');
  }

}

// テキストを返信。引数はLINEBot、返信先、テキスト
function replyTextMessage($bot, $replyToken, $text) {
  // 返信を行いレスポンスを取得
  // TextMessageBuilderの引数はテキスト
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));
  // レスポンスが異常な場合
  if (!$response->isSucceeded()) {
    // エラー内容を出力
    error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// 画像を返信。引数はLINEBot、返信先、画像URL、サムネイルURL
function replyImageMessage($bot, $replyToken, $originalImageUrl, $previewImageUrl) {
  // ImageMessageBuilderの引数は画像URL、サムネイルURL
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalImageUrl, $previewImageUrl));
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// 位置情報を返信。引数はLINEBot、返信先、タイトル、住所、
// 緯度、経度
function replyLocationMessage($bot, $replyToken, $title, $address, $lat, $lon) {
  // LocationMessageBuilderの引数はダイアログのタイトル、住所、緯度、経度
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder($title, $address, $lat, $lon));
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// スタンプを返信。引数はLINEBot、返信先、
// スタンプのパッケージID、スタンプID
function replyStickerMessage($bot, $replyToken, $packageId, $stickerId) {
  // StickerMessageBuilderの引数はスタンプのパッケージID、スタンプID
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder($packageId, $stickerId));
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// 動画を返信。引数はLINEBot、返信先、動画URL、サムネイルURL
function replyVideoMessage($bot, $replyToken, $originalContentUrl, $previewImageUrl) {
  // VideoMessageBuilderの引数は動画URL、サムネイルURL
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($originalContentUrl, $previewImageUrl));
  if (!$response->isSucceeded()) {
    error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// オーディオファイルを返信。引数はLINEBot、返信先、
// ファイルのURL、ファイルの再生時間
function replyAudioMessage($bot, $replyToken, $originalContentUrl, $audioLength) {
  // AudioMessageBuilderの引数はファイルのURL、ファイルの再生時間
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\AudioMessageBuilder($originalContentUrl, $audioLength));
  if (!$response->isSucceeded()) {
    error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// 複数のメッセージをまとめて返信。引数はLINEBot、
// 返信先、メッセージ(可変長引数)
function replyMultiMessage($bot, $replyToken, ...$msgs) {
  // MultiMessageBuilderをインスタンス化
  $builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
  // ビルダーにメッセージを全て追加
  foreach($msgs as $value) {
    $builder->add($value);
  }
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// Buttonsテンプレートを返信。引数はLINEBot、返信先、代替テキスト、
// 画像URL、タイトル、本文、アクション(可変長引数)
function replyButtonsTemplate($bot, $replyToken, $alternativeText, $imageUrl, $title, $text, ...$actions) {
  // アクションを格納する配列
  $actionArray = array();
  // アクションを全て追加
  foreach($actions as $value) {
    array_push($actionArray, $value);
  }
  // TemplateMessageBuilderの引数は代替テキスト、ButtonTemplateBuilder
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
    $alternativeText,
    // ButtonTemplateBuilderの引数はタイトル、本文、
    // 画像URL、アクションの配列
    new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder ($title, $text, $imageUrl, $actionArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// Confirmテンプレートを返信。引数はLINEBot、返信先、代替テキスト、
// 本文、アクション(可変長引数)
function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {
  $actionArray = array();
  foreach($actions as $value) {
    array_push($actionArray, $value);
  }
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
    $alternativeText,
    // Confirmテンプレートの引数はテキスト、アクションの配列
    new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder ($text, $actionArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

// Carouselテンプレートを返信。引数はLINEBot、返信先、代替テキスト、
// ダイアログの配列
function replyCarouselTemplate($bot, $replyToken, $alternativeText, $columnArray) {
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
  $alternativeText,
  // Carouselテンプレートの引数はダイアログの配列
  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder (
   $columnArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

?>
