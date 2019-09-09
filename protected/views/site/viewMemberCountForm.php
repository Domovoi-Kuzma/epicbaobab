<?php
        $this->pageTitle = Yii::app()->name . ' - поиск больших встреч';
        $this->breadcrumbs = array(
            ' поиск больших встреч',
        );
        echo '<h1>поиск больших встреч, на которых сотрудников больше критерия</h1>';

echo '<div class="form">';
    echo CHtml::beginForm('memberCountForm', 'post');


    echo '<div class="row">';
        echo CHtml::label('Введите минимальное число участников', '');
        echo CHtml::textField('count', '');
    echo '</div>';
    echo '<div class="row">';
            echo CHtml::submitButton('Submit');
    echo '</div>';
echo CHtml::endForm();
echo '</div>';
        if (isset($meetingList)) {
            echo '<br> Вывод результата<ul>';
            foreach ($meetingList as $meetingValue) {
                echo '<li>'.$meetingValue['Meeting'];
                foreach ($meetingValue['related_people'] as $buddyValue) {
                    echo "<ul>".$buddyValue['Name']."</ul>";
                }
                echo '</li>';
            }
            echo '</ul>';
        }
?>
