<?php
use danog\MadelineProto\API;
use danog\MadelineProto\EventHandler;
use danog\MadelineProto\Logger;

/*
 * Various ways to load MadelineProto
 */
if (\file_exists('vendor/autoload.php')) {
    include 'vendor/autoload.php';
}else{
    echo "algo no se ha cargado correctamente";
}
$MadelineProto = new API('session.madeline');
$MadelineProto->async(true);
$MadelineProto->loop(function () use ($MadelineProto) {
    yield $MadelineProto->start();

    $me = yield $MadelineProto->getSelf();

    $MadelineProto->logger($me);

    if (!$me['bot']) {
        $dialogs = yield $MadelineProto->getDialogs();
        foreach ($dialogs as $peer) {
            //$MadelineProto->logger($dialog);
            echo var_dump($peer);
            $chat = yield $MadelineProto->getInfo($peer['user_id']);
            echo var_dump($chat);
        }
        // yield $MadelineProto->messages->sendMessage(['peer' => '@danogentili', 'message' => "Hi!\nThanks for creating MadelineProto! <3"]);
        // yield $MadelineProto->channels->joinChannel(['channel' => '@MadelineProto']);

        // try {
        //     yield $MadelineProto->messages->importChatInvite(['hash' => 'https://t.me/joinchat/Bgrajz6K-aJKu0IpGsLpBg']);
        // } catch (\danog\MadelineProto\RPCErrorException $e) {
        //     $MadelineProto->logger($e);
        // }

        // yield $MadelineProto->messages->sendMessage(['peer' => 'https://t.me/joinchat/Bgrajz6K-aJKu0IpGsLpBg', 'message' => 'Testing MadelineProto!']);
    }
    yield $MadelineProto->echo('OK, done!');
});