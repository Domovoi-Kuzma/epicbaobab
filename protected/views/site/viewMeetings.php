<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 12:20
 */
$this->pageTitle = Yii::app()->name . ' - список встреч';
$this->breadcrumbs = array(
    ' список встреч',
);
$editaddress=$this->createUrl('site/editMeeting');
$deleteaddress=$this->createUrl('site/deleteMeeting');
$formaddress=$this->createUrl('site/insertMeeting');
echo '<h1>Список - [встречи]</h1>';
$meetings=Meets::model()->findAll();
echo "<ul type='circle'>";
foreach ($meetings as $item)
{
    echo "<li>".$item['Meeting']." (room ".$item['room']['Number'].")(members: ".$item['memberCount'].")";
    echo "&nbsp;<a href=$editaddress/id/".$item['ID'].">изменить</a>/<a href=$deleteaddress/id/".$item['ID'].">удалить</a>";
    echo '<ul type="1">';
    foreach ($item['related_people'] as $jtem)
    {
        echo '<li>'. $jtem['Name'] .'</li>';
    }
    echo '</ul>';
    echo '</li>';
}
echo '</ul>';
echo '<hr>';
echo '<a href='.$formaddress.'>Форма добавления</a>';
echo '<hr>';