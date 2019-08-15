<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 13:01
 */
$action='insertEmployeeForm';
$this->pageTitle=Yii::app()->name . ' - добавление нового сотрудника';
$this->breadcrumbs=array(
    'добавление сотрудника',
);
echo '<h1>Форма!!! добавление нового сотрудника</h1>';

echo '<div class="form">';
echo CHtml::beginForm($action, 'post', array('id'=>'ShortForm'));
{
    {
        echo '<div class="row">';
        echo CHtml::label('Name', '');
        echo CHtml::textField('NameInput', '');
        echo '</div>';
    }
    {
        echo '<div class="row">';
        $options=Meets::model()->findAll();
        $superlist=CHTML::listData($options, 'ID', 'Meeting');
        echo CHTML::checkBoxList('options',  [], $superlist);
        echo '</div>';
    }
}
echo CHtml::submitButton('Submit');
echo CHtml::endForm();
echo '</div>';




?>