let fileobj;
function upload_file(e) {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    $('#filename').text('Uploaded File: ' + fileobj.name);
    $('#filedata').data('fileobj', fileobj);
}

function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = () => {
        fileobj = document.getElementById('selectfile').files[0];
        $('#filename').text('Uploaded File: ' + fileobj.name);
        $('#filedata').data('fileobj', fileobj);
    };
}