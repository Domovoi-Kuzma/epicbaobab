<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 02.09.2019
 * Time: 10:57
 */
echo "<h1>Добавить пользователя</h1>";
echo '<div class="row">';
echo '<div class="form">';

if(Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">';
    echo Yii::app()->user->getFlash('error');
    echo '</div>';
}

echo CHtml::beginForm('adminInsert', 'post', array('id'=>'AddUserForm'));
echo CHtml::label('Имя', '');
echo CHtml::textField('username');
echo CHtml::label('Пароль', '');
echo CHtml::textField('password');
echo CHtml::label('Профиль', '');
echo CHtml::dropDownList('profile','user', ['signed'=>'Обычный','admin'=>'Админский']);
echo CHtml::submitButton('Добавить');
echo CHtml::endForm();
echo '</div>';//form
echo '</div>';//row
echo "<h1>Изменить пользователя</h1>";
foreach($users as $model)
    $this->renderPartial("miniAdminForm", ['model'=>$model]);

/**Перенести на LocalAdminForm.php
echo '<hr>';
echo "Изменить пользователя по ID";
echo '<div class="row">';
echo '<div class="form">';
echo CHtml::beginForm('index.php?r=user/adminDelete', 'post', array('id'=>'AddUserForm'));
echo CHtml::label('ID', '');
echo CHtml::textField('id');
echo CHtml::submitButton('Изменить');
echo CHtml::endForm();
echo '</div>';
echo '</div>';


echo '<hr>';
echo "Удалить пользователя";
echo '<div class="row">';
echo '<div class="form">';
echo CHtml::beginForm('index.php?r=user/adminDelete', 'post', array('id'=>'AddUserForm'));
echo CHtml::label('ID', '');
echo CHtml::textField('id');
echo CHtml::submitButton('Удалить');
echo CHtml::endForm();
echo '</div>';
echo '</div>';*/