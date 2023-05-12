<?php
$xml = simplexml_load_file($dir . 'data/novel_lists.xml');
$novels = $xml->novel;

echo '<div class="novel-thumbnail">';

$count = 0;
for ($i = count($xml) - 1; $i >= 0; $i--) {
    if (isset($is_top) && $count > 3) {
        break;
    }
    $count++;

    $novel = $novels[$i];
    $userid = $novel->userid;
    $user = $novels[$i]['anonymous'] == 'false' ? $member[(string)$userid]['name'] : '匿名';
    $url = $dir . 'novel/novel?userid=' . $userid . '&postid=' . $novel->postid;
    $imgurl = $dir . 'img/novel-cover/';
    echo '<div class="novel">
                <div>
                    <div class="novel-cover">
                        <a href="' . $url . '"><img src="' . $imgurl . (string)$novel->img . '"><span>' . (string)$novel->title . '</span></a>
                    </div>
                    <div class="caption">
                        <h4><a href="' . $url . '"></a></h4>
                        <div class="user"><a>' . $user . '</a></div>';
    if (isset($novel->tags)) {
        echo '<ul class="hashtag">';
        foreach ($novel->tags->tag as $tag) {
            echo '<li><a>' . (string)$tag . '</a></li>';
        }
        echo '</ul>';
    }
    echo '<p>' . (string)$novel->caption . '</p>
            <div class="post-data">
                <span class="length">' . $novel->length . '文字</span>
                <span class="readtime">' . $novel->readtime . '</span>
            </div></div></div></div>';
}
echo '</div>';
