<h1><?= __('システム設定') ?></h1>
<h3><?= __('設定') ?></h3>

<?= $this->Form->create(); ?>
<?= $this->Form->label('Google', null,
    [ 'class' => 'form-label' ])
?>
<div class="mb-3 row">
    <?= $this->Form->label('calendar_id', '対象カレンダー',
        [ 'class' => 'col-sm-2 col-form-label' ])
    ?>
    <div class="col-sm-10">
        <?= $this->Form->textarea('calendar_id',
            [
                'label' => 'calendar_id',
                'class' => 'form-control',
                'rows' => 4,
                'value' => $calendar_ids_string,
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
                'rows' => 4,
                'value' => $memos_string,
            ])
        ?>
    </div>
</div>

<div class="float-end">
    <?= $this->Form->button(
        '保存',
        [
            /* 'type' => 'submit', */ // This is default
            'class' => 'w-15 btn btn-lg btn-primary'
        ])
    ?>
</div>
<?= $this->Form->end(); ?>
