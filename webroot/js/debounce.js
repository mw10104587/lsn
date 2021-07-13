function changeStatus(csrfToken, studentId) {
    $.ajax({
        method: 'POST',
        url: '/apis/enterExit/' + studentId,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-Token': csrfToken
        },
        success: (res) => {
            if(res !== 'Failure') {
                res = JSON.parse(res);
                $('#status').text(res.studentName + ' status: ' + res.status);
            }
        }, 
    })
}

function insertLogs(csrfToken, studentId) {
    $.ajax({
        method: 'POST',
        url: '/apis/lineNotify/' + studentId,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-Token': csrfToken
        },
        success: (res) => {
            console.log(res);
        },
    });
}

function debounce(func, delay = 2000) {
	let timer = null;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, delay);
    };
}