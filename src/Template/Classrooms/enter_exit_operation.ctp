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
            <div style="margin-right: 8px;"><button type="button" class="btn btn-secondary"></button>サインアウト</div>
            <div><button type="button" class="btn btn-secondary" disabled></button>教室を出た</div>
        </div>
    </div>
    <?php if(empty($students)): ?>
        <? echo debug($students); ?>
        <p>There is no student.</p>
    <?php endif; ?>
    <div>
        <?php foreach($students as $index => $student): ?>
            <p>
                <?= $this->Form->button(
                    $student_raw_names[$index],
                    [
                        'id' => $student->id,
                        'class' => $student_states[$index] === 'READY_TO_ENTER' ?
                            'enter_exit me-3 w-15 btn btn-lg btn-primary' : 'enter_exit me-3 w-15 btn btn-lg btn-secondary',
                        'disabled' => $student_states[$index] === 'LEFT',
                        'student_status' => $student_states[$index],
                    ])
                ?>
            </p>
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
            // console.log('csrfToken', csrfToken);

            // The function to
            // 1. Update student status
            // 2. Log into enter_exit_logs table
            // 3. Send Line Notification to parents
            changeStatus(csrfToken, studentId, classEventID, classroomName);

            // Update the button look accordingly.
            switch (e.target.getAttribute('student_status')) {
                case 'READY_TO_ENTER':
                    e.target.className = 'enter_exit me-3 w-15 btn btn-lg btn-secondary';
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
