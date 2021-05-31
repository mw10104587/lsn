<?= $this->Form->create(NULL, [
    'enctype' => 'multipart/form-data'
]); ?>


<div id='drop_file_zone' ondrop='dargUploadFile(event)' ondragover='return false'>
    <div id='drag_upload_file'>
        <p>Drop file here</p>
        <p>or</p>
        <p><input type='button' id='test' value='Select File' onclick='fileExplorer();'></p>
        <div id='file-data'></div>
        <input type='file' id='select-file'>
        <p id='filename'></p>
    </div>
</div>

<?= $this->Form->button('Upload', ['id' => 'upload',]); ?>
<?= $this->Form->end(); ?>