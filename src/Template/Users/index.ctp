<h1>User List</h1>
<?= $this->Html->link("Add User",
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
            [
                'Username',
                'Identity',
                'Action',
                'Created',
                'Updated'
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
            <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?>
            <?= $this->Form->postLink(
                'Delete',
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