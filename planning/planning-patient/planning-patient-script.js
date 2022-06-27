function initCalendar(){
const nextYear = new Date().getFullYear() + 1;
    const myCalender = new CalendarPicker('#myCalendarWrapper', {
        // If max < min or min > max then the only available day will be today.
        min: new Date(),
        max: new Date(nextYear, 12), // NOTE: new Date(nextYear, 10) is "Nov 01 <nextYear>"
        locale: 'fr-FR', // Can be any locale or language code supported by Intl.DateTimeFormat, defaults to 'en-US'
        showShortWeekdays: false // Can be used to fit calendar onto smaller (mobile) screens, defaults to false
    });

    myCalender.onValueChange( async(currentValue) => {
        initDayList();
        selectedDay = currentValue.getFullYear() + "-0" + (currentValue.getMonth() + 1) + "-" + currentValue.getDate();
        docName = document.getElementById("list-doc").selectedOptions[0].text;

        createCookie("docName", docName);
        createCookie("day", selectedDay);
        createCookie("userId", idSession);

        const request = await fetch("./getDaySlots.php");
        const myRequest = await request.json();
        console.log(myRequest)

        for (let i = 0; i < myRequest.length; i++) {
            const rdvDayContent = document.getElementById(myRequest[i].heureDebut.toString().split(':')[0])
            allRdvList = document.getElementById("rdvDay").children;
            for (k in allRdvList) {
                if(k >= 9 || k <= 19) {
                    const rdvDayContent = document.getElementById(allRdvList[k].id);
                    if(myRequest[i].heureDebut.toString().split(':')[0] == rdvDayContent.id){
                        rdvDayContent.onclick = "";
                        rdvDayContent.style.cursor = 'not-allowed';
                        rdvDayContent.style.backgroundColor = 'white';
                    }
                }
            };
            //console.log(rdvDayContent)
        }
    });
}


async function initAllDoctor(){
    const request = await fetch("./getAllDocName.php");
    const cars = await request.json();
    console.log(cars)

    const currentDateElement = document.getElementById('list-doc');

    const docRefRequest = await fetch("./getDocRef.php");
    const docRef = await docRefRequest.json();

    let optionInit = document.createElement('option');
    optionInit.value = 0;
    optionInit.innerHTML = docRef.name;
    currentDateElement.appendChild(optionInit)
    
    for (let i = 0; i < cars.length; i++) {
        if (cars[i].name != optionInit.innerHTML) {
            let opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = cars.name[i];
            currentDateElement.appendChild(opt)
        }
    }
}

function initDayList() {
    allRdvList = document.getElementById("rdvDay").children;
    for (k in allRdvList) {
        if(k >= 9 || k <= 19) {
            const rdvDayContent = document.getElementById(allRdvList[k].id);
            rdvDayContent.innerHTML = `
            ${rdvDayContent.id + ":00" +"-"+ rdvDayContent.id + ":45"}`;
            //rdvDayContent.onclick = "test(event)";
            rdvDayContent.style.cursor = 'pointer';
            rdvDayContent.style.backgroundColor = '#D1F7FF';
        }
    };
}

function test(event){
    validation = confirm("Voulez vous prendre un rendez pour cet horaire ?")
    if (validation == true){
        //console.log("Rendez vous pris.")
        daySelected = getCookie("day");
        console.log("userId= " + idSession + " " + daySelected + " " + event.target.id + ":00:00")
    }else{
        console.log("Rendez vous non pris.")
    }
}

function createCookie(name, value) {
    document.cookie = name + "=" + value + "; path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

idSession = 3;
initAllDoctor();
initCalendar();
