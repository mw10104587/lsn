<h1>Edit User</h1>
    <?= $this->Form->create($user); ?>
    <?= $this->Form->control('username', ['value' => $user->username]); ?>
    <?= $this->Form->label('Identity'); ?>
    <?= $this->Form->select('identity',
        [
            'admin' => 'admin',
            'general' => 'general'
        ],
        ['value' => $user->identity]); ?>
    <?= $this->Form->button(__('Save')); ?>
    <?= $this->Form->end(); ?>