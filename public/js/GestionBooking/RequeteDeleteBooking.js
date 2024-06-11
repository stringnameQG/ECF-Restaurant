window.onload = () => {
    const INPUTDATE = document.querySelector('.btn-delete');
    INPUTDATE.addEventListener("click", GetDate);  
}

function GetDate() {
    const DATE = document.querySelector(".date-delete");
    let dateArray = {};
    dateArray["date"] = DATE.value;
    if((DATE.value != "") && confirm("Etes vous sur de vouloir supprimer toute les réservation jusqua " + DATE.value )) {
        DeleteDayRequest(dateArray);
    }
}

function DeleteDayRequest(dateArray){
    $.ajax({
        url: '/booking/DeleteDay',
        method: 'GET',
        data: dateArray,
        dataType: "json",
        timeout: 1500,
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown, jqXHR);
        }
    });
}

