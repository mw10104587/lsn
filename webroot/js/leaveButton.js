let click = 0;
function leave() {
    click += 1;

    setTimeout(() => {
        click = 0;
    }, 1000);
    let successToLeave = (click === 3) ? true : false;
    if(successToLeave){
        window.location.replace('/classrooms');
    }
}