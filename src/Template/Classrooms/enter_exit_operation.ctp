<div id="status" style='display: flex; width: 100%; height: 40px; justify-content: center; align-items: center; background: #AECFDF'>
</div>

<div style='display: flex; width: 100%; height: 40px;'>
    <div id='clock'></div>
    <div style='margin-left: 20px;'><?= $classroom_name ?></div>
    <div style='margin-left: 20px;'><?= $class_name ?></div>
    <div style='margin-left: 20px;'>担当講師：</div>
</div>


<?= $this->Html->script('realtimeClock'); ?>
<div class="mt-2 d-flex align-content-start flex-wrap">
    <?php if(empty($students)): ?>
        <? echo debug($students); ?>
        <p>There is no student.</p>
    <?php endif; ?>
    <?php foreach($students as $index => $student): ?>
        <p>
            <?= $this->Form->button(
                $student_raw_names[$index],
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
            debounce(() => lineNotify(csrfToken, studentId, 'TEST_calendar_event_id'))();
        })
    });
</script>
