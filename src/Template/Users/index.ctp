<h1>Users</h1>
<p><?= $this->Html->link("Add User", ['action' => 'add']) ?></p>
<table>
    <?= $this->Html->tableHeaders([
        'Username',
        'Identity',
        'Action',
        'Created',
        'Updated']);
    ?>

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