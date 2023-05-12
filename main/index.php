<?php
session_start();
$login_error = isset($_GET['login']) ? $_GET['login'] : false;
$login_user = isset($_COOKIE['loginuserid']) ? $_COOKIE['loginuserid'] : '';
$loginpass = isset($_COOKIE['loginpass']) ? $_COOKIE['loginpass'] : '';

if (isset($_POST['login'])) {
    $userid = $_POST['username'];
    $pass = $_POST['password'];
    $passhash = hash('sha256', $pass);
    $config = parse_ini_file('data/config.cgi');
    if(isset($_COOKIE['develop'])){
        unset($_COOKIE['develop']);
    }
    if (array_key_exists($userid, $config)) {
        if ($config[$userid] === $passhash) {
            // 2038年問題対策
            if (int_overflow(time())) {
                setcookie('loginuserid', $userid);
                setcookie('loginpass', $pass);
                setcookie('loginhash', $passhash);
            }
            else {
                // 1ヶ月保存
                $time = time() + (60 * 60 * 24 * 30);
                setcookie('loginuserid', $userid,$time);
                setcookie('loginpass', $pass,$time);
                setcookie('loginhash', $passhash,$time);
            }
            if($userid === 'develop'){
                // 開発者モード
                setcookie('develop', 'true');
            }
            LoginSuccess();
            exit;
        }
    }

    if ($config['guest'] === $passhash) {
        if(isset($_COOKIE['develop'])) unset($_COOKIE['develop']);
        if(isset($_COOKIE['loginpass'])) unset($_COOKIE['loginpass']);
        if(isset($_COOKIE['loginhash'])) unset($_COOKIE['loginhash']);
        setcookie('loginuserid', 'guest');
        LoginSuccess();
        exit;
    }

    if (!isset($_SESSION['HTTP_REFERER'])) {
        $_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
    }
    $url = $_SERVER['PHP_SELF'];
    $start = mb_strrpos($url, '.');
    $url =  substr_replace($url, '', $start);
    header("Location: " . $url . '?login=error');
    exit;
}

function LoginSuccess()
{
    $nextPage = 'top';
    if ($_SERVER['HTTP_HOST'] === 'imaginarium-of-the-table.wew.jp') {
        $nextPage = isset($_SESSION['HTTP_REFERER']) ? $_SESSION['HTTP_REFERER'] : $_SERVER['HTTP_REFERER'];
    }
    header('Location:' . $nextPage);
    if(isset($_SESSION['HTTP_REFERER'])) unset($_SESSION['HTTP_REFERER']);
}

function int_overflow($v)
{
    return is_nan($v) || ($v === INF) || ($v === -INF) || (bccomp(PHP_INT_MAX, $v) === -1);
}

$title = 'Imaginarium of the Table';
$is_index = true;
include('_module/head.php');
?>

<body id="INDEX">
    <main>
        <article>
            <h1><a href="index">Imaginarium of the Table</a></h1>
            <div class="center">
                <p>TRPG部 活動記録</p>
                <div id="loginResult" <?php echo $login_error ? 'class="error"' : ''; ?>></div>
                <form action="" method="post">
                    <select name="username" required>
                        <option hidden value="">ユーザー選択</option>
                        <?php
                        $member = parse_ini_file('data/member.ini', true);
                        foreach ($member as $key => $value) {
                            if ($key === '0000') continue;
                            if($key === $login_user){
                                echo '<option value="' . $key . '" selected>' . (string)$member[$key]['name'] . '</option>';
                                continue;
                            }
                            echo '<option value="' . $key . '">' . (string)$member[$key]['name'] . '</option>';
                        }
                        ?>
                        <input type="text" name="password" placeholder="password" id="loginPass" <?php echo 'value="'.$loginpass.'"';?> required>
                        <input type="submit" name="login" id="login">
                </form>
                <button id="loguindel" type="button" class="margin-top-3">ログイン情報削除</button>
            </div>
        </article>
    </main>

    <?php include_once('_module/footer.php'); ?>
    <script>
        $('#loguindel').click(function(){
            <?php
            if(isset($_COOKIE['develop'])) unset($_COOKIE['develop']);
            if(isset($_COOKIE['loginuserid'])) unset($_COOKIE['loginuserid']);
            if(isset($_COOKIE['loginpass'])) unset($_COOKIE['loginpass']);
            if(isset($_COOKIE['loginhash'])) unset($_COOKIE['loginhash']);
            $url = $_SERVER['PHP_SELF'];
            $start = mb_strrpos($url, '.');
            $url =  substr_replace($url, '', $start);
            header("Location: " . $url);
            exit;
            ?>
        })
    </script>
</body>

</html>