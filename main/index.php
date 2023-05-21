<?php
$title = "Imaginarium of the Table";
$is_index = true;
include("parts/head.php");

$login_user = $_COOKIE["loginuserid"] ?? null;
$login_pass = $_COOKIE["loginpass"] ?? "";
?>

<body id="INDEX">
    <main>
        <article>
            <h1><a href="/">Imaginarium of the Table</a></h1>
            <div class="center">
                <p>TRPG部 活動記録</p>
                <div id="loginResult"></div>
                <form>
                    <select>
                        <option value="none" hidden>ユーザー選択</option>
                        <?php
                        $member = parse_ini_file("data/member.cgi", true);
                        foreach ($member as $key => $value) {
                            $username = $member[$key]["name"];
                            if ($key === "0000") continue;
                            if ($key === $login_user) { ?>
                                <option value="<?php echo $key; ?>" selected><?php echo $username; ?></option>
                                <?php continue;
                            }?>
                            <option value="<?php echo $key; ?>"><?php echo $username; ?></option>
                        <?php }?>
                    <input type="text" placeholder="password" id="loginPass" value="<?php echo $login_pass; ?>">
                    <button type="button" id="login" <?php echo $login_user!==null ?? 'disabled' ?>disabled>ログイン</button>
                </form>
            </div>
        </article>
    </main>

    <?php include_once("parts/footer.php"); ?>
    <script>
        $(function() {
            $("#loginPass").on("input", function() {
                let is_disabled = $(this).val().length == 0 && $("select option:selected").val() == "none"
                $("#login").prop("disabled", is_disabled);
            })

            $("select").change(function() {
                let is_disabled = $("#loginPass").val().length == 0;
                $("#login").prop("disabled", is_disabled);
            })

            $("#login").click(function() {
                let $user = $("select").val();
                let $pass = $("#loginPass").val();
                $.ajax({
                        url: "/_module/login",
                        type: "POST",
                        data: {
                            login: true,
                            user: $user,
                            pass: $pass
                        },
                        dataType: "json",
                        timespan: 1000,
                })
                    .done(function(data) {
                        if (data["result"] === "success") location.href = data["next"];
                        else {
                            $("#loginResult").addClass("fail");
                        }
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        $("#loginResult").addClass("error");
                    })
            })
        })
    </script>
</body>

</html>