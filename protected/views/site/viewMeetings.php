<script>
<?php
echo "    var ajaxAddress='".$this->createUrl('toggleLike',['meeting_id'=>''])."'\n";
?>
    function changeDivIcon(id) {
        if (id.className == 'dislike_button_icon') {
            id.className = 'like_button_icon';
        }
        else
            id.className = 'dislike_button_icon';
    }
    function toogleLikeRequest(elem, id) {
        elem.className = 'wait_button_icon';
        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200)
            {
                var results=xhr.responseText.split("@");
                elem.className = results[0];
                if (results.length>1)
                    elem.title=results[1];
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
    $likeParam=$item->getLikeStatus();
    var_dump($likeParam);

    echo "<li>".$item['Meeting']." (room ".$item['room']['Number'].")(members: ".$item['memberCount'].")";

    echo "&nbsp;<a href=$editaddress>изменить</a>/<a href=$deleteaddress>удалить</a>";

    echo "<div title='".$likeParam['tooltip']."' onClick='toogleLikeRequest(this, $id)' class='".$likeParam['icon']."' param='$id'></div>";
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