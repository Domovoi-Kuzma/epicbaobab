<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 10:58
 */
$this->pageTitle = Yii::app()->name . ' - список сотрудников';
$this->breadcrumbs = array(
    ' список сотрудников',
);
$editaddress=$this->createUrl('site/editEmployee');
$deleteaddress=$this->createUrl('site/deleteEmployee');
$formaddress=$this->createUrl('site/insertEmployee');

echo '<h1>Список - [сотрудники]</h1>';
$employees=People::model()->findAll();
echo "<ul type='circle'>";
foreach ($employees as $item)
{
    echo "<li>".$item['Name']." (".$item['dept']['Caption'].")";
    echo "&nbsp;<a href=$editaddress/id/".$item['ID'].">изменить</a>/<a href=$deleteaddress/id/".$item['ID'].">удалить</a>";
    echo "<ul type='1'>";
    foreach ($item['related_meets'] as $jtem)
    {
        echo '<li>'. $jtem['Meeting'] .'</li>';
    }
    echo '</ul>';
    echo '</li>';
}
echo '</ul>';
echo '<hr>';
echo '<a href='.$formaddress.'>Форма добавления</a>';
echo '<hr>';

/*
 * пишу отношение people MANY_MANY meets
 *
 * */


//$allpeople=people::model()->asArray()->all();
//print(var_dump($allpeople) );
