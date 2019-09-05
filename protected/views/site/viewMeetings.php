<script>
<?php
//внимание! картинки отображаются в IE при указании папки CSS и наоборот в Chrome появляются только без папки!

echo "    var ajaxAddress='".$this->createUrl('toggleLike',['meeting_id'=>''])."';\n";
//URL адрес без конкретного айдишника в параметрах (его в скрипте конкатинируем в конец)
// т.е. строка примерно подобного вида index.php?r=site/toggleLike&meeting_id=
?>
    function toogleLikeRequest(elem, id) {
        var xhr = new XMLHttpRequest();

        xhr.onload = function() {//сюда будет приходить ответ от SiteController::actionToggleLike($meeting_id)
            if (xhr.status === 200)
            {//приходит ответ вида
                while (elem.firstChild) {
                    elem.removeChild(elem.firstChild);
                }
                var results=xhr.responseText.split("@");
                elem.style = "--picture: var(--"+results[0]+");";
                for (var i=1; i<results.length; i++) {
                    if(results[i]!="") {
                        if (i==1) results[i]+=" лайков";
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
    echo "<div onClick='toogleLikeRequest(this, $id);' class='button_icon' style=\"--picture: var(--".$likeParam['icon'].")\" >";
    echo '<span>';
    echo $likeParam['count']." лайков";
    echo '</span>';
    foreach($likeParam['tooltip'] as $lover) {
        echo '<span>';
        echo $lover;
        echo '</span>';
    }
    echo "</div>\n";
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