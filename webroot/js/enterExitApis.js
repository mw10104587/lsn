function changeStatus(csrfToken, studentId, classEventId, classroomName, newStatus) {
    console.log('changeStatus');
    const _classEventId = classEventId == null ? 'TEST_CALENDAR_EVENT_ID': classEventId;
    $.ajax({
        contentType: "application/json; charset=utf-8",
        method: 'POST',
        url: '/apis/enterExit/' + studentId,
        "headers": {
            "Content-Type": "application/x-www-form-urlencoded",
            'X-CSRF-Token': csrfToken
        },
        "data": {
            "class_event_id": _classEventId,
            "classroom_name": classroomName,
            "new_status": newStatus,
        },
        crossDomain: true,
        xhrFields: {withCredentials: true},
        dataType: 'json',
        success: (res) => {
            console.log('res');
            if(res !== 'Failure') {
                res = JSON.parse(res);
                $('#status').text(res.studentName + ' status: ' + res.status);
            }
        },
    }).done((res) => {
        console.log('res', res);
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

// function debounce(func, delay = 2000) {
// 	let timer = null;
//     return (...args) => {
//         clearTimeout(timer);
//         timer = setTimeout(() => { func.apply(this, args); }, delay);
//     };
// }
