<?php
$xml = simplexml_load_file("{$dir}data/novel_lists.xml");
$novels = $xml->novel;
$member = parse_ini_file("{$dir}data/member.cgi", true);

enum SortOrder{
    case NewOrder;
    case OldOrder;
}

// strtotimeは後々問題になりそう（2038年問題）なのでやめる
function sortByKey($array, SortOrder $s) {
    $tmp = [];
    $result =[];
    for($i = 0 ; $i < count($array) ; $i++){
        $tmp += [["postday" => (string)$array[$i]->postday],["index" => $i]];
    }
    if($s === SortOrder::NewOrder){
        for($i = 0 ;$i < count($tmp) ; $i++){
            $postday = $tmp[$i]["postday"];
            $index = $tmp[$i]["index"];
            $count = 0;
            foreach($result as $data){
                $date_tmp = new DateTime($postday);
                $date_result = new DateTime($data->postday);
                if($date_result <= $date_tmp){
                    array_splice($result,$count,0,$array[$index]);
                    break;
                }
                if($count++ === count($result)){
                    $result += $array[$index];
                }
            }
        }
    }
    else{

    }

    //return $result;
    return $array;
}
?>

<div class='novel-thumbnail'>

<?php
//$novel_new_order = sortByKey($novels,SortOrder::NewOrder);

for ($i = 0; $i < count($novels); $i++) {
    if (isset($is_top) && $i > 3) {
        break;
    }

    $novel = $novels[$i];
    $userid = (string)$novel->userid;
    $postid = (string)$novel->postid;
    $user = (string)$novels[$i]["anonymous"] === "false" ? $member[$userid]["name"] : "匿名";
    $url = "/novel/novel?userid={$userid}&postid={$postid}";
    $imgurl = "/img/novel-cover/";
?>
    <div class="novel">
        <div>
            <div class="novel-cover">
                <a href="<?php echo $url; ?>"><img src="<?php echo "{$imgurl}{$novel->img}"; ?>"><span><?php echo "{$novel->title}"; ?></span></a>
            </div>
            <div class="caption">
                <h4><a href="<?php echo $url; ?>"></a></h4>
                <div class="user"><a><?php echo $user; ?></a></div>
                <?php if (isset($novel->tags)) { ?>
                <ul class="hashtag">
                    <?php foreach ($novel->tags->tag as $tag) { ?>
                    <li><a><?php echo $tag; ?></a></li>
                    <?php } // fpreach ?>
                </ul>
                <?php } // if (isset($novel->tags)) ?>
                <p><?php echo $novel->caption; ?></p>
                <div class="post-data">
                    <span class="length"><?php echo $novel->length; ?>文字</span>
                    <span class="readtime"><?php echo $novel->readtime; ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php } // for ?>
</div>
