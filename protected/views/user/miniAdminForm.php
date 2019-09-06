<?php
echo '<div class="row">';
echo '<div class="form">';
echo CHtml::beginForm('adminEdit', 'post', array('id'=>'EditUserForm'));
echo CHTML::hiddenField('ID', $model->ID);
echo CHTML::label('#'.$model->ID, '');
echo CHtml::label('&nbsp; Имя', '');
echo CHtml::textField('username', $model->username);
echo CHtml::label('Пароль', '');
echo CHtml::textField('password', '');
echo CHtml::label('Профиль', '');
echo CHtml::dropDownList('profile',$model->profile, ['signed'=>'Обычный','admin'=>'Админский']);
echo CHtml::submitButton('Удалить', ['submit'=>'adminDelete']);
echo CHtml::submitButton('Сохранить');
echo CHtml::endForm();
echo '</div>';//form
echo '</div>';//row