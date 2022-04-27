let fileObj;

function dragUploadFile(e) {
    e.preventDefault();
    fileObj = e.dataTransfer.files[0];
    $('#filename').text('Selected File: ' + fileObj.name);
    $('#file-data').data('fileobj', fileObj);
}

function fileExplorer() {
    document.getElementById('select-file').click();
    document.getElementById('select-file').onchange = () => {
        fileObj = document.getElementById('select-file').files[0];
        $('#filename').text('Selected File: ' + fileObj.name);
        $('#file-data').data('fileobj', fileObj);
    };
}