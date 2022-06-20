<h1><?= env('DEBUG', false) ? 'Classroom': 'クラスルーム' ?></h1>
<h3><?= env('DEBUG', false) ? 'Choose Classroom': 'カレンダー選択' ?></h3>
<?php foreach($classrooms as $calendar_id => $calendar_tuple /* [calendar_id, calendar_description]*/): ?>
    <p>
        <?= $this->Html->link($calendar_tuple[1],
            [
                'action' => 'pick_class',
                $calendar_tuple[0], $calendar_tuple[1]
            ],
            [
                'class' => 'w-15 btn btn-lg btn-primary',
                'role' => 'button'
            ])
        ?>
    </p>
<?php endforeach?>
