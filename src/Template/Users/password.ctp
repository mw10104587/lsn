<h1>Change Password</h1>
<?= $this->Form->create($user); ?>
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
            'text' => 'New Password',
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
    <?= $this->Form->button('Save',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end(); ?>