<h1>Register</h1>
<?= $this->Form->create($user) ?>
<?= $this->Form->control(
    'username',
    [
        'id' => 'username',
        'class' => 'form-control',
        'label' => [
            'for' => 'username',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<?= $this->Form->control(
    'password',
    [
        'id' => 'password',
        'class' => 'form-control',
        'label' => [
            'for' => 'password',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<?= $this->Form->control(
    'password',
    [
        'id' => 'password',
        'class' => 'form-control',
        'label' => [
            'text' => 'Check Your Password',
            'for' => 'password',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<div class="float-end">
    <?= $this->Form->button(
        'Register',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end() ?>