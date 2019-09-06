<?php

$likeParam=$model->getLikeStatus();
echo "<div class='button_icon' style='--picture: var(--".$likeParam['icon'].")' >";
echo '<span style="--highlight: green">';
echo $likeParam['count']." лайков";
echo "</span>\n";
foreach($likeParam['tooltip'] as $lover) {
    echo '<span style="--highlight: black">';
    echo $lover;
    echo "</span>";
}
echo "</div>";