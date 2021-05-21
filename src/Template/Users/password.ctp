<h1>Change Password</h1>
<?= $this->Form->create($user); ?>
<?= $this->Form->control(
    'username',
    [
        'value' => $user->username,
        'readonly' => 'readonly'
    ]); ?>
<?= $this->Form->control(
    'password',
    [
        'label' => 'New Password',
        'value' => ''
    ]); ?>
<?= $this->Form->button(__('Save')); ?>
<?= $this->Form->end(); ?>