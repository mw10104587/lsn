<h1><?= $classroom ?></h1>
<div id='clock'></div>
<?= $this->Html->script('realtimeClock'); ?>
<div>
    <?php foreach($students as $student): ?>
        <?= $this->Form->postLink(
            $student->student_name,
            ['action' => 'enter_exit', $student->id],
            ['confirm' => 'Are you sure?'])
        ?>
    <?php endforeach;?>
</div>

<button id='leave' onClick='leave()'>Leave Button</button>
<?= $this->Html->script('leaveButton'); ?>