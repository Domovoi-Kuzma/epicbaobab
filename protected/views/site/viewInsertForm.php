<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:43
 */
/**
 * @var $model ModelInsertForm
 * @var $this viewInsertForm
 */
$this->pageTitle=Yii::app()->name . ' - '.$model->title;
$this->breadcrumbs=array(
    $model->title,
);

echo '<h1>Форма!!! добавление нового - '.$model->title.'</h1>';

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'append-form',
    'action' =>[$model->buttonAction],
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