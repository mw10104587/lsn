<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->button(__('Login')); ?>
        <?= $this->Html->link('register', ['action' => 'register']); ?>
    </fieldset>
<?= $this->Form->end() ?>
</div>