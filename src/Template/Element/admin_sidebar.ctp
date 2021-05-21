<h1><?= __('LSN') ?></h1>
<div class="SideMenu">
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
    <li><?= $this->Html->link('User Management', ['controller' => 'users', 'action' => 'index']) ?>
      <ul>
        <li><?= $this->Html->link('User List', ['controller' => 'users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link('User Entry', ['controller' => 'users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link('User Update, Password Change', ['controller' => 'users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link('User Delete', ['controller' => 'users', 'action' => 'index']) ?></li>
      </ul>
    </li>
    <li>Data upload
      <ul>
        <li>Upload parents csv data</li>
        <li>Upload parents email csv data</li>
        <li>Upload student csv data</li>
      </ul>
    </li>
    <li>System configration
      <ul>
        <li>Setting</li>
      </ul>
    </li>
  </ul>
</div>