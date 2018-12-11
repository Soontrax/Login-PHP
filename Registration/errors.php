

<?php if (count($errors)> 0): ?>

<div class="error">
    <?php
    foreach ($errors as $i){
    echo $i;
    echo "<br>";
    }
    ?>
</div>

<?php endif ?>