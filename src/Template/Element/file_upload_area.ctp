<?= $this->Form->create(NULL, [
    'enctype' => 'multipart/form-data'
]); ?>


<div id='drop_file_zone' ondrop='upload_file(event)' ondragover='return false'>
    <div id='drag_upload_file'>
        <p>Drop file here</p>
        <p>or</p>
        <p><input type='button' id='test' value='Select File' onclick='file_explorer();'></p>
        <div id='filedata'></div>
        <input type='file' id='selectfile'>
        <p id='filename'></p>
    </div>
</div>

<?= $this->Form->button('Upload', ['id' => 'upload',]); ?>
<?= $this->Form->end(); ?>