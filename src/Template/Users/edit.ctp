<h1>Edit User</h1>
<?php
    echo $this->Form->create($user);
    echo $this->Form->control('id', ['type' => 'hidden']);
    echo $this->Form->control('username', ['value' => $user->username]);
    echo $this->Form->label('Identity');
    echo $this->Form->select('identity',
        [
            'admin' => 'admin',
            'general' => 'general'
        ],
        ['value' => $user->identity]);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>