var temp;
var verify;

function changetype(librarianID){

    let status = document.getElementById("typeButton" + librarianID);

    if(temp == "Head Librarian"){
        verify = confirm("Are you sure you want to change type from Head Librarian to Librarian");
    }
    else{
        verify = confirm("Are you sure you want to change type from Librarian to Head Librarian");
    }

    if(verify){
        $.ajax({
            url : 'accounttypeChanger - librarian.php',
            type : 'POST',
            data: {
                ID : librarianID
            },
            success : function (result) {
                if(result.trim().includes("You can set 1 Head Librarian only")){
                    alert(result);
                }
                else{
                    if(temp == "Head Librarian"){
                        document.getElementById("typeButton" + librarianID).classList.add('btn-warning');
                        temp = "Librarian";
                        status.innerHTML = temp;
                        console.log("Librarian");
                    }
                    else{
                        document.getElementById("typeButton" + librarianID).classList.add('btn-warning');
                        temp = "Head Librarian";
                        status.innerHTML = temp;
                        console.log("Head Librarian");
                    }
                }
            },
            error : function () {
                console.log ('error');
            }
        });

        
    }
}

function typehover(librarianID){
    let status = document.getElementById("typeButton" + librarianID);

    document.getElementById("typeButton" + librarianID).classList.remove('btn-warning');
    document.getElementById("typeButton" + librarianID).classList.add('btn-danger');
    temp = status.innerHTML;
    status.innerHTML = "Change Type";
    console.log("Hover In");
}

function typehoverOut(librarianID){
    let status = document.getElementById("typeButton" + librarianID);

    document.getElementById("typeButton" + librarianID).classList.remove('btn-danger');
    document.getElementById("typeButton" + librarianID).classList.add('btn-warning');
    status.innerHTML = temp;
    console.log("Hover Out");
}



