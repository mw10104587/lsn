<h1>Register</h1>
<?php
    echo $this->Form->create($user);
    echo $this->Form->control('username', ['label' => 'Username']);
    echo $this->Form->control('password', ['label' => 'Password']);
    echo $this->Form->control('password', ['label' => 'Enter your password again']);
    echo $this->Form->button(__('Register'));
    echo $this->Form->end();
?>