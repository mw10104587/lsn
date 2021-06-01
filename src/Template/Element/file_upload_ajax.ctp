<script>
    let csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    let ajaxUrl = './ajax/' + '<?= __($slug) ?>';
    
    $('form').on('submit', (e) => {
        e.preventDefault();
        const fileObj = $('#file-data').data('fileobj');
        if(fileObj != undefined) {
            let formData = new FormData(); 
            formData.append('file', fileObj);
            $.ajax({
                method: 'POST',
                url: ajaxUrl,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: formData,
                success: (response) => {
                    $('#select-file').val('');
                    location.href = window.location.href;
                },
            });
        }
    })
</script>