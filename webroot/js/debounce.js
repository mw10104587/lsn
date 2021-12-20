function changeStatus(csrfToken, studentId, classEventId) {

    const _classEventId = classEventId == null ? 'TEST_CALENDAR_EVENT_ID': classEventId;
    $.ajax({
        method: 'POST',
        url: '/apis/enterExit/' + studentId,
        "headers": {
            "Content-Type": "application/x-www-form-urlencoded",
            'X-CSRF-Token': csrfToken
        },
        "data": {
            "class_event_id": _classEventId
        },
        success: (res) => {
            if(res !== 'Failure') {
                res = JSON.parse(res);
                $('#status').text(res.studentName + ' status: ' + res.status);
            }
        },
    });
}

function lineNotify(csrfToken, studentId, classEventId) {

    const _classEventId = classEventId == null ? 'TEST_CALENDAR_EVENT_ID': classEventId;
    const settings = {
        "url": "/apis/lineNotify/" + studentId,
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/x-www-form-urlencoded",
            'X-CSRF-Token': csrfToken
        },
        "data": {
            "class_event_id": _classEventId
        }
    };

    $.ajax(settings).done(function (response) {
        // console.log(response);
    });

}

function debounce(func, delay = 2000) {
	let timer = null;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, delay);
    };
}
