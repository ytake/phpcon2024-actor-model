# phpcon2024-actor-model-workshop

## Workshop: Actor Model in PHP

This workshop is an introduction to the Actor Model using PHP.  
このワークショップは、PHPを使ったアクターモデルの入門です。  

ワークショップに参加される方は事前に以下の準備をお願いします。  
コンテナを起動するところまでの手順は以下の通りです。  

Dockerを事前にインストールしておいてください。  
Dockerを利用しない場合はPHP8.4以上をインストールしSwoole 6.0.0RC1以上をインストールしてください。

```bash
$ git https://github.com/ytake/phpcon2024-actor-model
$ cd phpcon2024-actor-model
$ docker compose up -d
# workshopコンテナに入る
$ docker-compose exec php workshop
```

IDEなどを使ってコードを書く場合は、ホスト側のディレクトリをマウントしてください。    

ワークショップで利用する各サンプルは以下のディレクトリにあります。

### Calculator Example

このサンプルを使ったワークショップでは、アクターモデルを使用して簡単な計算機の実装を体験することができます。

[Calculator Example](calculator/readme.md)

### Cart Example

このサンプルを使ったワークショップでは、アクターモデルを使用してショッピングカートの実装を体験することができます。

[Cart Example](cart/readme.md)
