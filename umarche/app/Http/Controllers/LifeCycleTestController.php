<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{

    // EncryptionServiceProviderを使ってみる
    public function showServiceProviderTest(){
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');
        dd($password, $encrypt->decrypt($password));
    }

    // サービスコンテナへの登録・呼び出しをしてみる
    public function showServiceContainerTest(){

        // サービスコンテナへの登録
        app()->bind('lifeCycleTest', function(){
            return 'ライフサイクルテスト';
        });

        // サービスコンテナから呼び出し
        $test = app()->make('lifeCycleTest');

        // サービスコンテナなしのパターン
        $message = new Message();
        $sample = new Sample($message);
        $sample->run();

        // サービスコンテナありのパターン
        app()->bind('sample', Sample::class);
        $sample = app()->make('sample');
        $sample->run();

        dd($test, app());
    }
}

class Sample
{
    public $message;
    public function __construct(Message $message){
        $this->message = $message;
    }
    public function run(){
        $this->message->send();
    }
}

class Message
{
    public function send(){
        echo('メッセージ表示');
    }
}