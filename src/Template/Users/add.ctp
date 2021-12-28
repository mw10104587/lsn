<h1><?= env('DEBUG', false) ? 'Add User': 'ユーザーを追加する' ?></h1>
<?= $this->Form->create($user)?>
<?= $this->Form->control('username',
    [
        'id' => 'username',
        'class' => 'form-control',
        'label' => [
            'for' => 'username',
            'class' => 'form-label',
            'text' => env('DEBUG', false) ?  'User Name': 'ユーザー名'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<?= $this->Form->control('password',
    [
        'id' => 'password',
        'class' => 'form-control',
        'label' => [
            'for' => 'password',
            'class' => 'form-label',
            'text' => env('DEBUG', false) ?  'Password': 'パスワード'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<?= $this->Form->control('password',
    [
        'id' => 'password',
        'class' => 'form-control',
        'label' => [
            'text' => env('DEBUG', false) ?  'Check Password Again': 'パスワードをもう一度確認してください',
            'for' => 'password',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<div class="mb-3">
    <?= $this->Form->label(
        'identity',
        env('DEBUG', false) ?  'Identity/Role': 'アイデンティティ/役割',
        [ 'class' => 'form-label' ])
    ?>
    <?= $this->Form->select('identity',
        [
            'admin' => 'admin',
            'general' => 'general'
        ],
        [ 'class' => 'form-select' ])
    ?>
</div>
<div class="float-end">
    <?= $this->Form->button(
        env('DEBUG', false) ?  'Save': '保存する',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end() ?>
