<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 18:04
 */
$action='insertMeeting';
$this->pageTitle=Yii::app()->name . ' - добавление новой встречи';
$this->breadcrumbs=array(
    'добавление встречи',
);
echo '<h1>Форма!!! добавление новой встречи</h1>';

echo '<div class="form">';
echo CHtml::beginForm($action, 'post', array('id'=>'ShortForm'));
{
    {
        echo '<div class="row">';
        echo CHtml::label('Название встречи', '');
        echo CHtml::textField('NameInput', '');
        echo '</div>';
    }
    {
        echo '<div class="row">';
        $optionsP=People::model()->findAll();
        $superlist=CHTML::listData($optionsP, 'ID', 'Name');
        echo CHTML::checkBoxList('options',  [], $superlist);

        if (isset($optionsR[0]))
            $selection=$optionsR[0]['ID'];
        else
            $selection='';

        echo CHTML::radioButtonList('room',  $selection, CHTML::listData($optionsR, 'ID', 'Number'));
        echo '</div>';
    }
}
echo CHtml::submitButton('Submit');
echo CHtml::endForm();
echo '</div>';
?>