<div class="text-center">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <div class="mb-3">
        <h1 class="h3 mb-3 fw-normal">Login</h1>
        <div class="mb-3">
            <?= $this->Form->control(
                'username',
                [
                    'id' => 'floatingInput',
                    'class' => 'form-control',
                    'for' => 'floatingInput',
                    'placeholder' => 'Username',
                    'templates' => [
                        'inputContainer' => '<div class="form-floating">{{content}}</div>',
                        'formGroup' => '{{input}}{{label}}'
                    ]
                ])
            ?>
            <?= $this->Form->control(
                'password',
                [
                    'id' => 'floatingPassword',
                    'class' => 'form-control',
                    'for' => 'floatingPassword',
                    'placeholder' => 'Password',
                    'templates' => [
                        'inputContainer' => '<div class="form-floating">{{content}}</div>',
                        'formGroup' => '{{input}}{{label}}'
                    ]
                ])
            ?>
        </div>
        <div class="d-flex justify-content-around">
            <?= $this->Html->link('register', 
                ['action' => 'register'],
                [
                    'class' => 'w-15 btn btn-lg btn-secondary',
                    'role' => 'button' 
                ])
            ?>
            <?= $this->Form->button(
                'Login',
                [ 'class' => 'w-15 btn btn-lg btn-primary' ])
            ?>
        </div>
    </div>
<?= $this->Form->end() ?>
</div>