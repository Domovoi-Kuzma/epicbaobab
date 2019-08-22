<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 20.08.2019
 * Time: 17:43
 */
/**
 *  @author Sasha
 *
 *  Далее следуют параметры, передаваемые в рендер
 *  @var  SiteController $this
 *  @var  Department[] $items
 */
$this->pageTitle = Yii::app()->name . ' - список отделов';
$this->breadcrumbs = array(
    ' список отделов',
);

echo '<h1>Список - [отделовы]</h1>';

echo "<ul type='circle'>";
foreach ($items as $item)
{
    $address=$this->createURL("deptExplore", ['id'=>$item['ID']]);
    $delress=$this->createURL("deptDelete", ['id'=>$item['ID']]);
    echo '<li>';
    echo "<a href=$address>отдел ".$item['Caption']."</a>&nbsp;";
    echo "<a href=$delress>(удалить)</a>&nbsp;";
    echo '</li>';
}
echo '</ul>';
$address=$this->createURL("insertDepartment");
echo "<a href=$address>Добавить новый отдел</a>";