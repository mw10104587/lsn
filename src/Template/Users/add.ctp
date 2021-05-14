<h1>Add User</h1>
<?php
    echo $this->Form->create($user);
    // Hard code the user for now.
    echo $this->Form->control('username', ['label' => 'Username']);
    echo $this->Form->control('password', ['label' => 'Password']);
    echo $this->Form->control('password', ['label' => 'Enter your password again']);
    echo $this->Form->label('identity');
    echo $this->Form->select('identity',
        ['admin' => 'admin', 'general' => 'general']);
    echo $this->Form->button(__('Save User'));
    echo $this->Form->end();
?>