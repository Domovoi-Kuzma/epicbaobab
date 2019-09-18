
<h1>Users Tagged with nothing</h1>
<?php
/*
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_user',
    'template'=>"{items}\n{pager}",
)); */
/*
$this->widget('zii.widgets.grid.CGridView',
    [
        'dataProvider'=>$dataProvider,
        'columns'=>array('Name', 'dept'),//dept.Caption пишет но не фильтрует
        'template'=>"{items}\n{pager}",

        'filter'=>$model,
    ]
);
*/
$this->widget('ext.BootGroupGridView', array(
    'id'           => 'source-grid',
    'dataProvider' => $dataProvider,
    'filter'       => $model,
    'columns' => array(
        array(
            'type'  => 'raw',
            'name'  => 'Name',//'hotel_uid',
            'filter' =>
                CHtml::listData(
                    People::model()->findAll(),
                    "Name",
                    "Name"),
            'value'  => '$data->Name',
        ),
    ),
));
?>