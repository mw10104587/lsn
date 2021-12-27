<div class="text-center">
<?= $this->Flash->render(); ?>
<?= $this->Form->create(); ?>
    <div class="mb-3">
        <h1 class="h3 mb-3 fw-normal">
            <?= env('DEBUG', false) ? 'Login': 'ログイン' ?>
        </h1>
        <div class="mb-3">
            <?= $this->Form->control(
                'username',
                [
                    'id' => 'floatingInput',
                    'class' => 'form-control',
                    'for' => 'floatingInput',
                    'label' => env('DEBUG', false) ? 'User Name' : 'ユーザー名',
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
                    'label' => env('DEBUG', false) ? 'Password' : 'パスワード',
                    'templates' => [
                        'inputContainer' => '<div class="form-floating">{{content}}</div>',
                        'formGroup' => '{{input}}{{label}}'
                    ]
                ])
            ?>
        </div>
        <div class="d-flex justify-content-around">
            <?= $this->Html->link(
                env('DEBUG', false) ? 'Register' :'登録',
                ['action' => 'register'],
                [
                    'class' => 'w-15 btn btn-lg btn-secondary',
                    'role' => 'button'
                ])
            ?>
            <?= $this->Form->button(
                env('DEBUG', false) ? 'Login' : 'ログイン',
                [ 'class' => 'w-15 btn btn-lg btn-primary' ])
            ?>
        </div>
    </div>
<?= $this->Form->end() ?>
</div>
