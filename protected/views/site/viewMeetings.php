<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 12:20
 */

/**
 * @author Sasha
 *
 *  Далее следуют параметры, передаваемые в рендер
 * @var SiteController  $this
 * @var Meets[]        $meetings
 */
$this->pageTitle = Yii::app()->name . ' - список встреч';
$this->breadcrumbs = array(
    ' список встреч',
);
$formaddress=$this->createUrl('site/insertMeeting');
echo '<h1>Список - [встречи]</h1>';
echo "<ul type='circle'>";
foreach ($meetings as $item)
{
    $editaddress=$this->createUrl('site/editMeeting',['id'=>$item['ID']]);
    $deleteaddress=$this->createUrl('site/deleteMeeting',['id'=>$item['ID']]);
    echo "<li>".$item['Meeting']." (room ".$item['room']['Number'].")(members: ".$item['memberCount'].")";
    echo "&nbsp;<a href=$editaddress>изменить</a>/<a href=$deleteaddress>удалить</a>";
    echo '<ul type="1">';
    foreach ($item['related_people'] as $jtem)
    {
        echo '<li>'. $jtem['Name'].'('.$jtem['dept']['Caption'].')</li>';
    }
    echo '</ul>';
    echo '</li>';
}
echo '</ul>';
echo '<hr>';
echo '<a href='.$formaddress.'>Форма добавления</a>';
echo '<hr>';