<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 20.08.2019
 * Time: 15:40
 */
$this->pageTitle = Yii::app()->name . ' - список комнат';
$this->breadcrumbs = array(
    ' список комнат',
);

echo '<h1>Список - [комнаты]</h1>';

echo "<ul type='circle'>";
foreach ($items as $item)
{
    $address=$this->createURL("roomExplore", ['id'=>$item['ID']]);
    $delress=$this->createURL("roomDelete", ['id'=>$item['ID']]);
    echo '<li>';
    echo "<a href=$address>комната ".$item['Number']."</a>&nbsp;";
    echo "<a href=$delress>(удалить)</a>&nbsp;";
    echo '</li>';
}
echo '</ul>';
