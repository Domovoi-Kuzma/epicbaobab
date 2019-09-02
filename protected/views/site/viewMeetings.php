<?php
$this->pageTitle = Yii::app()->name . ' - список встреч';
$this->breadcrumbs = array(
    ' список встреч',
);
$formaddress=$this->createUrl('insertMeeting');
echo '<h1>Список - [встречи]</h1>';
echo "<ul type='circle'>";
foreach ($meetings as $item) {
    $editaddress=$this->createUrl('editMeeting',['id'=>$item['ID']]);
    $deleteaddress=$this->createUrl('deleteMeeting',['id'=>$item['ID']]);

    $commentaddress='index.php?r=user/comments&id='.$item['ID'];
    echo "<li>".$item['Meeting']." (room ".$item['room']['Number'].")(members: ".$item['memberCount'].")";
    echo "&nbsp;<a href=$editaddress>изменить</a>/<a href=$deleteaddress>удалить</a>/<a href=$commentaddress>комментарии</a>";
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