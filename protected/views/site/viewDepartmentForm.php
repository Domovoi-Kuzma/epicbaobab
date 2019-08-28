<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 21.08.2019
 * Time: 17:43
 */
echo '<h1>Форма(добавления/редактирования/отделения)!!!</h1>';
echo '<div class="form">';
    echo CHtml::beginForm($action, 'post', array('id'=>'DepartmentForm'));
        echo '<div class="row">';
            echo CHTML::hiddenField('ID', $model->ID);
            echo CHtml::label('Название отдела', '');
            echo CHtml::textField('CaptionInput', $model->Caption);
        echo '</div>';//row Название

        echo '<div class="row">';
            echo CHtml::submitButton('Submit');
        echo '</div>';//row кнопка
    echo CHtml::endForm();
echo '</div>';//form
