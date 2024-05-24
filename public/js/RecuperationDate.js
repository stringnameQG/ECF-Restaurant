window.onload = () => {
    const INPUTDATE = document.querySelector('.input__date');
    INPUTDATE.addEventListener("change", ReservationDate);  
}

function ReservationDate(){
    const DATESELECTINPAGE = document.querySelector('.input__date');
    const DATESELECT = DATESELECTINPAGE.value;

    DateIsNull(DATESELECT);

    function DateIsNull(){
        if(DATESELECT == null){
            console.log("Aucune date renseigné");
        } else {
            DateComparisonToday();
        }
    }
    
    function DateComparisonToday(){
        const DATESELECTINMILISECOND = new Date(DATESELECT).getTime();
        const CURRENTDATE = Date.now();
        if(DATESELECTINMILISECOND < CURRENTDATE){
            console.log("date antérieur à aujourd'hui");
        } else {
            FormToGetDayInFrench(ConvertDateInFrench());
        } 
    }
    
    function ConvertDateInFrench(){
        const DAYNUMBER = new Date(DATESELECT).getDay();
        let dayInFrench;

        switch(DAYNUMBER){
            case 1:
                dayInFrench = 'Lundi';
                break;
            case 2:
                dayInFrench = 'Mardi';
                break;
            case 3:
                dayInFrench = 'Mercredi';
                break;
            case 4:
                dayInFrench = 'Jeudi';
                break;
            case 5:
                dayInFrench = 'Vendredi';
                break;
            case 6:
                dayInFrench = 'Samedi';
                break;
            case 0:
                dayInFrench = 'Dimanche';
                break;
            default:
                dayInFrench = 'error';
        };
        return dayInFrench;
    }

    function FormToGetDayInFrench(dayInFrench){
        const FORMDAY = {"dayInFrench" : dayInFrench};
        DQLRequestDayIsOpen(FORMDAY);
    }

    function DQLRequestDayIsOpen(FORMDAY){
        $.ajax({
            url: '/dayIsOpen',
            method: 'GET',
            data: FORMDAY,
            dataType: "json",
            timeout: 1500,
            success: function(data) {
                VerifyDayIsOpen(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
            }
        });
    }

    function VerifyDayIsOpen(day){
        if(day[0]["active"]){
            FormToGetSchedules(ConvertDateInFrench());
        } else {
            console.log("Désoler Jour fermé");
            // DayIsClose();
        }
    }
}


function FormToGetSchedules(dayInFrench){
    const FORMDAY = {"dayInFrench" : dayInFrench};
    DQLRequestDayIsOpen(FORMDAY);
}

function DQLRequestDayIsOpen(FORMDAY){
    $.ajax({
        url: '/daySchedules',
        method: 'GET',
        data: FORMDAY,
        dataType: "json",
        timeout: 1500,
        success: function(data) {
            ConvertDQLResult(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown, jqXHR);
        }
    });
}

function ConvertDQLResult(DQLResult){
    const SCHEDUELESARRAY = ["openAM", "closeAM", "openPM", "closePM"]
    let schedulesConvert = {};

    for(i = 0; i < 4; i++){
        const SCHEDULES = DQLResult[0][SCHEDUELESARRAY[i]]["date"].replace(":00.000000", '').replace("1970-01-01 ", '');

        schedulesConvert[SCHEDUELESARRAY[i]] = SCHEDULES;
    }

    VerifySchedulesIsOpen(schedulesConvert);
}

function VerifySchedulesIsOpen(schedulesList){
    if(schedulesList["openAM"] == "00:00"){
        // SchedulesClose();
    } else {
        const SCHEDULESAMARRAY = {"open" : schedulesList["openAM"], "close" : schedulesList["closeAM"]};
        ForEachInSchedulesArray(SchedulesDisplay("Am"), SchedulesReservation(SCHEDULESAMARRAY));
    }

    if(schedulesList["openPM"] == "00:00"){
        // SchedulesClose();
    } else {
        const SCHEDULESPMARRAY = {"open" : schedulesList["openPM"], "close" : schedulesList["closePM"]};
        ForEachInSchedulesArray(SchedulesDisplay("Pm"), SchedulesReservation(SCHEDULESPMARRAY));
    }
}

function SchedulesReservation(SCHEDULESAMARRAY){
    const TIMEINMINUTESLIMITRESERVATION = 50;
    const TIMEINSECONDELIMITRESERVATION = TIMEINMINUTESLIMITRESERVATION * 60;
    const TIMEGAPINMINUTES = 15;
    const TIMEGAPINSECONDE = TIMEGAPINMINUTES * 60;

    const SCHEDULESLIMITRESERVATION = SCHEDULESAMARRAY["close"].split(':');
    const SCHEDULESLIMITRESERVATIONINSECONDES = (Number(SCHEDULESLIMITRESERVATION[0])*3600) + (Number(SCHEDULESLIMITRESERVATION[1])*60) - TIMEINSECONDELIMITRESERVATION;

    const SCHEDULESRESERVATION = SCHEDULESAMARRAY["open"].split(':');
    let SchedulesResertionInSeconde = (Number(SCHEDULESRESERVATION[0])*3600) + (Number(SCHEDULESRESERVATION[1])*60);

    let arrayScheduluesReservation = [];

    do {
        const HOURS = Math.trunc(SchedulesResertionInSeconde / 3600);
        let minutes = (SchedulesResertionInSeconde % 3600) / 60;

        if("".concat(minutes).length == 1){
            minutes = "0".concat(minutes);
        }

        const RESULT = "".concat(HOURS, ':', minutes);
        arrayScheduluesReservation.push(RESULT);
        SchedulesResertionInSeconde += TIMEGAPINSECONDE;

    } while(SchedulesResertionInSeconde < SCHEDULESLIMITRESERVATIONINSECONDES);

    return(arrayScheduluesReservation);
}

function SchedulesDisplay(AmPmIndication){
    let inputSchedules;
    if(AmPmIndication == "Am"){
        inputSchedules = document.querySelector("#schedules-AM");
    } else {
        inputSchedules = document.querySelector("#schedules-PM");
    }
    return inputSchedules;
}

function ForEachInSchedulesArray(CLASSCHEDULES, SCHEDULESARRAY){
    SCHEDULESARRAY.forEach(element => {
        let p = document.createElement("option");
        p.textContent = element;
        p.value = element;
        CLASSCHEDULES.prepend(p);
    });
}
