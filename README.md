## 概要
単語を入力すると日本酒を推薦してくれるline-bot

## 発想
- word2vecを勉強したての時に作成しました(2018年の年末頃)
- word2vecは周囲に出現する単語が似ている単語は意味が近いという仮定を置いているため、他の飲み物などと似た感想をもたれている日本酒を探し出せるのではないかと思い、作ってみました
- (感想で同じ単語が使われていても、日本酒と他の飲み物では意味合いが違うかなと思いましたが、面白そうなのでとりあえずやってみました)

## セットアップ
以下の手順で動くと思います。
1. 日本酒の感想を中心に学習させたword2vecモデルを用意する
1. 1を `./data/sake.model` として設置する
1. lineのMessaging APIの設定をする
1. `callback_gensim.php` にアクセストークンとチャンネルセレクトを記述する
1. サーバーにフォルダを設置する
1. lineの `Webhook URL` を設定する(~~~/callback_gensim.php)

## 使い方
- 以下のQRコードからこのline-botを友達追加できます

![スクリーンショット 2020-07-05 22 14 36](https://user-images.githubusercontent.com/43877096/86533572-166ddc00-bf0d-11ea-9bb6-16e36dfd9767.png)

- 利用例

![iOS の画像 (1)](https://user-images.githubusercontent.com/43877096/86534249-03113f80-bf12-11ea-8d65-9fe5386e2fe4.png)

## 備考
- 日本酒に関するレビューデータがあまり集まらなかったのと、文章からの日本酒名が難しく、精度はおそらくよくないです。。。
- 最初はFlaskを利用してpythonだけで完結させようとしたのですが、xserverのcgi経由だと負荷に耐えてくれず、php経由で実装しました
- `data/sake_list` は日本酒レビューサイトから収集した日本酒名のリストです
