<div id="status" style='display: flex; width: 100%; height: 40px; justify-content: center; align-items: center; background: #AECFDF'></div>
<h1><?= $classroom_name ?></h1>
<div id='clock'></div>
<?= $this->Html->script('realtimeClock'); ?>
<div class="mt-2 align-content-start flex-wrap">
    <?php if(empty($classes)): ?>
        <p><?= env('DEBUG', false) ? "There's no classes today." : '今日は授業はありません。' ?></p>
    <?php endif; ?>
    <?php foreach($classes as $class): ?>
        <p>
            <?= $this->Html->link($class['class_name'],
                [
                    'action' => 'enter_exit_operation',
                    $calendar_id , $class['class_name'], $classroom_name, $class['event_id']
                ],
                [
                    'class' => 'w-15 btn btn-lg btn-primary',
                    'role' => 'button'
                ])
            ?>
        </p>
        <?php endforeach?>
    <? echo debug($students); ?>
</div>


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
