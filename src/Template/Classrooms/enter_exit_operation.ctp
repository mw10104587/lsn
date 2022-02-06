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
                    'class' => $student_states[$index] === 'READY_TO_ENTER' ?
                        'enter_exit me-3 w-15 btn btn-lg btn-primary' : 'enter_exit me-3 w-15 btn btn-lg btn-outline-primary',
                    'disabled' => $student_states[$index] === 'LEFT',
                    'student_status' => $student_states[$index],
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
            const csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
            const studentId = e.target.id;

            // Get the calendar event id, here, this event id should be the event id the
            // of this class.
            const classEventID = "<?= $event_id ?>";
            const classroomName = "<?= $classroom_name ?>";
            console.log('csrfToken', csrfToken);

            // The function to
            // 1. Update student status
            // 2. Log into enter_exit_logs table
            // 3. Send Line Notification to parents
            changeStatus(csrfToken, studentId, classEventID, classroomName);

            // Update the button look accordingly.
            switch (e.target.getAttribute('student_status')) {
                case 'READY_TO_ENTER':
                    e.target.className = 'enter_exit me-3 w-15 btn btn-lg btn-outline-primary';
                    e.target.setAttribute('student_status', 'READY_TO_EXIT');
                    break;

                case 'READY_TO_EXIT':
                    e.target.setAttribute('student_status', 'LEFT');
                    e.target.setAttribute('disabled', true);
                    break;
                default:
                    break;
            }

        })
    });
</script>
