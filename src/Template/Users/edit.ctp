<h1>Edit User</h1>
<?= $this->Form->create($user)?>
<?= $this->Form->control('username',
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
        'value' => $user->username
    ])
?>
<div class="mb-3">
    <?= $this->Form->label('identity', null,
        [ 'class' => 'form-label' ])
    ?>
    <?= $this->Form->select('identity',
        [
            'admin' => 'admin',
            'general' => 'general'
        ],
        [
            'class' => 'form-select',
            'value' => $user->identity
        ])
    ?>
</div>
<div class="float-end">
    <?= $this->Form->button(
        'Save',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end() ?>
