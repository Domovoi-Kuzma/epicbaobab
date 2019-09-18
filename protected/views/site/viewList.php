
<h1>Users Tagged with nothing</h1>
<?php
/*
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_user',
    'template'=>"{items}\n{pager}",
)); */

$this->widget('zii.widgets.grid.CGridView',
    [
        'dataProvider'=>$dataProvider,
        'columns'=>array('Name', 'Dept_ID'),
        'template'=>"{items}\n{pager}",

        'filter'=>$model,
    ]
);
?>