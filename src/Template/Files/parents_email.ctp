<h1><?= __('データアップロード') ?></h1>
<h3><?= __('eメールデータ') ?></h3>

<?= $this->element('file_upload_area'); ?>

<?= $this->Html->script('https://code.jquery.com/jquery-3.3.1.js'); ?>
<?= $this->element('file_upload_ajax', [
    'slug' => 'parents_email'
]); ?>
<?= $this->Html->script('fileUpload'); ?>