<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 02.09.2019
 * Time: 10:57
 */
echo "Добавить пользователя";
echo '<div class="row">';
echo '<div class="form">';
echo CHtml::beginForm('index.php?r=user/adminInsert', 'post', array('id'=>'AddUserForm'));
echo CHtml::label('Имя', '');
echo CHtml::textField('username');
echo CHtml::label('Пароль', '');
echo CHtml::textField('password');
echo CHtml::label('Профиль', '');
echo CHtml::dropDownList('profile','user', ['guest'=>'Обычный','admin'=>'Админский']);
echo CHtml::submitButton('Добавить');
echo CHtml::endForm();
echo '</div>';
echo '</div>';
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