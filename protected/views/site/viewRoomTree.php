<?php
$commonName="комната ".$model->Number;
$this->pageTitle = Yii::app()->name . ' - '.$commonName;
$this->breadcrumbs = array(
    $commonName,
);

echo "<h1>$commonName</h1>";
$tree=$model->meets;
echo "<ul type='circle'>";
foreach ($tree as $item) {
    echo '<li>';
    echo $item->Meeting;
    {
        echo "<ul type='circle'>";
        foreach ($item->related_people  as $jtem) {
            echo '<li>';
            echo $jtem['Name'].'('.$jtem['dept']['Caption'].')';
            echo '</li>';
        }
        echo '</ul>';
    }
    echo '</li>';
}
echo '</ul>';

