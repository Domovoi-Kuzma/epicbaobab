<?php
$commonName="отдел ".$model->Caption;
$this->pageTitle = Yii::app()->name . ' - '.$commonName;
$this->breadcrumbs = array(
    $commonName,
);

echo "<h1>$commonName</h1>";
$tree=$model->peoples;
echo "<ul type='circle'>";
foreach ($tree as $item) {
    echo '<li>';
    echo $item->Name;
    {
        echo "<ul type='circle'>";
        foreach ($item->related_meets  as $jtem) {
            echo '<li>';
            echo $jtem['Meeting'].'('.$jtem['room']['Number'].')';
            echo '</li>';
        }
        echo '</ul>';
    }
    echo '</li>';
}
echo '</ul>';

