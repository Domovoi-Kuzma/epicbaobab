<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:43
 */
/**
 * @var $model ModelShortList
 * @var $what string опция 'employees' или 'meets
 * @var $this viewInsertForm
 */
if ($what=='employees')
{
    $this->pageTitle=Yii::app()->name . ' - добавление нового сотрудника';
    $this->breadcrumbs=array(
        'добавление сотрудника',
    );
    echo '<h1>Форма!!! добавление нового сотрудника</h1>';
    $action='site/insert_employees';
}
else//$what=='meets'
{
    $this->pageTitle=Yii::app()->name . ' - добавление новой встречи';
    $this->breadcrumbs=array(
        'добавление встречи',
    );
    echo '<h1>Форма!!! добавление новой встречи</h1>';
    $action='site/insert_meets';

}

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'append-form',
    'action' =>[$action],
    //'enableClientValidation'=>false,//опции из примера проекта
    //'clientOptions'=>array(
    //    'validateOnSubmit'=>false,
    //),
));
echo $form->labelEx($model,'name');
echo $form->textField($model,'name');
echo '<br>';

echo $form->checkBoxList($model, 'options', $model->options);

echo '<br>';
echo CHtml::submitButton('Submit');
$this->endWidget();

?>