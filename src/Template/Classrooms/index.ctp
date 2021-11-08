<h1><?= __('Choose Classroom') ?></h1>
<?php foreach($classrooms as $calendar_id => $calendar_tuple /* [calendar_id, calendar_description]*/): ?>
    <p>
        <?= $this->Html->link($calendar_tuple[1],
            [
                'action' => 'enter_exit_operation',
                $calendar_tuple[0], $calendar_tuple[1]
            ],
            [
                'class' => 'w-15 btn btn-lg btn-primary',
                'role' => 'button'
            ])
        ?>
    </p>
<?php endforeach?>
