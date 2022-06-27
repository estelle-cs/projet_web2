function initCalendar(){
const nextYear = new Date().getFullYear() + 1;
const previousYear = new Date().getFullYear() -1;
    const myCalender = new CalendarPicker('#myCalendarWrapper', {
        // If max < min or min > max then the only available day will be today.
        min: new Date(previousYear, 0),
        max: new Date(nextYear, 12), // NOTE: new Date(nextYear, 10) is "Nov 01 <nextYear>"
        locale: 'fr-FR', // Can be any locale or language code supported by Intl.DateTimeFormat, defaults to 'en-US'
        showShortWeekdays: false // Can be used to fit calendar onto smaller (mobile) screens, defaults to false
    });

    myCalender.onValueChange(async(currentValue) => {
        initDayList();
        selectedDay = currentValue.getFullYear() + "-0" + (currentValue.getMonth() + 1) + "-" + currentValue.getDate();
        //console.log(selectedDay);
        createCookie("day", selectedDay); //.toString().split(' ')[2] for only nbrDay
        const request = await fetch("./getDayRdv.php");
        //console.log(request);
        const myRequest = await request.json();
        for (let i = 0; i < myRequest.length; i++) {
            patientId = myRequest[i].patientId
            createCookie("patientId", patientId);

            const request2 = await fetch("./getPatient.php"); //need patientId from cookies
            const myRequest2 = await request2.json();
            
            //console.log(myRequest[i].heureDebut.toString().split(':')[0] + ":00");
            allRdvList = document.getElementById("rdvDay").children;
            for (k in allRdvList) {
                if(k >= 9 || k <= 19) {
                    const rdvDayContent = document.getElementById(allRdvList[k].id);
                    if(myRequest[i].heureDebut.toString().split(':')[0] == rdvDayContent.id){
                        rdvDayContent.innerHTML += `
                        <p>${myRequest2.surname + " " + myRequest2.name}</p>`;
                    }
                }
            };
        };
            //console.log(myRequest[i]);
    });
}

function initDayList() {
    allRdvList = document.getElementById("rdvDay").children;
    for (k in allRdvList) {
        if(k >= 9 || k <= 19) {
            const rdvDayContent = document.getElementById(allRdvList[k].id);
            rdvDayContent.innerHTML = `
            ${rdvDayContent.id + ":00" +"-"+ rdvDayContent.id + ":45"}`;
        }
    };
}

function createCookie(name, value) {
    document.cookie = name + "=" + value + "; path=/";
}

function test(event){
    if (event.target.children.length > 0){
        patientSurname = event.target.children[0].innerHTML.toString().split(' ')[0]
        patientName = event.target.children[0].innerHTML.toString().split(' ')[1]
        console.log(patientSurname, patientName)
    }
}

idSession = 1;
createCookie("id", idSession);
initCalendar();
