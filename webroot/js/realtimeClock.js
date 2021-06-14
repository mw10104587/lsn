function showTime(){
    var d = new Date(new Date().toLocaleString("en-US", {timeZone: 'Asia/Tokyo'}));
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var date = d.getDate();
    var day = d.getDay();
    var hour = d.getHours();
    var min = d.getMinutes();
    var sec = d.getSeconds();

    switch(day){
        case 1:
            day='月';
            break;
        case 2:
            day='火';
            break;
        case 3:
            day='水';
            break;
        case 4:
            day='木';
            break;
        case 5:
            day='金';
            break;
        case 6:
            day='土';
            break;
        case 7:
            day='日';
            break;
        default:   
    }

    var MV = 'AM';
    if(hour == 12){
        MV = 'PM';
    }
    if(hour > 12){
        hour = hour % 12;
        MV = 'PM';
    }

    hour = ('0' + hour).slice(-2);
    min = ('0' + min).slice(-2);
    sec = ('0' + sec).slice(-2);

    document.getElementById('clock').innerHTML =
        year + '年' + month + '月' + date + '日(' + day + ') ' +
        hour + ':' + min + ':' + sec + MV;
}

showTime();
setInterval(showTime, 1000);