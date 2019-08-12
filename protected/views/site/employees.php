<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 07.08.2019
 * Time: 17:17
 */
/**
 * @deprecated
 */
$this->pageTitle=Yii::app()->name . ' - Список сотрудников';
$this->breadcrumbs=array(
    'список сотр.',
);
echo '<h1>Список - '.$model->Header().'</h1>';
	{
        print ("<ul type='circle'>");
        foreach ($model->NamesList() as $item)
        {
                $n=$item['Name'];
                echo "<li>$n";
                echo "<ul type='square'>";
                foreach($model->RelativesList($n) as $buddy)
                {
                        $b=$buddy['Meeting'];
                        echo "<li>встреча &lt;$b&gt;</li>";
                }
                print ("</ul></li>");
        }
        echo '</ul>';
        echo '<hr>';
    }