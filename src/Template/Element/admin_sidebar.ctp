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
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#user-collapse" aria-expanded="true">
        User Management
      </button>
      <div class="collapse show" id="user-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('User List', ['controller' => 'users', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link('User Entry', ['controller' => 'users', 'action' => 'add'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link('User Update', ['controller' => 'users', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link('User Delete', ['controller' => 'users', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#data-upload-collapse" aria-expanded="true">
        Data upload
      </button>
      <div class="collapse show" id="data-upload-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('Upload parents csv data', ['controller' => 'files', 'action' => 'parents'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link('Upload parents email csv data', ['controller' => 'files', 'action' => 'parentsEmail'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link('Upload student csv data', ['controller' => 'files', 'action' => 'student'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#setting-collapse" aria-expanded="true">
        System configration
      </button>
      <div class="collapse show" id="setting-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link('Setting', ['controller' => 'settings', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
  </ul>
</div>