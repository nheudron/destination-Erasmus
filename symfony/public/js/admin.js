formToggle = 0;

function expendForm(){
    form = document.getElementById("formCreationUniv");
    if (formToggle == 0) {
        formToggle = 1;
        form.className = "activeForm";
    }else{
        formToggle = 0;
        form.className = null;
    }
}