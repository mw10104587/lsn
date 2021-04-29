<h1>USERS</h1>

<table>
    <tr>
        <th>User Name</th>
        <th>Created</th>
    </tr>

<?php foreach($users as $user): ?>
    <tr>
        <td>
            <?= $this->Html->link($user->user_name) ?>
        </td>
        <td>
            <?= $user->created->format(DATE_RFC850) ?>
        </td>
    </tr>
<?php endforeach; ?>

</table>