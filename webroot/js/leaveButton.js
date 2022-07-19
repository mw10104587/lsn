let click = 0;
function leave() {
    click += 1;

    setTimeout(() => {
        click = 0;
    }, 1500);
    let successToLeave = (click === 3) ? true : false;
    if(successToLeave){
        click = 0;
        window.history.back();
    }
}
