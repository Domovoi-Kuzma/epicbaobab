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

if(Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">';
    echo Yii::app()->user->getFlash('error');
    echo '</div>';
}
echo '<h1>Представьтесь, пожалуйста!</h1>';
echo '<div class="form">';
    echo CHtml::beginForm('login', 'post', array('id'=>'SignupForm'));

    echo '<div class="row">';
    echo CHtml::label('Имя пользователя', '');
    echo CHtml::textField('username');
    echo '</div>';//row Логин

    echo '<div class="row">';
    echo CHtml::label('Пароль', '');
    echo CHtml::passwordField('password');
    echo '</div>';//row Пароль

    echo '<div class="row">';
    echo CHtml::submitButton('Войти');
    echo '</div>';//row кнопка
    echo CHtml::endForm();
echo '</div>';//form