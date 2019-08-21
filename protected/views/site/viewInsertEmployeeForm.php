<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 15.08.2019
 * Time: 13:01
 */
/**
 *  @author Sasha
 *
 *  Далее следуют параметры, передаваемые в рендер
 *  @var SiteController $this
 *  @var People         $model
*/
/**
 *  @var string         $action
 */
$action='insertEmployee';
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
        echo CHTML::hiddenField('ID', $model->ID);
        echo CHtml::label('Имя', '');
        echo CHtml::textField('NameInput', $model->Name);
        echo '</div>';
    }
    {
        echo '<div class="row">';
        echo CHTML::checkBoxList('options',  CHTML::listData($model->related_meets,'ID','ID'), CHTML::listData($optionsM, 'ID', 'Meeting'));

        if (isset($optionsD[0]))
            $selection=$optionsD[0]['ID'];
        else
            $selection='';
        echo CHTML::radioButtonList('Depato',  $model->dept['ID'], CHTML::listData($optionsD, 'ID', 'Caption'));
        echo '</div>';
    }
}
echo CHtml::submitButton('Submit');
echo CHtml::endForm();
echo '</div>';
?>