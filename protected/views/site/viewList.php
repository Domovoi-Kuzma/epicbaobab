<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:10
 */
$this->pageTitle=Yii::app()->name . ' - '.$model->Header() ;
$this->breadcrumbs=array(
    $model->Header(),
);
echo '<h1>Список - '.$model->Header().'</h1>';
$prefix=$model->Prefix();
$field=$model->BuddyField();
	{
        print ("<ul type='circle'>");
        foreach ($model->NamesList() as $item)
        {
            $n=$item[$model->MyField()];
            echo "<li>$n";
            echo "<ul type='square'>";
            foreach($model->RelativesList($n) as $buddy)
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