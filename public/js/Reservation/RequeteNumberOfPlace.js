GetNumberOfPlace();
function GetNumberOfPlace(){
    $.ajax({
        url: '/NumberOfPlace',
        method: 'GET',
        dataType: "json",
        timeout: 1500,
        success: function(data) {   
            RegisterGetNumberOfPlaceResult(data)
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown, jqXHR);
        }
    });
}

function RegisterGetNumberOfPlaceResult(numberOfPlace){
    const autre = JSON.stringify(numberOfPlace[0]["numberOfPlace"]);
    sessionStorage.setItem("numberOfPlace", autre);
}