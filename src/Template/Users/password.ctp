<h1><?= env('DEBUG', false) ? 'Change Password': 'パスワード変更' ?></h1>
<?= $this->Form->create($user); ?>
<?= $this->Form->control(
    'username',
    [
        'id' => 'username',
        'class' => 'form-control',
        'label' => [
            'text' => env('DEBUG') ? 'User Name': 'ユーザー名(ID)',
            'for' => 'username',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ],
        'value' => $user->username,
        'readonly' => 'readonly',
    ])
?>
<?= $this->Form->control(
    'password',
    [
        'id' => 'password',
        'class' => 'form-control',
        'label' => [
            'text' => env('DEBUG') ? 'Password': 'パスワード',
            'for' => 'password',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ],
        'value' => ''
    ])
?>
<div class="float-end">
    <?= $this->Form->button(
        env('DEBUG', false) ? 'Save' : '保存する',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end(); ?>
