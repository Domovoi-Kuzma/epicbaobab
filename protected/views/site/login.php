<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 29.08.2019
 * Time: 18:58
 */
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
    'вход на сайт',
);
echo '<h1>Представьтесь, пожалуйста!</h1>';
echo '<div class="form">';
    echo CHtml::beginForm($action, 'post', array('id'=>'RoomForm'));

    echo '<div class="row">';
    echo CHtml::label('Имя пользователя', '');
    echo CHtml::textField('Username');
    echo '</div>';//row Название

    echo '<div class="row">';
    echo CHtml::label('Пароль', '');
    echo CHtml::textField('зфыыцщкв');
    echo '</div>';//row Название

    echo '<div class="row">';
    echo CHtml::submitButton('Submit');
    echo '</div>';//row кнопка
    echo CHtml::endForm();
echo '</div>';//form