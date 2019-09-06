<?php
/*
 * <script>

    function testDivSwap(elem) {
        elem.innerHTML="<div class='like_button_icon' style=\"--picture:url('no_heart.png')\"><span>понравилось после клика</span></div>";
    }
</script>
<div onClick='testDivSwap(this);'>
<div class='like_button_icon' style="--picture:url('heart.png')">
    <span>Понравилось Саше</span>
    <span>Понравилось Максиму</span>
</div>
</div>
 */

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