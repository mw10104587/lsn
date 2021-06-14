<h1><?= $classroom_name ?></h1>
<div id='clock'></div>
<?= $this->Html->script('realtimeClock'); ?>
<div>
    <?php foreach($students as $student): ?>
        <?= $this->Form->postLink(
            $student->student_name,
            ['action' => 'enter_exit', $student->id])
        ?>
    <?php endforeach;?>
</div>

<?= $this->Form->button(
    'Leave Button',
    [
        'id' => 'leave',
        'onclick' => 'leave()',
        'style' => 'position: absolute; left:90%; top: 90%; height: 80px;'
    ])
?>
<?= $this->Html->script('leaveButton'); ?>
<?= $this->Html->css('scrollBarFix'); ?>