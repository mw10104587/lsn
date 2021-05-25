<style>
#drop_file_zone {
    background-color: #EEE;
    border: #999 5px dashed;
    width: 100%;
    height: 200px;
    padding: 8px;
    font-size: 18px;
}
#drag_upload_file {
    width:50%;
    margin:0 auto;
}
#drag_upload_file p {
    text-align: center;
}
#drag_upload_file #selectfile {
  display: none;
}
</style>


<h1><?= __('データアップロード') ?></h1>
<h3><?= __('保護者データ') ?></h3>

<?= $this->element('file_upload_area'); ?>

<?= $this->Html->script('https://code.jquery.com/jquery-3.3.1.js'); ?>
<script>
    let csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    
    $('form').on('submit', (e) => {
        e.preventDefault();
        let file_obj = $('#filedata').data('fileobj');
        if(file_obj != undefined) {
            let form_data = new FormData(); 
            form_data.append('file', file_obj);
            $.ajax({
                method: 'POST',
                url: './ajax/parents',
                contentType: false,
                processData: false,
                headers: { 
                    'X-CSRF-Token': csrfToken
                },
                data: form_data,
                success: (response) => {
                    alert(response);
                    $('#selectfile').val('');
                    location.href = window.location.href;
                },
            });
        }
    })
</script>
<?= $this->Html->script('fileUpload');