

<form method="post">
    <button type="submit" name="unsetSession">Unset Session</button>
</form>
<button onclick="setActive(list[0])">Run setActive Function</button>


<?php
include 'logout.action.php';

if (isset($_POST['unsetSession'])) {
    unsetSession();
}
?>