<div class="flex-shrink-0 p-3 bg-white" style="width: 280px;">
  <ul class="list-unstyled ps-0">
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#classroom-collapse" aria-expanded="true">
        <?= env('DEBUG', false) ? 'Classroom': 'クラスルーム' ?>
      </button>
      <div class="collapse show" id="classroom-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Choose Classroom': 'カレンダー選択',
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
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#user-collapse" aria-expanded="true">
        <?= env('DEBUG', false) ? 'User Management': 'ユーザー管理' ?>
      </button>
      <div class="collapse show" id="user-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'User List' : '一覧',
            ['controller' => 'users', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'User Entry' : '登録',
            ['controller' => 'users', 'action' => 'add'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'User Update' : '編集',
            ['controller' => 'users', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'User Delete' : '削除',
            ['controller' => 'users', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#data-upload-collapse" aria-expanded="true">
        <?= env('DEBUG', false) ? 'Data upload': 'データアップロード' ?>
      </button>
      <div class="collapse show" id="data-upload-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Upload parents csv data': '保護者データ',
            ['controller' => 'files', 'action' => 'parents'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Upload parents email csv data' : 'emailデータ',
            ['controller' => 'files', 'action' => 'parentsEmail'], ['class' => 'link-dark rounded']) ?></li>
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Upload student csv data' : '受講生データ',
            ['controller' => 'files', 'action' => 'student'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#setting-collapse" aria-expanded="true">
        <?= env('DEBUG', false) ? 'System configration' : 'システム設定' ?>
      </button>
      <div class="collapse show" id="setting-collapse">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <li><?= $this->Html->link(
            env('DEBUG', false) ? 'Setting' : '設定',
            ['controller' => 'settings', 'action' => 'index'], ['class' => 'link-dark rounded']) ?></li>
        </ul>
      </div>
    </li>
  </ul>
</div>
