# メモ

## ライフサイクル

webサーバーがpublic/index.phpにリダイレクト

1. autoload読み込み
   1. require無しで別ファイルのクラスを利用可能(namespace, use)
2. Applicationインスタンス作成(サービスコンテナ)
   1. Bootstrap/app.phpを読み込み
   2. `$app = new Illuminate\Foundation\Application` Applicationインスタンスが通称**サービスコンテナ**
3. HttpKernelインスタンス作成
4. Requestインスタンス作成
5. HttpKernelがリクエストを処理してResponse取得
6. レスポンス送信
7. terminate()で後片付け

## サービスコンテナ

- `dd(app());`で内容を確認できる
- `#binding`に紐づけられているサービス一覧が格納されている
- サービスコンテナを使うと**インスタンス化する必要がない**
- 依存関係も解決してくれるので便利

### サービスコンテナの作成・利用

LifeCycleTestControllerに記述

1. 任意のクラスを用意する(`class Sample{ ... }`)
2. そのクラスをサービスコンテナにバインドする(`app()->bind('呼び出すときに使いたい名前', 登録するクラス)`)
   1. bind()の第二引数はClosureでも良い
3. サービスコンテナを呼び出す(`$var = app()->make('呼び出すときに使う名前')`)

## サービスプロバイダー

サービスコンテナにサービスを登録する仕組み
読み込み箇所 -> `Illuminate\Foundation\Application`

- ServiceProvider -> app()
  - register() = 登録
  - boot() = 登録後に実行したい処理

## サービスプロバイダの作成

1. artisanコマンドでサービスプロバイダーを作成する
   1. `php artisan make:provider ファイル名`
2. 作成されたプロバイダーのregister()内で、サービスコンテナにサービスを登録する
   1. `app()->bind('...', function(){ ... })`
3. config/app.phpの**providers[]**に作成したプロバイダーを追加
   1. これでブラウザを再読み込みしたときに、作成したプロバイダーを使えるようになる
   2. 自動的にサービスコンテナに登録されるから