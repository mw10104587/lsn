<h1><?= env('DEBUG') ? 'User List' : 'ユーザーリスト' ?></h1>
<?= $this->Html->link(
        env('DEBUG') ? 'Add User' : 'ユーザーを追加する',
        [ 'action' => 'add' ],
        [
            'class' => 'w-15 btn btn-primary',
            'role' => 'button'
        ]
    )
?>
<table class="table table-striped table-hover" style='vertical-align: middle;'>
    <thead>
        <?= $this->Html->tableHeaders(
            env('DEBUG') ? [
                'Username',
                'Identity',
                'Action',
                'Created',
                'Updated'
            ]: [
                'ユーザー名',
                '身元',
                'アクション',
                '作成した',
                '更新しました'
            ]
        );
        ?>
    </thead>

<?php foreach($users as $user): ?>
    <tr>
        <td>
            <?= $this->Html->link($user->username, ['action' => 'view', $user->username]) ?>
        </td>
        <td>
            <?= $user->identity ?>
        </td>
        <td>
            <?= $this->Html->link(
                env('DEBUG', false) ? 'Edit' : '編集',
                ['action' => 'edit', $user->id]) ?>
            <?= $this->Form->postLink(
                env('DEBUG', false) ? 'Delete' : 'デリート',
                ['action' => 'delete', $user->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
        <td>
            <?= $user->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $user->modified->format(DATE_RFC850) ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>
