<div class='sidebar'>
  <h1><?= __('LSN') ?></h1>
  <ul>
    <li>Classroom
      <ul>
        <li><?= $this->Html->link('Choose Classroom', ['controller' => 'classrooms', 'action' => 'index']); ?></li>
        <li>Enter / exit operation</li>
      </ul>
    </li>
    <li>Enter / exit management
      <ul>
        <li><?= $this->Html->link('List of entry / exit history', ['controller' => 'enter_exit_logs', 'action' => 'index']) ?></li>
      </ul>
    </li>
    <li>Student management
      <ul>
        <li><?= $this->Html->link('List of student', ['controller' => 'students', 'action' => 'index']) ?></li>
      </ul>
    </li>
    <li>Security
      <ul>
        <li><?= $this->Html->link('Password Change', ['controller' => 'users', 'action' => 'password']) ?></li>
      </ul>
    </li>
  </ul>
</div>