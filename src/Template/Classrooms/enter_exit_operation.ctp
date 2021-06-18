<div id="status" style='display: flex; width: 100%; height: 40px; justify-content: center; align-items: center; background: #AECFDF'></div>
<h1><?= $classroom_name ?></h1>
<div id='clock'></div>
<?= $this->Html->script('realtimeClock'); ?>
<div>
    <?php foreach($students as $student): ?>
        <?= $this->Html->link(
            $student->student_name,
            [
                'id' => $student->id,
                'class' => 'enter_exit',
            ])
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

<?= $this->Html->script('debounce'); ?>
<script>
    $(document).ready(() => {
        $('.enter_exit').on('click', (e) => {
            let csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
            let studentId = e.target.id;
            changeStatus(csrfToken, studentId);
            debounce(() => insertLogs(csrfToken, studentId))();
        })
    });
</script>