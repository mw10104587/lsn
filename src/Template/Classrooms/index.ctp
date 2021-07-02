<h1><?= __('Choose Classroom') ?></h1>

<?php foreach($classrooms as $calendar_id => $classroom_name): ?>
    <p>
        <?= $this->Html->link($classroom_name,
            [
                'action' => 'enter_exit_operation',
                $calendar_id, $classroom_name
            ],
            [
                'class' => 'w-15 btn btn-lg btn-primary',
                'role' => 'button'
            ])
        ?>
    </p>
<?php endforeach?>