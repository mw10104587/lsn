<h2><?= __('Classroom') ?></h2>

<?php foreach($classrooms as $classroom): ?>
    <li>
        <?= $this->Html->link($classroom->classroom_name, ['action' => 'enter_exit_operation', $classroom->classroom_name]); ?>
    </li>

<?php endforeach?>