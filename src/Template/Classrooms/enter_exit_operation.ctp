<div id="status"
     style='display: flex; width: 100%; height: 40px; justify-content: center; align-items: center;'>
</div>
<div style='display: flex; width: 100%; height: 40px;'>
    <div id='clock'></div>
    <div style='margin-left: 20px;'><?= $classroom_name ?></div>
    <div style='margin-left: 20px;'><?= $class_name ?></div>
    <div style='margin-left: 20px;'>メモ： <?= $memo ?></div>
</div>

<?= $this->Html->script('realtimeClock'); ?>
<div class="mt-2 d-flex align-content-start flex-wrap">
    <div class='container-fluid' style="margin-bottom: 20px;">
        <div class="d-md-flex p-2">
            <div style="margin-right: 8px;"><button type="button" class="btn btn-primary"></button>ログイン</div>
            <div style="margin-right: 8px;"><button type="button" class="btn btn-warning"></button>サインアウト</div>
            <div style="margin-right: 8px;"><button type="button" class="btn btn-secondary"></button>教室を出た</div>
        </div>
    </div>
    <?php if(empty($students)): ?>
        <? echo debug($students); ?>
        <p>There is no student.</p>
    <?php endif; ?>
    <div style="display: flex; max-width: 500px; flex-wrap: wrap; column-gap: 12px; row-gap: 16px;"> 
        <?php foreach($students as $index => $student): ?>
            <div style="flex-basis: 140px; flex-shrink: 0; flex-grow: 1;">
                <?= $this->Form->button(
                    $student_raw_names[$index],
                    [
                        'id' => $student->id,
                        'class' => $student_states[$index] === 'READY_TO_ENTER' ?
                            'enter_exit btn btn-lg btn-primary btn-block' :
                            ($student_states[$index] === 'READY_TO_EXIT' ? 'enter_exit btn btn-lg btn-warning': 'enter_exit btn btn-lg btn-secondary btn-block'),
                        // 'disabled' => $student_states[$index] === 'LEFT',
                        'student_status' => $student_states[$index],
                    ])
                ?>
            </div>
        <?php endforeach;?>
    </div>
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

<?= $this->Html->script('enterExitApis'); ?>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

<script>
    $(document).ready(() => {
        debouncedChangeStatus = _.debounce(changeStatus, 5000)
        $('.enter_exit').on('click', (e) => {
            const csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
            const studentId = e.target.id;

            // Get the calendar event id, here, this event id should be the event id the
            // of this class.
            const classEventID = "<?= $event_id ?>";
            const classroomName = "<?= $classroom_name ?>";
            // console.log('csrfToken', csrfToken);

            // Update the button look accordingly.
            switch (e.target.getAttribute('student_status')) {
                case 'READY_TO_ENTER':
                    e.target.className = 'enter_exit me-3 w-15 btn btn-lg btn-warning';
                    e.target.setAttribute('student_status', 'READY_TO_EXIT');
                    break;

                case 'READY_TO_EXIT':
                    e.target.className = 'enter_exit me-3 w-15 btn btn-lg btn-secondary';
                    e.target.setAttribute('student_status', 'LEFT');
                    // e.target.setAttribute('disabled', true);
                    break;
                case 'LEFT':
                    e.target.className = 'enter_exit me-3 w-15 btn btn-lg btn-primary';
                    e.target.setAttribute('student_status', 'READY_TO_ENTER');
                    // e.target.setAttribute('disabled', true);
                    break;
            }

            const newStudentStatus = e.target.getAttribute('student_status');
            console.log('newStudentStatus', newStudentStatus);
            // The function to
            // 1. Update student status
            // 2. Log into enter_exit_logs table
            // 3. Send Line Notification to parents
            debouncedChangeStatus(
                csrfToken,
                studentId,
                classEventID,
                classroomName,
                newStudentStatus
            );

        })
    });
</script>
