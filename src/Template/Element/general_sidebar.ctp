<div class="flex-shrink-0 p-3 bg-white" style="width: 280px;">
  <ul class="list-unstyled ps-0">
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#classroom-collapse" aria-expanded="true">
        Classroom
      </button>
      <div class="collapse show" id="classroom-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('Choose Classroom', ['controller' => 'classrooms', 'action' => 'index'], ['class' => 'link-dark rounded']); ?></li>
          <li><a href="#" class="link-dark rounded">Enter / Exit Operation</a></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#enter-exit-collapse" aria-expanded="true">
        Enter / Exit Management
      </button>
      <div class="collapse show" id="enter-exit-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('List of entry / exit history', ['controller' => 'enter_exit_logs', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#student-collapse" aria-expanded="true">
        Student management
      </button>
      <div class="collapse show" id="student-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('List of student', ['controller' => 'students', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#security-collapse" aria-expanded="true">
        Security
      </button>
      <div class="collapse show" id="security-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('Password Change', ['controller' => 'users', 'action' => 'password'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
  </ul>
</div>