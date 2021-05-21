<h1><?= __('LSN') ?></h1>
<div class="SideMenu">
  <ul>
    <li>Classroom
      <ul>
        <li>Choose Classroom</li>
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
  </ul>
</div>