<?php
if (!isset($_POST['novel-edit'])) {
    $develop_mode = isset($_COOKIE['develop']);
    $userid = $_COOKIE['loginuserid'];
    if (isset($_POST['passsubmit'])) {
        $pass = $_POST['passchange'];
        $passhash = hash('sha256', $pass);
        setcookie('loginpass', $pass);
        setcookie('loginhash', $passhash);
        $config = parse_ini_file('../data/config.cgi');
        $config[$userid] = $passhash;
        $fp = fopen('../data/config.cgi', 'w');
        foreach ($config as $k => $i) fputs($fp, "$k=$i\n");
        fclose($fp);
        header('location:index?pswd=success');
        exit;
    }

    // 小説公開リスト
    $novel_xml = simplexml_load_file('../data/novel_lists.xml');

    // 小説個人リスト
    $path = !$develop_mode ? '../data/' . $userid . '/novel/lists.xml' : '../data/0000/novel/lists.xml';
    $novel_lists = simplexml_load_file($path);
    $novels = $novel_lists->novel;
    if (isset($_POST['toggle'])) {
        $userid = $develop_mode ? '0000' : $userid;
        $rm = explode('-', $_POST['post-info']);
        if ($rm[0] == 'novel') {
            $result = '';
            if ($_POST['is_public'] == 'true') {
                $index = 0;
                foreach ($novels as $n) {
                    if ($rm[1] == $n->postid) {
                        break;
                    }
                    $index++;
                }
                $add = $novels[$index];
                $node = $novel_xml->addChild('novel');
                $node['anonymous'] = $add['anonymous'];
                $node->addChild('title', $add->title);
                $node->addChild('img', $add->img);
                $node->addChild('userid', $userid);
                $node->addChild('postid', $add->postid);
                $node->addChild('category', $add->category);
                $tags = $node->addChild('tags');
                if (!empty($add->$taglist)) {
                    foreach ($add->$taglist as $tag) {
                        $tags->addChild('tag', $tag);
                    }
                }
                $node->addChild('caption', $add->caption);
                $node->addChild('length', $add->length);
                $node->addChild('readtime', $add->readtime);
                $node->addChild('postday', $add->postday);
                $node->addChild('updateday', $add->updateday);
                $result = 'public';
            } else {
                $index = 0;
                foreach ($novel_xml->novel as $n) {
                    if ($userid == $n->userid && $rm[1] == $n->postid) {
                        break;
                    }
                    $index++;
                }
                unset($novel_xml->novel[$index]);
                $result = 'private';
            }
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->preserveWhiteSpace = true;
            $dom->formatOutput = true;
            $dom->loadXML($novel_xml->asXML());
            $dom->save('../data/novel_lists.xml');
            header('location:index?type=novel&result='.$result.'#novel-list');
            exit;
        }
    }

    if (isset($_POST['novel-remove'])) {
        $rm = explode('-', $_POST['post-info']);
        $userid = $develop_mode ? '0000' : $userid;
        // 公開用リストから削除
        $index = 0;
        foreach ($novel_xml->novel as $n) {
            if ($userid == $n->userid && $rm[1] == $n->postid) {
                break;
            }
            $index++;
        }
        unset($novel_xml->novel[$index]);
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput = true;
        $dom->loadXML($novel_xml->asXML());
        $dom->save('../data/novel_lists.xml');

        // 個人リストから削除
        $index = 0;
        foreach ($novel_lists->novel as $n) {
            if ($rm[1] == $n->postid) {
                break;
            }
            $index++;
        }
        unset($novel_lists->novel[$index]);
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput = true;
        $dom->loadXML($novel_lists->asXML());
        $dom->save($path);

        // 作品ファイル削除
        $file_name = $rm[1] . '.xml';
        unlink('../data/' . $userid . '/novel/' . $file_name);
        header('location:index?type=novel&result=delete#novel-list');
        exit;
    }
}

