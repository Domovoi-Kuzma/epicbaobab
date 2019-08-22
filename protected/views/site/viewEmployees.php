<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 10:58
 */
/**
 * @author Sasha
 *
 *  Далее следуют параметры, передаваемые в рендер
 * @var SiteController  $this
 * @var People[]        $employees
 */
$this->pageTitle = Yii::app()->name . ' - список сотрудников';
$this->breadcrumbs = array(
    ' список сотрудников',
);
$formaddress=$this->createUrl('site/insertEmployee');

echo '<h1>Список - [сотрудники]</h1>';
echo "<ul type='circle'>";
foreach ($employees as $item)
{
    $editaddress=$this->createUrl('editEmployee',['id'=>$item['ID']]);
    $deleteaddress=$this->createUrl('deleteEmployee',['id'=>$item['ID']]);
    echo "<li>".$item['Name']." (".$item['dept']['Caption'].")";
    echo "&nbsp;<a href=$editaddress>изменить</a>/<a href=$deleteaddress>удалить</a>";
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

