<?= $this->Form->create(NULL, [
    'enctype' => 'multipart/form-data'
]); ?>


<div id='drop_file_zone' ondrop='dargUploadFile(event)' ondragover='return false'>
    <div id='drag_upload_file'>
        <p>Drop file here</p>
        <p>or</p>
        <div class="d-flex justify-content-around">
            <input type='button' class="form-control" style="width: 100px" value='Select File' onclick='fileExplorer();'>    
        </div>
        <div id='file-data'></div>
        <input type='file' id='select-file'>
        <p id='filename'></p>
    </div>
</div>

<?= $this->Form->button('Upload',
    [
        'id' => 'upload',
        'class' => 'w-15 btn btn-lg btn-primary'
    ])
?>
<?= $this->Form->end(); ?>