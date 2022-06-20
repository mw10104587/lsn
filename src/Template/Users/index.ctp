<h1><?= env('DEBUG') ? 'User List' : 'ユーザー管理' ?></h1>
<h3><?= env('DEBUG') ? '一覽' : '一覽' ?></h3>
<?= $this->Html->script('realtimeClock'); ?>
<?= $this->Html->link(
        env('DEBUG') ? 'Add User' : 'ユーザー追加',
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
                'ロール',
                '管理',
                '作成日時',
                '更新日時'
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
                env('DEBUG', false) ? 'Delete' : '削除',
                ['action' => 'delete', $user->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
        <td class="created-time">
            <?= $user->created->toUnixString() ?>000
        </td>
        <td class="updated-time">
            <?= $user->modified->toUnixString() ?>000
        </td>
    </tr>
<?php endforeach; ?>

</table>

<script>
    $(document).ready(()=>{
        $(".created-time").html((_, v) => {
            const d = new Date(parseInt(v.trim()));
            // console.log('d', d);
            return getJapeneseFormatDate(d);
        });

        $(".updated-time").html((_, v) => {
            const d = new Date(parseInt(v.trim()));
            // console.log('d', d);
            return getJapeneseFormatDate(d);
        });

    });
 </script>
