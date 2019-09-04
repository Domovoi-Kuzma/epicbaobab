<script>
<?php
echo "    var ajaxAddress='".$this->createUrl('toggleLike',['meeting_id'=>''])."'\n";
$pic_url=['like_button_icon'=>"url('no_heart.png')", 'dislike_button_icon'=>"url('heart.png')"];
?>
    function pic_url(macro) {
        if (macro=='like_button_icon') return "url('css//no_heart.png')";
        if (macro=='dislike_button_icon') return "url('css//heart.png')";
    }
    function toogleLikeRequest(elem, id) {
        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200)
            {
                while (elem.firstChild) {
                    elem.removeChild(elem.firstChild);
                }
                var results=xhr.responseText.split("@");
                elem.style.backgroundImage = pic_url(results[0]);
                console.log("set image "+pic_url(results[0]));
                for (var i=1; i<results.length; i++) {
                    if(results[i]!="") {
                        console.log("set text " + results[i]);
                        var node = document.createElement("span");
                        var textnode = document.createTextNode(results[i]);
                        node.appendChild(textnode);
                        elem.appendChild(node);
                    }
                }
            }
        }
        xhr.open('GET',ajaxAddress+id, true);
        xhr.send(null);
    }
</script>
<?php
$this->pageTitle = Yii::app()->name . ' - список встреч';
$this->breadcrumbs = array(
    ' список встреч',
);
$formaddress=$this->createUrl('insertMeeting');

echo '<h1>Список - [встречи]</h1>';
echo "<ul type='circle'>";
foreach ($meetings as $item) {
    $id=$item['ID'];
    $editaddress=$this->createUrl('editMeeting',['id'=>$id]);
    $deleteaddress=$this->createUrl('deleteMeeting',['id'=>$id]);

    $commentaddress='index.php?r=user/comments&id='.$id;
    echo "<li>".$item['Meeting']." (room ".$item['room']['Number'].")(members: ".$item['memberCount'].")";

    echo "&nbsp;<a href=$editaddress>изменить</a>/<a href=$deleteaddress>удалить</a>";

    $likeParam=$item->getLikeStatus();
    var_dump($likeParam);
    echo "<div onClick='toogleLikeRequest(this, $id);' class='like_button_icon' style=\"--picture:".$pic_url[$likeParam['icon']]."\" >";
    foreach($likeParam['tooltip'] as $lover) {
        echo '<span>';
        echo $lover;
        echo '</span>';
    }
    echo "</div>\n";
    //var_dump($likeParam);
    echo '<ul type="1">';
    foreach ($item['related_people'] as $jtem) {
        echo '<li>'. $jtem['Name'].'('.$jtem['dept']['Caption'].')</li>';
    }
    echo '</ul>';
    echo '</li>';
}
echo '</ul>';
echo '<hr>';
echo '<a href='.$formaddress.'>Форма добавления</a>';
echo '<hr>';