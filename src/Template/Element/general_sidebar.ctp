<div class="flex-shrink-0 p-3 bg-white" style="width: 280px;">
  <ul class="list-unstyled ps-0">
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#classroom-collapse" aria-expanded="true">
        <?= env('DEBUG', false) ? 'Classroom': 'クラスルーム' ?>
      </button>
      <div class="collapse show" id="classroom-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Choose Classroom': 'エリア選択',
            ['controller' => 'classrooms', 'action' => 'index'], ['class' => 'link-dark rounded']); ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#enter-exit-collapse" aria-expanded="true">
      <?= env('DEBUG', false) ? 'Enter / Exit Management': '入退室管理' ?>
      </button>
      <div class="collapse show" id="enter-exit-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'List of entry / exit history': '履歴一覧',
            ['controller' => 'enter_exit_logs', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#student-collapse" aria-expanded="true">
        <?= env('DEBUG', false) ? 'Student management': '受講生管理' ?>
      </button>
      <div class="collapse show" id="student-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'List of Student': '一覧',
            ['controller' => 'students', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#security-collapse" aria-expanded="true">
      <?= env('DEBUG', false) ? 'Security': '安全' ?>
      </button>
      <div class="collapse show" id="security-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Password Change' : 'パスワードの変更',
            ['controller' => 'users', 'action' => 'password'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
  </ul>
</div>
