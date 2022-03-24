function getJapeneseFormatDate(d) {
    const year = d.getFullYear();
    var month = d.getMonth() + 1;
    var date = d.getDate();
    var day = d.getDay();
    var hour = d.getHours();
    var min = d.getMinutes();
    var sec = d.getSeconds();

    switch (day) {
        case 1:
            day = '月';
            break;
        case 2:
            day = '火';
            break;
        case 3:
            day = '水';
            break;
        case 4:
            day = '木';
            break;
        case 5:
            day = '金';
            break;
        case 6:
            day = '土';
            break;
        case 7:
        case 0:
            day = '日';
            break;
        default:
    }

    if (hour > 12) {
        hour = hour % 12;
        MV = 'PM';
    }

    hour = ('0' + hour).slice(-2);
    min = ('0' + min).slice(-2);
    sec = ('0' + sec).slice(-2);

    return `${year}年${month}月${date}日(${day}) ${hour}時${min}分${sec}秒`;
}


function showTime() {
    var d = new Date(new Date().toLocaleString("en-US", { timeZone: 'Asia/Tokyo' }));
    const japaneseTime = getJapeneseFormatDate(d);
    document.getElementById('clock').innerHTML = japaneseTime;
}

$(document).ready(() => {
    if (document.getElementById('clock')) {
        setInterval(showTime, 1000);
    }
})



