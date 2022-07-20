<div id="status"
     style='display: flex; width: 100%; height: 40px; justify-content: center; align-items: center;'>
</div>
<div style='display: flex; width: 100%;'>
    <div id='clock'></div>
    <div style='margin-left: 20px;'><?= $classroom_name ?></div>
    <div style='margin-left: 20px;'><?= $class_name ?></div>
    <div style='margin-left: 20px;'>メモ： <?= $memo ?></div>
</div>

<script>
    function getButtonClassString(studentStatus){
        const bassClass = 'enter_exit';
        switch(studentStatus) {
            case "READY_TO_ENTER":
                return `${bassClass} bg-primary`;
            case "READY_TO_EXIT":
                return `${bassClass} bg-warning`;
            case "LEFT":
                return `${bassClass} bg-secondary`;
            default:
                throw("student status: " + studentStatus + " is not supported");
        }
    }
</script>

<?php 
    function getAlignFromIndex($index) {
        $mod = $index % 3; 
        switch ($mod) {
            case 0:
                return 'start';
            case 1:
                return 'center';
            case 2:
                return 'end';
        }
    }
    // PHP, js is in the script section above, they should be synced
    function getButtonClassString($studentStatus){
        $base_class = 'enter_exit';
        switch($studentStatus) {
            case "READY_TO_ENTER":
                return $base_class . ' bg-primary';
            case "READY_TO_EXIT":
                return $base_class . ' bg-warning';
            case "LEFT":
                return $base_class . ' bg-secondary';
            default:
                throw("student status: ".$studentStatus . " is not supported");
        }
    }
?>

<?= $this->Html->script('realtimeClock'); ?>
<?= $this->Html->css('enterExit'); ?>
<div class="mt-2 d-flex align-content-start flex-wrap">
    <div class='container-fluid' style="margin-bottom: 20px;">
        <div class="d-md-flex p-2">
            <div style="margin-right: 8px;"><button type="button" class="btn btn-primary"></button>初期狀態</div>
            <div style="margin-right: 8px;"><button type="button" class="btn btn-warning"></button>入室</div>
            <div style="margin-right: 8px;"><button type="button" class="btn btn-secondary"></button>退室</div>
        </div>
    </div>
    <?php if(empty($students)): ?>
        <p>There is no student.</p>
    <?php endif; ?>
    <div style="width: 780px; height: 550px; overflow-y: scroll;">
     <div class="row" style='padding-bottom: 30px;'>
        <?php foreach($students as $index => $student): ?>
            <div class="col-sm-4 col-md-4 mb-4"> 
                <?= $this->Form->button(
                    $student_raw_names[$index],
                    [
                        'id' => $student->id,
                        'class' => getButtonClassString($student_states[$index]),
                        'student_status' => $student_states[$index],
                        'style' => 'width: 100%; height: 62px; padding: 0px 12px 0px 12px; overflow: hidden; border: none;'
                    ])
                ?>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</div>

<?= $this->Form->button(
    'Leave Button',
    [
        'id' => 'leave',
        'onclick' => 'leave()',
        'style' => 'position: absolute; bottom: 0; right: 0; height: 150px; width: 150px; opacity: 0.01; z-index: 1000;'
    ])
?>

<?= $this->Html->script('leaveButton'); ?>
<?= $this->Html->css('scrollBarFix'); ?>

<?= $this->Html->script('enterExitApis'); ?>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

<script>
    $(document).ready(() => {
        // For different buttons, we need different debounce function
        const debounceMap = {}; 

        $('.enter_exit').on('click', (e) => {
            const csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
            const studentId = e.target.id;

            if(!(studentId in debounceMap)) {
                // console.log('studentId', studentId);
                debounceMap[studentId] = _.debounce(changeStatus, 100);
            }
            const debounceFuncForStudent = debounceMap[studentId];

            // Get the calendar event id, here, this event id should be the event id the
            // of this class.
            const classEventID = "<?= $event_id ?>";
            const classroomName = "<?= $classroom_name ?>";

            // Update the button look accordingly.
            switch (e.target.getAttribute('student_status')) {
                case 'READY_TO_ENTER':
                    e.target.className = getButtonClassString('READY_TO_EXIT');
                    e.target.setAttribute('student_status', 'READY_TO_EXIT');
                    break;

                case 'READY_TO_EXIT':
                    e.target.className=getButtonClassString('LEFT');
                    e.target.setAttribute('student_status', 'LEFT');
                    break;
                case 'LEFT':
                    e.target.className = getButtonClassString('READY_TO_ENTER');
                    e.target.setAttribute('student_status', 'READY_TO_ENTER');
                    break;
            }

            const newStudentStatus = e.target.getAttribute('student_status');
            // The function to
            // 1. Update student status
            // 2. Log into enter_exit_logs table
            // 3. Send Line Notification to parents
            debounceFuncForStudent(
                csrfToken,
                studentId,
                classEventID,
                classroomName,
                newStudentStatus
            );

        })
    });
</script>
