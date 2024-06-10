GetAllDayOpen();
function GetAllDayOpen(){
    $.ajax({
        url: '/AlldayIfOpen',
        method: 'GET',
        dataType: "json",
        timeout: 1500,
        success: function(data) {
            RetrievesSchedulesForAllOpenDays(data)
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown, jqXHR);
        }
    });
}

function RetrievesSchedulesForAllOpenDays(arrayDaySchedules){
    let arraySchedules = {};
    arrayDaySchedules.forEach(day => {
        const ARRAYSCHEDULESOPENCLOSE = {
            "OpenAm" : ConvertSchedules(day["openAM"]["date"]),
            "CloseAm" : ConvertSchedules(day["closeAM"]["date"]),
            "OpenPm" : ConvertSchedules(day["openPM"]["date"]),
            "ClosePm" : ConvertSchedules(day["closePM"]["date"]),
        };
        arraySchedules[day["name"]] = VerifyIsOpen(ARRAYSCHEDULESOPENCLOSE);
    });
    RegisterGetAllDayOpenResult(arraySchedules);
}

function ConvertSchedules(schedules){
    const SCHEDULESCONVERT = schedules.replace(":00.000000", '').replace("1970-01-01 ", '');
    return SCHEDULESCONVERT;
}

function VerifyIsOpen(ARRAYSCHEDULESOPENCLOSE){
    let arraySchedulesOfDay = {"AM" : "empty", "PM" : "empty"};

    if(VerifyIsOpenSchedule(ARRAYSCHEDULESOPENCLOSE["OpenAm"]) || VerifyIsOpenSchedule(ARRAYSCHEDULESOPENCLOSE["CloseAm"])){
        arraySchedulesOfDay["AM"] = "close";    
    } else {
        const SCHEDULESOPEN = ARRAYSCHEDULESOPENCLOSE["OpenAm"];
        const SCHEDULESCLOSE = ARRAYSCHEDULESOPENCLOSE["CloseAm"];
        const SchedulesArray = CreationArraySchedules(SCHEDULESOPEN, SCHEDULESCLOSE);
        arraySchedulesOfDay["AM"] = SchedulesArray;
    }
    
    if(VerifyIsOpenSchedule(ARRAYSCHEDULESOPENCLOSE["OpenPm"]) || VerifyIsOpenSchedule(ARRAYSCHEDULESOPENCLOSE["ClosePm"])){
        arraySchedulesOfDay["PM"] = "close";

    } else {
        const SCHEDULESOPEN = ARRAYSCHEDULESOPENCLOSE["OpenPm"];
        const SCHEDULESCLOSE = ARRAYSCHEDULESOPENCLOSE["ClosePm"];
        const SchedulesArray = CreationArraySchedules(SCHEDULESOPEN, SCHEDULESCLOSE);
        arraySchedulesOfDay["PM"] = SchedulesArray;
    }

    return arraySchedulesOfDay;
}

function VerifyIsOpenSchedule(dayArray){
    const DEFAULTVALUECLOSE = "00:00";
    if(dayArray == DEFAULTVALUECLOSE){
        return true;
    } else {
        return false;
    }
}

function CreationArraySchedules(open, close){
    const TIMEINMINUTESLIMITRESERVATION = 50;
    const TIMEINSECONDELIMITRESERVATION = TIMEINMINUTESLIMITRESERVATION * 60;
    const TIMEGAPINMINUTES = 15;
    const TIMEGAPINSECONDE = TIMEGAPINMINUTES * 60;
    let arraySchedules = [];

    let SchedulesResertionInSeconde = ConvertNumber(open);
    const SCHEDULESLIMITRESERVATIONINSECONDES = ConvertNumber(close) - TIMEINSECONDELIMITRESERVATION;

    do {
        const HOURS = Math.trunc(SchedulesResertionInSeconde / 3600);
        let minute = (SchedulesResertionInSeconde % 3600) / 60;
        minute = VerifyContainsOneZero(minute);

        const RESULT = "".concat(HOURS, ':', minute);
        arraySchedules.push(RESULT);
        SchedulesResertionInSeconde += TIMEGAPINSECONDE;

    } while(SchedulesResertionInSeconde < SCHEDULESLIMITRESERVATIONINSECONDES);
    return arraySchedules;
}

function ConvertNumber(schedules){
    let schedulesReservation = schedules.split(':');
    let SchedulesResertionInSeconde = (Number(schedulesReservation[0])*3600) + (Number(schedulesReservation[1])*60);
    return SchedulesResertionInSeconde;
}

function VerifyContainsOneZero(minute){    
    if("".concat(minute).length == 1){
        const MINUTEMODIFY = "0".concat(minute);
        return MINUTEMODIFY;
    }
    return minute;
}

function RegisterGetAllDayOpenResult(arraySchedules){
    const ARRAYCONVERTJSON = JSON.stringify(arraySchedules);
    sessionStorage.setItem("arraysSchedules", ARRAYCONVERTJSON);
}
