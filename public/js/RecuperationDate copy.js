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
            ConvertDateInFrench();
        } 
    }
    
    function ConvertDateInFrench(){
        const DAYNUMBER = new Date(DATESELECT).getDay();
        let dayInFrench;

        switch(DAYNUMBER){
            case 0:
                dayInFrench = 'Lundi';
                break;
            case 1:
                dayInFrench = 'Mardi';
                break;
            case 2:
                dayInFrench = 'Mercredi';
                break;
            case 3:
                dayInFrench = 'Jeudi';
                break;
            case 4:
                dayInFrench = 'Vendredi';
                break;
            case 5:
                dayInFrench = 'Samedi';
                break;
            case 6:
                dayInFrench = 'Dimanche';
                break;
            default:
                dayInFrench = 'error';
        };
        FormToGet(dayInFrench);
    }

    function FormToGet(dayInFrench){
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
        if(day[0] == 0){
            // DayIsClose();
            console.log("Désoler Jour fermé");
        } else {
            RecoverySchedules();
        }
    }

    function RecoverySchedules(){
        const DAY = ConvertDateInFrench();
    }
}
