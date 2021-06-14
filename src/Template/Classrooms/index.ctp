<h2><?= __('Classroom') ?></h2>

<?php foreach($classrooms as $calendar_id => $classroom_name): ?>
    <li>
        <?= $this->Html->link($classroom_name, ['action' => 'enter_exit_operation', $calendar_id, $classroom_name]); ?>
    </li>
<?php endforeach?>