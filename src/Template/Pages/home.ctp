<?php
use Cake\Datasource\ConnectionManager;

    $connection = ConnectionManager::get('default');
    $query = $connection->query('SHOW TABLES from `lsn`');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>

<?php foreach ($query as $row): ?>
    <li>
        <?= $this->Html->link($row[0], ['controller' => $row[0]]) ?>
    </li>
<?php endforeach; ?>

</html>
