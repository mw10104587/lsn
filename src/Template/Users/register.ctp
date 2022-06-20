<h1><?= env('DEBUG', false) ? 'Register': '登録' ?></h1>
<?= $this->Form->create($user) ?>
<?php
    if ($this->Form->isFieldError('password')): 
        echo $this->Form->error('password', 'Complete the password!');
    endif
?>
<?= $this->Form->control(
    'username',
    [
        'id' => 'username',
        'class' => 'form-control',
        'label' => [
            'text' => env('DEBUG', false) ? 'Username' : 'ユーザー名(ID)',
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
            'text' => env('DEBUG', false) ? 'Password' : 'パスワード',
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
        'id' => 'password-confirm',
        'class' => 'form-control',
        'label' => [
            'text' => env('DEBUG', false) ? 'Confirm Password': 'パスワードを認証する',
            'for' => 'password',
            'class' => 'form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3">{{content}}</div>',
        ]
    ])
?>
<div class="float-end">
    <button id="cancel" class="btn btn-lg btn-secondary" type="button"><?= env('DEBUG', false) ? 'Cancel' : 'キャンセル' ?></button>
    <?= $this->Form->button(
        env('DEBUG', false) ? 'Register': '登録',
        [
            'id' => 'submit-btn',
            'class' => 'w-15 btn btn-lg btn-primary',
            'type' => 'submit',
            'disabled' => true, // disable at the beginning
        ])
    ?>
</div>
<?= $this->Form->end() ?>

<script>
    function shouldEnableSubmitButton() {
        if( $('#password').val() == null ||  $('#password').val() === '' ) {
            $('#submit-btn').prop('disabled', true);
            return;
        }

        if( $('#password-confirm').val() == null ||  $('#password-confirm').val() === '' ){
            $('#submit-btn').prop('disabled', true);
            return;
        }

        if( $('#username').val() == null ||  $('#username').val() === '' ){
            $('#submit-btn').prop('disabled', true);
            return;
        }

        if( $('#password').val() !== $('#password-confirm').val()) {
            $('#submit-btn').prop('disabled', true);
            return;
        }

        $('#submit-btn').prop('disabled', false);
    }
            
    $(document).ready(() => {
        $('#username').change(shouldEnableSubmitButton);
        $('#password').change(shouldEnableSubmitButton);
        $('#password-confirm').change(shouldEnableSubmitButton);

        $('#cancel').click(() => {
            window.location.href = '/';
        });
    });
</script>