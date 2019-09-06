<?php
if ($isCurrent)
    $style='--picture: var(--like_button_icon)';
else
    $style='--picture: var(--dislike_button_icon)';
echo "<div class='button_icon' style='$style' >";
echo '<span style="--highlight: green">';
echo $likeCount." лайков";
echo "</span>\n";
foreach($tooltip as $otherlike) {
    echo '<span style="--highlight: black">';
    echo $otherlike->user->username;
    echo "</span>";
}
echo "</div>";