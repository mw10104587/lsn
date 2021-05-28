<h1><?= __('システム設定') ?></h1>
<h3><?= __('設定') ?></h3>

<?= $this->Form->create(); ?>
<?= $this->Form->label('Google'); ?>
<?= $this->Form->label('account', 'アカウント'); ?>
<?= $this->Form->control('user', ['label' => 'ユーザー']); ?>
<?= $this->Form->control('password', ['label' => 'パスワード']); ?>
<?= $this->Form->label('calander_url', '対象カレンダー'); ?>
<?= $this->Form->textarea('calander_url', ['label' => 'calander_url']); ?>
<?= $this->Form->label('memo', '対象カレンダーメモ'); ?>
<?= $this->Form->textarea('memo', ['label' => 'memo']); ?>

<?= $this->Form->button('保存'); ?>
<?= $this->Form->end(); ?>