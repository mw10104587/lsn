<h1><?= env('DEBUG', false) ? 'Edit User' : 'ユーザー編集' ?></h1>
<?= $this->Form->create($user)?>
<?= $this->Form->control('username',
    [
        'id' => 'username',
        'class' => 'form-control',
        'label' => [
            'for' => 'username',
            'class' => 'form-label',
            'text' => 'ID'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ],
        'value' => $user->username
    ])
?>
<div class="mb-3">
    <?= $this->Form->label('identity', 'ロール',
        [ 'class' => 'form-label' ])
    ?>
    <?= $this->Form->select('identity',
            [
                'admin' => 'admin',
                'general' => 'general'
            ],
            [
                'class' => 'form-select',
                'value' => $user->identity,
            ]
        );
    ?>
</div>
<div class="float-end">
    <?= $this->Form->button(
        '保存する',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end() ?>
