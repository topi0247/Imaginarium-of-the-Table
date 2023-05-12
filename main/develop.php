<?php 
$title = 'develop';
include('_module/head.php');
?>
<body>
    <?php 
    $is_develop = true;
    include('_module/header.php');
    ?>

    <main>
        <article>
            <p><a href="document">各種デザイン</a></p>
            <section>
                <h3><span>作業中</span></h3>
                <ul>
                    <li>投稿作品の編集</li>
                    <li>投稿処理-セッション</li>
                    <li>投稿処理-イラスト</li>
                    <li>目次・投稿作品のサムネイル表示
                        <ul class="inline">
                            <li>セッション</li>
                            <li>イラスト</li>
                        </ul>
                    </li>
                    <li>小説カテゴリ「ひとコマ」目次デザイン・実装</li>
                    <li>セッションページ実装</li>
                    <li>イラストページ実装</li>
                    <li>投稿用ドキュメントページ</li>
                    <li>404/504エラーページ</li>
                    <li>バックアップ用データのダウンロードシステム</li>
                </ul>
            </section>

            <section>
                <h3><span>終了</span></h3>
                <ul>
                    <li>ログイン認証
                        <ul>
                            <li>ユーザー選択追加</li>
                            <li>indexページ…ログイン済みなら自動選択・自動入力</li>
                            <li>index以外…未ログインならindexへ移動</li>
                            <li>index以外…ログイン済ならそのまま</li>
                            <li>indexからログインした場合、ログイン状態を１ヶ月継続。ただしパスワード変更した場合はブラウザを閉じるまで（環境差あり）</li>
                        </ul>
                    </li>
                    <li>ページ上部へ戻る</li>
                    <li>ダークモード対応</li>
                    <li>メインメニュー</li>
                    <li>基本デザイン
                        <ul class="inline">
                            <li>見出し</li>
                            <li>リンク</li>
                            <li>フォーム</li>
                            <li>配置</li>
                            <li>装飾</li>
                        </ul>
                    </li>
                    <li>目次デザイン
                        <ul class="inline">
                            <li>セッション</li>
                            <li>小説</li>
                            <li>イラスト</li>
                        </ul>
                    </li>
                    <li>目次実装
                        <ul class="inline">
                            <li>小説</li>
                        </ul>
                    </li>
                    <li>セッションページデザイン</li>
                    <li>小説ページデザイン・実装</li>
                    <li>イラストページデザイン</li>
                    <li>過去ログページ</li>
                    <li>開発状況ページ</li>
                    <li>画像表示
                        <ul class="inline">
                            <li>大</li>
                            <li>サムネ</li>
                        </ul>
                    </li>
                    <li>画像サムネの拡大表示</li>
                    <li>上記のレスポンシブ（スマホ・タブレット）対応</li>
                    <li>phpへ移行し管理の簡易化</li>
                    <li>ユーザー設定
                        <ul class="inline">
                            <li>パスワード変更</li>
                            <li>ダークモード設定（端末依存・ライト・ダーク）</li>
                            <li>小説作品の公開・非公開切り替え</li>
                            <li>小説作品の削除</li>
                        </ul>
                    </li>
                </ul>
            </section>
    
            <section>
                <h3><span>検討中</span></h3>
                <ul>
                    <li>ユーザー設定
                        <ul>
                            </li>
                            <li>フォント（<a href="https://espace.monbalcon.net/parts/3188/" target="_blank">novel-viewer</a>）
                                <ul class="inline">
                                    <li>明朝系</li>
                                    <li>ゴシック系</li>
                                </ul>
                            </li>
                            <li>小説（<a href="https://espace.monbalcon.net/parts/3188/" target="_blank">novel-viewer</a>）
                                <ul class="inline">
                                    <li>横書き</li>
                                    <li>縦書き</li>
                                </ul>
                            </li>
                            <li>ユーザーアイコン変更</li>
                        </ul>
                    </li>
                    <li>いいねボタン（<a href="https://do.gt-gt.org/product/newiine/" target="_blank">いいねボタン改</a>）
                        <ul class="inline">
                            <li>連打対応</li>
                            <li>ボタン種類</li>
                            <li>投稿者のみ数字が見れる（数字は見れなくてもいい？）</li>
                        </ul>
                    </li>
                    <li>しおり
                        <ul class="inline">
                            <li>追加</li>
                            <li>削除</li>
                            <li>しおりのページが存在しないときの表示</li>
                        </ul>
                    </li>
                    <li>ユーザー設定としおりをCookie保存にしない</li>
                </ul>
            </section>
            <section>
                <h3><span>後回し</span></h3>
                <ul>
                    <li>下書き保存</li>
                    <li>カレンダー</li>
                    <li>ユーザー名の変更</li>
                    <li>検索・ソート</li>
                </ul>
            </section>
        </article>
    </main>
    
    <?php include_once('_module/footer.php'); ?>
</body>
</html>