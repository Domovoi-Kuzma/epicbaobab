<?php
        /**
         * Created by PhpStorm.
         * User: Sasha
         * Date: 14.08.2019
         * Time: 13:13
         */
/**
 *  @author Sasha
 *
 *  Далее следуют параметры, передаваемые в рендер
 *  @var SiteController $this
 *  @var CActiveForm $form
 *  @var ModelCriteria $model модель формы параметров поиска
 */
        $this->pageTitle = Yii::app()->name . ' - поиск больших встреч';
        $this->breadcrumbs = array(
            ' поиск больших встреч',
        );
        echo '<h1>поиск больших встреч, на которых сотрудников больше критерия</h1>';

        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'CriteriaForm',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        ));
?>

<div class="row">
		<?php echo $form->labelEx($model,'criteria'); ?>
        <?php echo $form->textField($model,'criteria'); ?>
        <?php echo $form->error($model,'criteria'); ?>
</div>
<?php
        echo CHtml::submitButton('Submit');
        $this->endWidget();
        if (isset($model->results))
        {
            echo '<br> Вывод результата<ul>';
            foreach ($model->results as $meetingValue)
            {
                echo '<li>'.$meetingValue['Meeting'];
                foreach ($model->buddies[$meetingValue['ID'] ] as $buddyValue)
                {
                    echo "<ul>".$buddyValue['Name']."</ul>";
                }
                echo '</li>';
            }
            echo '</ul>';
        }
        else
            echo '<br> тут будет список, а пока что-то нету';
?>
