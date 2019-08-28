<?php
$action='insertMeeting';
$this->pageTitle=Yii::app()->name . ' - добавление новой встречи';
$this->breadcrumbs=array(
    'добавление встречи',
);
echo '<h1>Форма(добавления/редактирования) встречи</h1>';

echo '<div class="form">';
echo CHtml::beginForm($action, 'post', array('id'=>'ShortForm'));
{
    {
        echo '<div class="row">';
        echo CHTML::hiddenField('ID', $model->ID);
        echo CHtml::label('Название встречи', '');
        echo CHtml::textField('NameInput', $model->Meeting);
        echo '</div>';
    }
    {
        echo '<div class="row">';
        echo CHTML::checkBoxList('options', CHTML::listData($model->related_people,'ID','ID'), CHTML::listData($optionsP, 'ID', 'Name'));

        if (isset($optionsR[0]))
            $selection=$optionsR[0]['ID'];
        else
            $selection='';

        echo CHTML::radioButtonList('room', $model->room['ID'], CHTML::listData($optionsR, 'ID', 'Number'));
        echo '</div>';
    }
}
echo CHtml::submitButton('Submit');
echo CHtml::endForm();
echo '</div>';