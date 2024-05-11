var verify;

function changeStatus(patronID){

    let status = document.getElementById("statusButton" + patronID);

    if(status.innerHTML == "Disable"){
        verify = confirm("Are you sure you want to Disable the account?");
    }
    else{
        verify = confirm("Are you sure you want to Enable the account?");
    }

    if(verify){
        $.ajax({
            url : 'accountStatusChanger - patron.php',
            type : 'POST',
            data: {
                ID : patronID
            },
            success : function (result) {
            console.log (result);
            console.log('Nice');
            },
            error : function () {
            console.log ('error');
            }
        });

        if(status.innerHTML == "Enable"){
            document.getElementById("statusButton" + patronID).classList.remove('btn-danger');
            document.getElementById("statusButton" + patronID).classList.add('btn-success');
            status.innerHTML = "Enabled";
            console.log("Enabled");
        }
        else{
            document.getElementById("statusButton" + patronID).classList.remove('btn-success');
            document.getElementById("statusButton" + patronID).classList.add('btn-danger');
            status.innerHTML = "Disabled";
            console.log("Disabled");
        }
    }
}

function hover(patronID){
    let status = document.getElementById("statusButton" + patronID);

    if(status.innerHTML == "Disabled"){
        document.getElementById("statusButton" + patronID).classList.remove('btn-danger');
        document.getElementById("statusButton" + patronID).classList.add('btn-success');
        status.innerHTML = "Enable";
        console.log("Enter: still Disabled");
    }
    else{
        document.getElementById("statusButton" + patronID).classList.remove('btn-success');
        document.getElementById("statusButton" + patronID).classList.add('btn-danger');
        status.innerHTML = "Disable";
        console.log("Enter: still Enabled");
    }
}

function hoverOut(patronID){
    let status = document.getElementById("statusButton" + patronID);

    if(status.innerHTML == "Disable" || status.innerHTML == "Enabled"){
        document.getElementById("statusButton" + patronID).classList.remove('btn-danger');
        document.getElementById("statusButton" + patronID).classList.add('btn-success');
        status.innerHTML = "Enabled";
        console.log("Exit: still Enabled");
    }
    else{
        document.getElementById("statusButton" + patronID).classList.remove('btn-success');
        document.getElementById("statusButton" + patronID).classList.add('btn-danger');
        status.innerHTML = "Disabled";
        console.log("Exit: still Disabled");
    }
}



