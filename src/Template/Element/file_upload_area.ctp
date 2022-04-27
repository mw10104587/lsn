<?= $this->Form->create(NULL, [
    'enctype' => 'multipart/form-data'
]); ?>

<div id='drop_file_zone' ondrop='dragUploadFile(event)' ondragover='return false'>
    <div id='drag_upload_file'>
        <p><?= env('DEBUG', false) ? 'Drop file here' : 'ここにファイルをドロップ' ?></p>
        <p><?= env('DEBUG', false) ? 'or' : 'また' ?></p>
        <div class="d-sm-flex justify-content-around">
            <input  type='button'
                    class="form-control btn btn-secondary btn-sm"
                    value="<?= env('DEBUG', false) ? 'Select File' : 'ファイルを選択' ?>"
                    onclick='fileExplorer();'
            >
        </div>
        <div id='file-data'></div>
        <input type='file' id='select-file'>
        <p id='filename'></p>
    </div>
</div>

<?= $this->Form->button(
    env('DEBUG', false) ? 'Upload' : 'アップロード',
    [
        'id' => 'upload',
        'class' => 'w-15 btn btn-lg btn-primary'
    ])
?>
<?= $this->Form->end(); ?>
