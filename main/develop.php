<?php
$title = 'develop | Imaginarium of the Table';
$meta_title = 'develop';
$dir = './';
include($dir . 'module/head.php');
?>
<body>
    <?php 
    $header_about = false;
    $header_top = true;
    $header_session = true;
    $header_novel = true;
    $header_illust = true;
    $header_post = true;
    $header_setting = true;
    include($dir . 'module/header.php');
    ?>

    <main class="passcheck">
        <article>
            <section>
                <h3><span>作業中</span></h3>
                <ul>
                    <li>phpへ移行し管理の簡易化</li>
                    <li>イラストページ</li>
                    <li>投稿した作品の削除</li>
                    <li>投稿した作品の編集</li>
                    <li>投稿作品のサムネイル表示</li>
                    <li>各目次ページ</li>
                    <li>投稿処理-セッション</li>
                    <li>投稿処理-イラスト</li>
                    <li>下書き保存</li>
                    <li>投稿用ドキュメントページ</li>
                    <li>バックアップ用データ作成</li>
                    <li>バックアップ用データのダウンロード</li>
                </ul>
            </section>

            <section>
                <h3><span>終了</span></h3>
                <ul>
                    <li>ログイン認証
                        <ul>
                            <li>indexページ…ログイン済みなら自動入力</li>
                            <li>index以外…未ログインなら認証表示</li>
                            <li>index以外…ログイン済なら認証非表示</li>
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
                    <li>セッションページ</li>
                    <li>小説ページ</li>
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
                </ul>
            </section>
    
            <section>
                <h3><span>検討中</span></h3>
                <ul>
                    <li>設定ページ
                        <ul>
                            <li>表示
                                <ul class="inline">
                                    <li>端末依存</li>
                                    <li>ライトモード</li>
                                    <li>ダークモード</li>
                                </ul>
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
                    <li>設定ページとしおりをCookie保存にしない</li>
                </ul>
            </section>
            <section>
                <h3><span>後回し</span></h3>
                <ul>
                    <li>カレンダー</li>
                    <li>ユーザー名・ユーザーIDの変更</li>
                    <li>検索・ソート</li>
                </ul>
            </section>
        </article>
    </main>
    
    <article class="overlay">
        <div class="popup-window">
            <h3><span>Login</span></h3>
            <div class="center">
                <div id="loginResult"></div>
                <form>
                    <input type="text" placeholder="password" id="loginPass">
                    <input type="button" value="send" id="login">
                </form>
                <a href="index.php">indexへ</a>
            </div>
        </div>
    </article>

    <footer class="passcheck">
        <p class="small">© 2023 Imaginarium of the Table - by TRPG部</p>
        <nav id="pageBottonNav" class="fixed-menu">
            <ul>
                <li id="pageTop" class="pagetop"><button></button></li>
                <li id="changeMode" class="mode"><button></button></li>
            </ul>
        </nav>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <!-- 3rd -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <script src="js/3rd/sha256.js"></script>
    <!-- script -->
    <script src="js/script.js"></script>
</body>
</html>