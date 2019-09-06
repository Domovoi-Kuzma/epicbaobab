<?php
echo '<h1>Форма(добавления/редактирования/комнаты)!!!</h1>';
echo '<div class="form">';
    echo CHtml::beginForm($action, 'post', array('id'=>'RoomForm'));
        echo '<div class="row">';
            echo CHTML::hiddenField('ID', $model->ID);
            echo CHtml::label('Номер комнаты', '');
            echo CHtml::textField('NumberInput', $model->Number);
        echo '</div>';//row Название

        echo '<div class="row">';
            echo CHtml::submitButton('Submit');
        echo '</div>';//row кнопка
    echo CHtml::endForm();
echo '</div>';//form