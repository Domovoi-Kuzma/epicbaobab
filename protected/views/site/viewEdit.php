<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 12.08.2019
 * Time: 16:56
 */

/**
 * @var $model ModelShortList источник списка отображаемых опций
 * @var $what string опция 'employees' или 'meets
 * @var $this viewEdit  вывод страницы списка сотрудников.встреч
 */

if ($what=='employees') {
    $this->pageTitle = Yii::app()->name . ' - редактирование сотрудника';
    $this->breadcrumbs = array(
        ' редактирование сотрудника',
    );
    echo '<h1>редактирование - [сотрудник]</h1>';
    $prefix = '';
    $formaddress=$this->createUrl('site/saveEmployee');
}
else
{
    $this->pageTitle = Yii::app()->name . ' - редактирование встречи';
    $this->breadcrumbs = array(
        ' редактирование встреч',
    );
    echo '<h1>редактирование - [встречи]</h1>';
    $prefix = '';
    $formaddress=$this->createUrl('site/saveMeeting');
}

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'append-form',
    'action' =>$formaddress,
    //'enableClientValidation'=>false,//опции из примера проекта
    //'clientOptions'=>array(
    //    'validateOnSubmit'=>false,
    //),
));
echo $form->labelEx($model,'name');
echo $form->textField($model,'name');
echo '<br>';

echo $form->checkBoxList($model, 'checkedoptions', $model->options);//,  $model->checkedoptions
/*echo "today checked ".count($model->checkedoptions);
$j=0;
for ($i=0; $i<count($model->options); $i++)
{
    echo " <br> ".$model->options[$i];
 if ($j<count($model->checkedoptions) and $model->checkedoptions[$j]==$i)
 {
     echo " checked";
     $j++;
 }
 else
     echo " not checked";
}*/
echo $form->hiddenField($model, 'id');

echo '<br>';
echo CHtml::submitButton('Submit');
$this->endWidget();