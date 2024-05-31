window.onload = () => {
    const INPUTDATE = document.querySelector('.input__date');
    INPUTDATE.addEventListener("change", ReservationDate);  
}

function ReservationDate(){
    DeleteHoldSearch();
    DateIsNull(UserDateSelect);
    
    function DeleteHoldSearch(){
        const SELECTSCHEDULES = document.querySelector(".schedules").options.length=0;
    }

    function DateIsNull(){
        if(UserDateSelect() == null){
            AddOptionInSelectBalise("Aucune date renseigné", "");
        } else {
            DateComparisonToday();
        }
    }

    function UserDateSelect(){
        const DATESELECTINPAGE = document.querySelector('.input__date');
        const DATESELECT = DATESELECTINPAGE.value;
        return DATESELECT;
    }
    
    function DateComparisonToday(){
        const DATESELECTINMILISECOND = new Date(UserDateSelect()).getTime();
        const CURRENTDATE = Date.now();
        if(DATESELECTINMILISECOND < CURRENTDATE){
            AddOptionInSelectBalise("date antérieur à aujourd'hui", "");
        } else {
            VerifyDayIsOpen(ConvertDateInFrench());
        } 
    }
    
    function ConvertDateInFrench(){
        const DAYNUMBER = new Date(UserDateSelect()).getDay();
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

    function VerifyDayIsOpen(day){
        const ARRAYSCHEDUELSJSON = sessionStorage.getItem("arraysSchedules");  
        if(ARRAYSCHEDUELSJSON.includes(day)){
            VerifySchedulesIsOpen(ARRAYSCHEDUELSJSON, day);
        } else {
            AddOptionInSelectBalise("Fermé", "");
        }
    }

    function VerifySchedulesIsOpen(arraySchedulesJson, day){
        const ARRAYSCHEDULES = JSON.parse(arraySchedulesJson);
        let arraySchedulesOpen = {};

        if(ARRAYSCHEDULES[day]["AM"] == "close"){
            AddOptionInSelectBalise("fermé le matin", "");
        } else {
            const SCHEDULESAMARRAY = {"open" : ARRAYSCHEDULES[day]["AM"][0], "close" : ARRAYSCHEDULES[day]["AM"][ARRAYSCHEDULES[day]["AM"].length - 1]};
            arraySchedulesOpen["AM"] = SCHEDULESAMARRAY;
        }

        if(ARRAYSCHEDULES[day]["PM"] == "close"){
            AddOptionInSelectBalise("fermé le soir", "");
        } else {
            const SCHEDULESPMARRAY = {"open" : ARRAYSCHEDULES[day]["PM"][0], "close" : ARRAYSCHEDULES[day]["PM"][ARRAYSCHEDULES[day]["PM"].length - 1]};
            arraySchedulesOpen["PM"] = SCHEDULESPMARRAY;
        }

        VerifyDayIsFull(RetrieveDate(arraySchedulesOpen));
    }

    function RetrieveDate(SCHEDULESARRAY){
        const DATESELECT = UserDateSelect();

        SCHEDULESARRAY["AM"]["open"] = DATESELECT.concat(" ", SCHEDULESARRAY["AM"]["open"]);
        SCHEDULESARRAY["AM"]["close"] = DATESELECT.concat(" ", SCHEDULESARRAY["AM"]["close"]);

        SCHEDULESARRAY["PM"]["open"] = DATESELECT.concat(" ", SCHEDULESARRAY["PM"]["open"]);
        SCHEDULESARRAY["PM"]["close"] = DATESELECT.concat(" ", SCHEDULESARRAY["PM"]["close"]);

        return SCHEDULESARRAY;
    }

    function VerifyDayIsFull(ARRAYSCHEDULESCONVERT){
        const AMOPEN = DQLRequestDayIsFull(ARRAYSCHEDULESCONVERT["AM"]);
        const PMOPEN = DQLRequestDayIsFull(ARRAYSCHEDULESCONVERT["PM"]);

        RecreateArraySchedules(AMOPEN, PMOPEN);
    }

    function DQLRequestDayIsFull(SCHEDULESARRAY){
        const NUMBEROFPLACE = JSON.parse(sessionStorage.getItem("numberOfPlace"));
        SCHEDULESARRAY["numberOfPlace"] = NUMBEROFPLACE;
        $.ajax({
            url: '/dayFullSchedules',
            method: 'GET',
            data: SCHEDULESARRAY,
            dataType: "json",
            timeout: 1500,
            success: function(data) {
                return data;
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown, jqXHR);
            }
        });
    }

    function RecreateArraySchedules(amIsFull, pmIsFull){
        let arraySchedules = JSON.parse(sessionStorage.getItem("arraysSchedules"));
        arraySchedules = arraySchedules[ConvertDateInFrench()];

        let arrayBooking = [];
        if(!amIsFull){
            arrayBooking = arrayBooking.concat(arraySchedules["AM"]);
        }

        if(!pmIsFull){
            arrayBooking = arrayBooking.concat(arraySchedules["PM"]);
        }
        ForEachInSchedulesArray(arrayBooking);
    }

    function ForEachInSchedulesArray(SCHEDULESARRAY){
        SCHEDULESARRAY.forEach(element => {
            AddOptionInSelectBalise(element, element);
        });
    }

    function AddOptionInSelectBalise(contentBalise, valueBalise){
        const CLASSCHEDULES = document.querySelector(".schedules");
        let option = document.createElement("option");
        option.textContent = contentBalise;
        option.value = valueBalise;
        CLASSCHEDULES.prepend(option);
    }

    const NUMBEROFPLACE = sessionStorage.getItem("numberOfPlace");
    let date = new Date(Date.now() + 30000);
    date = date.toUTCString();
    document.cookie = "numberOfPlace=" + NUMBEROFPLACE + ";" + "path/reservation;" + "expires=" + date;
    
    const ARRAYSCHEDULES = sessionStorage.getItem("arraysSchedules");
    document.cookie = "arraysSchedules=" + ARRAYSCHEDULES + ";" + "path/reservation;" + "expires=" + date;

    console.log(document.cookie);
}
