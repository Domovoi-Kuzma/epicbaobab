<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:10
 */
/**
 * @var $model ModelList
 * @var $this viewList  вывод страницы списка сотрудников.встреч
 */
$this->pageTitle=Yii::app()->name . ' - '.$model->Header() ;
$this->breadcrumbs=array(
    $model->Header(),
);
echo '<h1>Список - '.$model->Header().'</h1>';
/**
 * @var $prefix string строка, прибавляемая спереди каждого подпункта списка. например "встреча " для встреч
 */
$prefix=$model->Prefix();
/**
 * @var $field string имя индекса массива подпунктов $RelativesList вытаскиваемого моделью из БД
 */
$field=$model->BuddyField();
	{
        print ("<ul type='circle'>");
        foreach ($model->NamesList() as $key=>$item)
        {
            $n=$item[$model->MyField()];
            echo "<li>$n";
            echo "<ul type='square'>";
            foreach($model->RelativesList($key) as $buddy)
            {
                echo "<li>$prefix &lt;$buddy[$field]&gt;</li>";
            }
            print ("</ul></li>");
        }
        echo '</ul>';
        echo '<hr>';
        echo '<a href='.$model->Form().'>Форма добавления</a>';
        echo '<hr>';
    }