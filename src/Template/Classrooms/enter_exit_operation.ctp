<h1><?= $classroom ?></h1>
<h2><?= $now ?></h2>
<?php foreach($students as $student): ?>
    <?= $student->student_name?>
<?php endforeach;?>