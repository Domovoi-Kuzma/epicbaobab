<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:10
 */
/**
 * @var $model ModelFullList
 * @var $what string опция 'employees' или 'meets
 * @var $this viewList  вывод страницы списка сотрудников.встреч
 */
/**
 * @var $prefix string строка, прибавляемая спереди каждого подпункта списка. например "встреча " для встреч
 */

if ($what=='employees') {
    $this->pageTitle = Yii::app()->name . ' - список сотрудников';
    $this->breadcrumbs = array(
        ' список сотрудников',
    );
    echo '<h1>Список - [сотрудники]</h1>';
    $prefix = 'встреча';
    $formaddress=$this->createUrl('site/insertEmployeeForm');
    $editaddress=$this->createUrl('site/editEmployee');
    $deleteaddress=$this->createUrl('site/delete/what/employees');
}
else
{
    $this->pageTitle = Yii::app()->name . ' - список встреч';
    $this->breadcrumbs = array(
        ' список встреч',
    );
    echo '<h1>Список - [встречи]</h1>';
    $prefix = 'коллега';
    $formaddress=$this->createUrl('site/insertMeetingForm');
    $editaddress=$this->createUrl('site/editMeeting');
    $deleteaddress=$this->createUrl('site/delete/what/meets');
}
/**
 * @var $field string имя индекса массива подпунктов $RelativesList вытаскиваемого моделью из БД
 */
$field = $model->BuddyField();
	{
        print ("<ul type='circle'>");
        foreach ($model->NamesList() as $key=>$item)
        {
            $n=$item[$model->MyField()];
            $id=$item['ID'];
            echo "<li>$n <a href=$editaddress/id/$id>изменить</a>/<a href=$deleteaddress/id/$id>удалить</a>";
            echo "<ul type='square'>";
            foreach($model->RelativesList($id) as $buddy)
            {
                echo "<li>$prefix &lt;$buddy[$field]&gt;</li>";
            }
            print ("</ul></li>");
        }
        echo '</ul>';
        echo '<hr>';
        echo '<a href='.$formaddress.'>Форма добавления</a>';
        echo '<hr>';
    }