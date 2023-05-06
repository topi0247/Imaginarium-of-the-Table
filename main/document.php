<?php 
$title = 'document | Imaginarium of the Table';
$meta_title = 'document';
$dir = './';
include($dir . 'module/head.php');
?>
<body>
    <header class="passcheck">
        <h1><a href="top.php">Imaginarium of the Table</a></h1>
        <nav id="mainMenu" class="menu">
            <ul>
                <li><a href="top.php">トップ</a></li>
                <li><a href="#design">基本</a></li>
                <li><a href="#form">フォーム</a></li>
                <li><a href="#list">リスト</a></li>
                <li><a href="#column">列表示</a></li>
                <li><a href="#thumbnail">目次サムネ</a></li>
                <li><a href="#other">その他</a></li>
            </ul>
        </nav>
    </header>
    <button type="button" id="toggleMenu"></button>

    <main class="passcheck">
        <article>
            <h2><span>各ページ</span></h2>
            <ul>
                <li><a href="log.php">過去ログ</a></li>
                <li><a href="develop.php">開発状況</a></li>
                <li>セッション
                    <ul class="inline">
                        <li><a href="session/index.php">目次</a></li>
                        <li><a href="session/session.html">セッション</a></li>
                    </ul>
                </li>
                <li>小説
                    <ul class="inline">
                        <li><a href="novel/index.php">目次</a></li>
                        <li><a href="novel/novel.html">小説</a></li>
                    </ul>
                </li>
                <li>イラスト
                    <ul class="inline">
                        <li><a href="illust/index.php">目次</a></li>
                        <li><a href="illust/illust.html">イラスト</a></li>
                    </ul>
                </li>
                <li><a href="post/index.php">投稿画面</a></li>
            </ul>
        </article>

        <article id="design">
            <section>
                <h2><span>見出し２</span></h2>
                <h3><span>見出し３</span></h3>
                <h4>見出し４</h4>
                <h5>見出し５</h5>
                <h6>見出し６</h6>
            </section>
            
            <section>
                <h3><span>装飾</span></h3>
                <p>太字：<b>太字</b><br>
                    強調：<em>強調</em><br>
                    重要：<strong>重要</strong><br>
                    水平線↓</p>
                <hr>
            </section>
            
            <section>
                <h3><span>リンク</span></h3>
                <a>リンク</a><br>
                <a class="btn">リンク（ボタン）</a><br>
                <a class="btn block">リンク（ブロックボタン）</a>
                <a target="_blank">新規タブで開くリンク</a><br>
                <a class="btn" target="_blank">新規タブで開くリンク（ボタン）</a><br>
                <a class="btn block" target="_blank">新規タブで開くリンク（ブロックボタン）</a>    
            </section>

            <section>
                <h3><span>配置</span></h3>
                <div>
                    <p>通常表示</p>
                    <img class="img-thumbnail" src="img/hyoushi.jpg">
                </div>
                <div class="center center-sp">
                    <p>中央表示</p>
                    <img class="img-thumbnail" src="img/hyoushi.jpg">
                </div>
                <div class="right right-sp">
                    <p>右端表示</p>
                    <img class="img-thumbnail" src="img/hyoushi.jpg">
                </div>
            </section>
        </article>

        <article id="form">
            <h2><span>フォーム</span></h2>
            <section>
                <h3><span>１列</span></h3>
                <p><span class="required"></span>必須マークも付けられます</p>
                <form>
                    <dl class="inline">
                        <dt class="required">ボタン</dt>
                        <dd><button type="button">ボタン</button>
                            <input type="button" value="ボタン">
                            <input type="submit" value="送信ボタン">
                        </dd>
            
                        <dt>ブロックボタン</dt>
                        <dd>
                            <button type="button" class="block">ボタン</button>
                            <input type="button" class="block" value="ボタン">
                            <input type="submit" class="block" value="送信ボタン">
                        </dd>
            
                        <dt>チェックボックス</dt>
                        <dd>
                            <label><input type="checkbox">項目１</label>
                            <label><input type="checkbox">項目２</label>
                            <label><input type="checkbox">項目３</label>
                        </dd>
            
                        <dt>ラジオボタン</dt>
                        <dd>
                            <label><input type="radio" name="a">項目１</label>
                            <label><input type="radio" name="a">項目２</label>
                            <label><input type="radio" name="a">項目３</label>
                        </dd>
            
                        <dt>一行テキスト</dt>
                        <dd><input type="text" placeholder="テキスト"></dd>
            
                        <dt>複数行テキスト</dt>
                        <dd><textarea placeholder="テキストエリア"></textarea></dd>
                    </dl>
                </form>
            </section>
            
            <section>
                <h3><span>通常</span></h3>
                <form>
                    <dl>
                        <dt class="required">ボタン</dt>
                        <dd>
                            <button type="button">ボタン</button>
                            <input type="button" value="ボタン">
                            <input type="submit" value="送信ボタン">
                        </dd>

                        <dt>ブロックボタン</dt>
                        <dd>
                            <button type="button" class="block">ボタン</button>
                            <input type="button" class="block" value="ボタン">
                            <input type="submit" class="block" value="送信ボタン">
                        </dd>

                        <dt>チェックボックス</dt>
                        <dd>
                            <label><input type="checkbox">項目１</label>
                            <label><input type="checkbox">項目２</label>
                            <label><input type="checkbox">項目３</label>
                        </dd>

                        <dt>ラジオボタン</dt>
                        <dd>
                            <label><input type="radio" name="a">項目１</label>
                            <label><input type="radio" name="a">項目２</label>
                            <label><input type="radio" name="a">項目３</label>
                        </dd>

                        <dt>一行テキスト</dt>
                        <dd><input type="text" placeholder="テキスト"></dd>

                        <dt>複数行テキスト</dt>
                        <dd><textarea placeholder="テキストエリア"></textarea></dd>
                    </dl>
                </form>
            </section>
        </article>

        <article id="list">
            <h2><span>リスト</span></h2>
            <section>
                <h4>通常</h4>
                <ul>
                    <li>リスト</li>
                    <li>リスト</li>
                    <li>リスト</li>
                </ul>
                <h4>１列</h4>
                <ul class="inline">
                    <li>リスト</li>
                    <li>リスト</li>
                    <li>リスト</li>
                </ul>
            </section>

            <section>
                <h4>ナンバーリスト</h4>
                <ol>
                    <li>リスト</li>
                    <li>リスト</li>
                    <li>リスト</li>
                </ol>
            </section>
            
            <section>
                <h4>通常定義リスト</h4>
                <dl>
                    <dt>リスト</dt>
                    <dd>テキスト</dd>
                    <dt>リスト</dt>
                    <dd>テキスト</dd>
                    <dt>リスト</dt>
                    <dd>テキスト</dd>
                </dl>
                <h4>１列定義リスト</h4>
                <dl class="inline">
                    <dt>リスト</dt>
                    <dd>テキスト</dd>
                    <dt>リスト</dt>
                    <dd>テキスト</dd>
                    <dt>リスト</dt>
                    <dd>テキスト</dd>
                </dl>
            </section>
        </article>

        <article id="column">
            <h2><span>列</span></h2>
            <section>
                <h3><span>２列</span></h3>
                <h5>テキスト</h5>
                <div class="column column-2 column-sp-2">
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">テキスト</button>
                    </div>
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">テキスト</button>
                    </div>
                </div>
                <h5>画像</h5>
                <p>列表示では正方形にトリミングされます</p>
                <div class="column column-2 column-sp-2">
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                </div>
            </section>
            
            <section>
                <h3><span>３列</span></h3>
                <h5>テキスト</h5>
                <div class="column column-3 column-sp-3">
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">テキスト</button>
                    </div>
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">テキスト</button>
                    </div>
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">テキスト</button>
                    </div>
                </div>
                <h5>画像</h5>
                <p>列表示では正方形にトリミングされます</p>
                <div class="column column-3 column-sp-3">
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                </div>
            </section>
            
            <section>
                <h3><span>４列</span></h3>
                <h5>テキスト</h5>
                <div class="column column-4 column-sp-4">
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">ボタン</button>
                    </div>
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">ボタン</button>
                    </div>
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">ボタン</button>
                    </div>
                    <div>
                        <p>テキストテキストテキスト</p>
                        <button type="button" class="block">ボタン</button>
                    </div>
                </div>
                <h5>画像</h5>
                <p>列表示では正方形にトリミングされます</p>
                <div class="column column-4 column-sp-4">
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                    <div>
                        <img src="img/hyoushi.jpg">
                    </div>
                </div>
            </section>
        </article>

        <article id="thumbnail">
            <section>
                <h2><span>セッション予定サムネ</span></h2>
                <div class="sess-thumbnail">
                    <div>
                        <div class="sess-date">
                            <span class="month">2</span>
                            <span class="date">17</span>
                            <span class="week">金</span>
                            <div class="sess-time">
                                <span class="start">21:00</span>
                            </div>
                        </div>
                        <div class="sess-data">
                            <h4><a href="https://booth.pm/ja/items/3472076" target="_blank"></a>ループ橋で何かが自分を待っているんです。</h4>
                            <ul class="member">
                                <li class="kp">quen</li>
                                <li>カフェイン</li>
                            </ul>
                            <p class="caption">導入：友人と遊んだ帰り道、探索者は近所にあるループ橋を渡ることになる。</p>
                            <a class="btn block">詳細</a>
                        </div>
                    </div>
                    <div>
                        <div class="sess-date holiday">
                            <span class="month">3</span>
                            <span class="date">12</span>
                            <span class="week">日</span>
                            <div class="sess-time">
                                <span class="start">13:00</span>
                                <span class="end">18:00</span>
                            </div>
                        </div>
                        <div class="sess-data">
                            <h4><a href="https://booth.pm/ja/items/2276640" target="_blank"></a>狂気山脈　星ふる天辺</h4>
                            <ul class="inline member">
                                <li class="gm">quen</li>
                                <li class="sgm">あるす</li>
                                <li>カフェイン</li>
                                <li>吉澤</li>
                                <li>はたはた</li>
                                <li>ぺろりん</li>
                                <li>ケポン</li>
                            </ul>
                            <p class="caption">
                                概要：南極最奥地に発見された新たなる世界最高峰「狂気山脈」　そこで発見された異常な死体……そして、その死体の調査のために狂気山脈に乗り込んだ調査登山隊の中で起きた殺人事件。ブリザードのせいで山脈に閉じ込められた登山隊は、疑念と陰謀、そして狂気をはらんだまま調査を開始する。
                            </p>
                            <a class="btn block">詳細</a>
                        </div>
                    </div>
                    <div>
                        <div class="sess-date holiday">
                            <span class="month">4</span>
                            <span class="date">23</span>
                            <span class="week">日</span>
                            <div class="sess-time">
                                <span class="start">13:00</span>
                                <span class="end">17:00</span>
                            </div>
                        </div>
                        <div class="sess-data">
                            <h4><a href="https://dappleox.booth.pm/items/2877835" target="_blank"></a>狂気山脈　薄明三角点</h4>
                            <ul class="inline member">
                                <li class="gm">quen</li>
                                <li class="sgm">あるす</li>
                                <li>カフェイン</li>
                                <li>吉澤</li>
                                <li>はたはた</li>
                                <li>ぺろりん</li>
                                <li>ケポン</li>
                            </ul>
                            <p class="caption">
                                概要：南極最奥地に発見された新たなる世界最高峰「狂気山脈」　そこで発見された異常な死体……そして、その死体の調査のために狂気山脈に乗り込んだ調査登山隊の中で起きた殺人事件。ブリザードのせいで山脈に閉じ込められた登山隊は、疑念と陰謀、そして狂気をはらんだまま調査を開始する。
                            </p>
                            <a class="btn block" href="session/session.html">詳細</a>
                        </div>
                    </div>
                    <div>
                        <div class="sess-date saturday">
                            <span class="month">8</span>
                            <span class="date">15</span>
                            <span class="week">土</span>
                            <div class="sess-time">
                                <span class="start">12:30</span>
                            </div>
                        </div>
                        <div class="sess-data">
                            <h4><a target="_blank"></a>血飛沫、嗤う陽炎</h4>
                            <ul class="inline member">
                                <li class="kp">じん</li>
                                <li>ヒビヤ</li>
                            </ul>
                            <p class="caption">
                                炎天下、真夏の昼下がり。聞こえてくる蝉の大合唱はひとときの生を謳歌するかのよう。夏は嫌いと君は言うけれど、こうして君と話せているから僕は案外嫌いじゃない。嫌いじゃなかったのに――。
                            </p>
                            <a class="btn block">詳細</a>
                        </div>
                    </div>
                </div>
            </section>
            
            <section>
                <h2><span>イラストサムネ</span></h2>
                <div class="ill-thumbnail">
                    <div>
                        <a><img src="img/hyoushi.jpg">
                            <span>タイトルタイトルタイトルタイトル</span></a>
                        <div class="user"><a>ユーザー名</a></div>
                    </div>
                    <div>
                        <a><img src="img/hyoushi.jpg">
                            <span>タイトルタイトルタイトルタイトル</span></a>
                            <div class="user"><a>ユーザー名</a></div>
                    </div>
                    <div>
                        <a><img src="img/hyoushi.jpg">
                            <span>タイトルタイトルタイトルタイトル</span></a>
                            <div class="user"><a>ユーザー名</a></div>
                    </div>
                    <div>
                        <a><img src="img/hyoushi.jpg">
                            <span>タイトルタイトルタイトルタイトル</span></a>
                            <div class="user"><a>ユーザー名</a></div>
                    </div>
                    <div>
                        <a><img src="img/hyoushi.jpg">
                            <span>タイトルタイトルタイトルタイトル</span></a>
                            <div class="user"><a>ユーザー名</a></div>
                    </div>
                </div>
            </section>

            <section>
                <h2><span>小説サムネ</span></h2>
                <div class="novel-thumbnail">
                    <div>
                        <div class="novel-cover">
                            <a href="novel/novel.html"><img src="img/hyoushi.jpg">
                                <span>鹿島出版は今日も平和</span></a>
                        </div>
                        <div class="caption">
                            <h4><a href="novel.html">鹿島出版は今日も平和</a></h4>
                            <div class="user"><a>quen</a></div>
                            <ul class="hashtag">
                                <li><a>マダミス狂気山脈</a></li>
                                <li><a>鈴木臨子</a></li>
                            </ul>
                            <p>マダミス狂気山脈完結後、記者：鈴木臨子の後日談。</p>
                            <span class="length">2897文字</span>
                            <span class="readtime">5分</span>
                        </div>
                    </div>
                    <div>
                        <div class="novel-cover">
                            <a href="novel.html"><img src="img/hyoushi.jpg">
                                <span>タイトルタイトルタイトルタイトルタイトル</span></a>
                        </div>
                        <div class="caption">
                            <h4><a href="novel.html">タイトルタイトルタイトルタイトルタイトル</a></h4>
                            <div class="user"><a>ユーザー名</a></div>
                            <ul class="hashtag">
                                <li><a>タグ</a></li>
                                <li><a>タグ</a></li>
                            </ul>
                            <p>キャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプション</p>
                            <span class="length">10000文字</span>
                            <span class="readtime">1時間10分</span>
                        </div>
                    </div>
                    <div>
                        <div class="novel-cover">
                            <a href="novel.html"><img src="img/hyoushi.jpg">
                                <span>タイトルタイトルタイトルタイトルタイトル</span></a>
                        </div>
                        <div class="caption">
                            <h4><a href="novel.html">タイトルタイトルタイトルタイトルタイトル</a></h4>
                            <div class="user"><a>ユーザー名</a></div>
                            <ul class="hashtag">
                                <li><a>タグ</a></li>
                                <li><a>タグ</a></li>
                            </ul>
                            <p>キャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプション</p>
                            <span class="length">10000文字</span>
                            <span class="readtime">1時間10分</span>
                        </div>
                    </div>
                    <div>
                        <div class="novel-cover">
                            <a href="novel.html"><img src="img/hyoushi.jpg">
                                <span>タイトルタイトルタイトルタイトルタイトル</span></a>
                        </div>
                        <div class="caption">
                            <h4><a href="novel.html">タイトルタイトルタイトルタイトルタイトル</a></h4>
                            <div class="user"><a>ユーザー名</a></div>
                            <ul class="hashtag">
                                <li><a>タグ</a></li>
                                <li><a>タグ</a></li>
                            </ul>
                            <p>キャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプション</p>
                            <span class="length">10000文字</span>
                            <span class="readtime">1時間10分</span>
                        </div>
                    </div>
                </div>
            </section>
        </article>

        <article id="other">
            <h2><span>その他</span></h2>
            <h3><span>画像</span></h3>
            <div>
                <p>表示大</p>
                <img src="img/hyoushi.jpg">
            </div>
            <div class="img-thumbnail">
                <p>サムネイル表示</p>
                <img src="img/hyoushi.jpg">
                <img src="img/hyoushi.jpg">
                <img src="img/hyoushi.jpg">
                <img src="img/hyoushi.jpg">
                <img src="img/hyoushi.jpg">
            </div>
            <div class="img-thumbnail">
                <p>サムネイルから拡大表示</p>
                <a class="spotlight" href="img/hyoushi.jpg"><img src="img/hyoushi.jpg"></a>
                <a class="spotlight" href="img/hyoushi.jpg"><img src="img/hyoushi.jpg"></a>
                <a class="spotlight" href="img/hyoushi.jpg"><img src="img/hyoushi.jpg"></a>
                <a class="spotlight" href="img/hyoushi.jpg"><img src="img/hyoushi.jpg"></a>
                <a class="spotlight" href="img/hyoushi.jpg"><img src="img/hyoushi.jpg"></a>
            </div>
            <h3><span>カレンダー</span></h3>
            <div>
                <p>（準備中）</p>
                <table class="calendar">
                    <thead>
                        <tr>
                            <th>日</th>
                            <th>月</th>
                            <th>火</th>
                            <th>水</th>
                            <th>木</th>
                            <th>金</th>
                            <th>土</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td>22</td>
                            <td>23</td>
                            <td>24</td>
                            <td>25</td>
                            <td>26</td>
                            <td>27</td>
                        </tr>
                        <tr>
                            <td>28</td>
                            <td>29</td>
                            <td>30</td>
                            <td>31</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
    <script src="js/3rd/spotlight.bundle.js"></script>
    <script src="js/3rd/sha256.js"></script>
    <!-- script -->
    <script src="js/script.js"></script>
</body>
</html>