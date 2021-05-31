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
        <li><?= $this->Html->link('List of entry / exit history', ['controller' => 'enterexitlogs', 'action' => 'index']) ?></li>
      </ul>
    </li>
    <li>Student management
      <ul>
        <li><?= $this->Html->link('List of student', ['controller' => 'students', 'action' => 'index']) ?></li>
      </ul>
    </li>
    <li>User Management
      <ul>
        <li><?= $this->Html->link('User List', ['controller' => 'users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link('User Entry', ['controller' => 'users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link('User Update, Password Change', ['controller' => 'users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link('User Delete', ['controller' => 'users', 'action' => 'index']) ?></li>
      </ul>
    </li>
    <li>Data upload
      <ul>
        <li><?= $this->Html->link('Upload parents csv data', ['controller' => 'files', 'action' => 'parents']) ?></li>
        <li><?= $this->Html->link('Upload parents email csv data', ['controller' => 'files', 'action' => 'parentsEmail']) ?></li>
        <li><?= $this->Html->link('Upload student csv data', ['controller' => 'files', 'action' => 'student']) ?></li>
      </ul>
    </li>
    <li>System configration
      <ul>
        <li><?= $this->Html->link('Setting', ['controller' => 'settings', 'action' => 'index']) ?></li>
      </ul>
    </li>
  </ul>
</div>