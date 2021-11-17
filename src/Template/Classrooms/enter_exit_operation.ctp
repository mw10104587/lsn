<div id="status" style='display: flex; width: 100%; height: 40px; justify-content: center; align-items: center; background: #AECFDF'></div>
<h1><?= $class_name ?></h1>
<div id='clock'></div>
<?= $this->Html->script('realtimeClock'); ?>
<div class="mt-2 d-flex align-content-start flex-wrap">
    <?php if(empty($students)): ?>
        <? echo debug($students); ?>
        <p>There is no student.</p>
    <?php endif; ?>
    <?php foreach($students as $student): ?>
        <p>
            <?= $this->Form->button(
                $student->student_name,
                [
                    'id' => $student->id,
                    'class' => 'enter_exit me-3 w-15 btn btn-lg btn-outline-primary',
                ])
            ?>
        </p>
    <?php endforeach;?>
    <? echo debug($students); ?>
</div>

<?= $this->Form->button(
    'Leave Button',
    [
        'id' => 'leave',
        'onclick' => 'leave()',
        'style' => 'position: absolute; bottom: 0; right: 0; height: 150px; width: 150px; opacity: 0;'
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
            debounce(() => lineNotify(csrfToken, studentId))();
        })
    });
</script>
