<h1><?= __('システム設定') ?></h1>
<h3><?= __('設定') ?></h3>

<?= $this->Form->create(); ?>
<?= $this->Form->label('Google', null,
    [ 'class' => 'form-label' ])
?>
<br>
<?= $this->Form->label('account', 'アカウント',
    [ 'class' => 'form-label' ])
?>
<?= $this->Form->control('user',
    [
        'id' => 'user',
        'class' => 'form-control',
        'label' => [
            'text' => 'ユーザー',
            'for' => 'user',
            'class' => 'col-sm-2 col-form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3 row">{{content}}</div>',
            'formGroup' => '{{label}}<div class="col-sm-10">{{input}}</div>'
        ]
    ])

?>
<?= $this->Form->control('password',
    [
        'id' => 'password',
        'class' => 'form-control',
        'label' => [
            'text' => 'パスワード',
            'for' => 'password',
            'class' => 'col-sm-2 col-form-label'
        ],
        'templates' => [
            'inputContainer' => '<div class="mb-3 row">{{content}}</div>',
            'formGroup' => '{{label}}<div class="col-sm-10">{{input}}</div>'
        ]
    ])
?>
<div class="mb-3 row">
    <?= $this->Form->label('calander_url', '対象カレンダー',
        [ 'class' => 'col-sm-2 col-form-label' ])
    ?>
    <div class="col-sm-10">
        <?= $this->Form->textarea('calander_url',
            [
                'label' => 'calander_url',
                'class' => 'form-control',
                'rows' => 4,
            ])
        ?>
    </div>
</div>

<div class="mb-3 row">
	<?= $this->Form->label('memo', '対象カレンダーメモ',
        [ 'class' => 'col-sm-2 col-form-label' ])
    ?>
    <div class="col-sm-10">
        <?= $this->Form->textarea('memo',
            [
                'label' => 'memo',
                'class' => 'form-control',
                'rows' => 3
            ])
        ?>
    </div>
</div>

<div class="float-end">
    <?= $this->Form->button(
        '保存',
        [
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end(); ?>