formToggle = 0;
majeureModif = 0;
coursenumber = 1;
majeurenumber = 0;
loc = window.location;
baseurl = loc.protocol + "//" + loc.hostname + ":" + loc.port;

function updateForm(element) {
    form = document.getElementById("formWrapper");
    if (typeof(element) !== 'undefined') {
        id = parseInt(element.id.substring(4));
        univModifDetailsUrl = baseurl + "/univModifDetails/" + id;

        var httpreq = new XMLHttpRequest();
        httpreq.overrideMimeType("application/json");
        httpreq.open("GET", univModifDetailsUrl, true);
        httpreq.onload = function () {
            var jsonResponse = JSON.parse(httpreq.responseText);
            document.getElementById("modifUnivId").value = jsonResponse["id"];
            document.getElementById("modifUnivName").value = jsonResponse["name"];
            document.getElementById("modifUnivCity").value = jsonResponse["univCity"]["name"];
            document.getElementById("modifUnivCountry").value = jsonResponse["univCity"]["cityCountry"]["name"];
            document.getElementById("nbPlaces").value = jsonResponse["availablePlaces"];
            document.getElementById("dormitoriescb").checked = jsonResponse["dormitories"];
        };
        httpreq.send(null);
    }
    if (formToggle == 0) {
        formToggle = 1;
        form.className = "activeForm";
    } else {
        clearForm();
        formToggle = 0;
        form.className = null;
    }
}

function updateMajeureList(element) {
    var bouttonMajeure = document.getElementById("submitMajeure");
    if (majeureModif == 0) {
        if (typeof(element) !== 'undefined') {
            bouttonMajeure.setAttribute("onclick", "addMajeureToUniv("+element+")");
            bouttonMajeure.innerText = "Modifier";

            var divContent = document.getElementById("hiddenCourse"+element);
            var courseNames =  divContent.getElementsByClassName("courseName");
            var courseHours =  divContent.getElementsByClassName("courseHours");
            var courseECTSs =  divContent.getElementsByClassName("courseECTS");
            var courseActives =  divContent.getElementsByClassName("courseActive");
            var majeureName =  divContent.getElementsByClassName("majeureName")[0];
            var majeureFiliere =  divContent.getElementsByClassName("majeureFiliere")[0];
            var majeureNBPlaces =  divContent.getElementsByClassName("majeureNBPlaces")[0];

            document.getElementById("filiere").value = majeureFiliere.value;
            document.getElementById("majeure").value = majeureName.value;
            document.getElementById("nbPlaces").value = majeureNBPlaces.value;
            document.getElementById("courses").innerHTML = "";
            for (let i = 0; i < courseNames.length; i++) {
                var currentcourse = addCourseToList();
                currentcourse.getElementsByClassName("courseName")[0].value = courseNames[i].value;
                currentcourse.getElementsByClassName("courseHours")[0].value = courseHours[i].value;
                currentcourse.getElementsByClassName("courseECTS")[0].value = courseECTSs[i].value;
                if (courseActives[i].value == "false") {
                    currentcourse.getElementsByClassName("courseActive")[0].checked = false;
                }else if(courseActives[i].value == "true")
                    currentcourse.getElementsByClassName("courseActive")[0].checked = true;
            }

        }
        document.getElementById("formUpdatingUniv").className = "";
        document.getElementById("changeMajeureCourses").className = "active";
        majeureModif = 1;
    } else {
        document.getElementById("formUpdatingUniv").className = "active";
        document.getElementById("changeMajeureCourses").className = "";
        bouttonMajeure.setAttribute("onclick", "addMajeureToUniv()");
        bouttonMajeure.innerText = "Ajouter";
        majeureModif = 0;
        clearMajeure();
    }
}

function addCourseToList() {
    var courseDiv = document.getElementById("courses");
    var newCourse = document.createElement("div");
    newCourse.className = "coursescontent";
    var left = document.createElement("div");
    left.className = "left";
    var inputName = document.createElement("input");
    inputName.setAttribute("type", "text");
    inputName.setAttribute("placeholder", "Nom de la matière");
    inputName.setAttribute("required", "");
    inputName.className = "courseName";
    left.appendChild(inputName);
    var inputHours = document.createElement("input");
    inputHours.setAttribute("type", "number");
    inputHours.setAttribute("placeholder", "Heure");
    inputHours.setAttribute("required", "");
    inputHours.className = "courseHours";
    left.appendChild(inputHours);
    var inputECTS = document.createElement("input");
    inputECTS.setAttribute("type", "number");
    inputECTS.setAttribute("placeholder", "ECTS");
    inputECTS.setAttribute("required", "");
    inputECTS.className = "courseECTS";
    left.appendChild(inputECTS);
    newCourse.appendChild(left);
    var right = document.createElement("div");
    right.className = "right";
    var inputActive = document.createElement("input");
    inputActive.setAttribute("type", "checkbox");
    inputActive.checked = true;
    inputActive.className = "courseActive";
    right.appendChild(inputActive);
    newCourse.appendChild(right);
    courseDiv.appendChild(newCourse);
    coursenumber++;
    return newCourse;
}

function clearForm() {
    var form = document.getElementById("formWrapper");
    var inputs = form.getElementsByTagName("input");
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
    }
    document.getElementById("languagechoice").getElementsByTagName("input")[0].checked = true;
    document.getElementById("dormitoriescb").checked = false;
    document.getElementById("majeures").innerHTML = "";
    document.getElementById("majeuresHiddenDetails").innerHTML = "";
    majeurenumber = 0;
}

function clearMajeure() {
    var majeure = document.getElementById("changeMajeureCourses");
    var inputs = majeure.getElementsByTagName("input");
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
    }
    document.getElementById("filiere").children[0].selected = true;
    document.getElementById("majeure").children[0].selected = true;
    document.getElementById("courses").innerHTML = "";
    addCourseToList();
}

function addMajeureToUniv(element) {
    if (typeof(element) !== 'undefined') {
        var majeuresHiddenDetails = document.getElementById("majeuresHiddenDetails");
        var courses = document.getElementById("courses");
        document.getElementById("hiddenCourse"+element).remove();
        var hiddendiv = document.createElement("div");
        hiddendiv.id = "hiddenCourse"+element;
        var courseName = courses.getElementsByClassName("courseName");
        var courseHours = courses.getElementsByClassName("courseHours");
        var courseECTS = courses.getElementsByClassName("courseECTS");
        var courseActive = courses.getElementsByClassName("courseActive");
        for (let i = 0; i < courseName.length; i++) {
            var newCourseName = document.createElement("input");
            newCourseName.setAttribute("type", "hidden");
            newCourseName.setAttribute("name", "courseName["+element+"]["+i+"]");
            newCourseName.className = "courseName";
            newCourseName.setAttribute("value",courseName[i].value);
            var newCourseHours = document.createElement("input");
            newCourseHours.setAttribute("type", "hidden");
            newCourseHours.setAttribute("name", "courseHours["+element+"]["+i+"]");
            newCourseHours.className = "courseHours";
            newCourseHours.setAttribute("value",courseHours[i].value);
            var newCourseECTS = document.createElement("input");
            newCourseECTS.setAttribute("type", "hidden");
            newCourseECTS.setAttribute("name", "courseECTS["+element+"]["+i+"]");
            newCourseECTS.className = "courseECTS";
            newCourseECTS.setAttribute("value",courseECTS[i].value);
            var newCourseActive = document.createElement("input");
            newCourseActive.setAttribute("type", "hidden");
            newCourseActive.setAttribute("name", "courseActive["+element+"]["+i+"]");
            newCourseActive.className = "courseActive";
            newCourseActive.setAttribute("value",courseActive[i].checked);
            hiddendiv.appendChild(newCourseName);
            hiddendiv.appendChild(newCourseHours);
            hiddendiv.appendChild(newCourseECTS);
            hiddendiv.appendChild(newCourseActive);
        }
        var majeureNBPlaces = document.createElement("input");
        majeureNBPlaces.setAttribute("type", "hidden");
        majeureNBPlaces.setAttribute("name", "majeureNBPlaces["+element+"]");
        majeureNBPlaces.className = "majeureNBPlaces";
        majeureNBPlaces.setAttribute("value", document.getElementById("nbPlaces").value);
        hiddendiv.appendChild(majeureNBPlaces);
        var majeureFiliere = document.createElement("input");
        majeureFiliere.setAttribute("type", "hidden");
        majeureFiliere.setAttribute("name", "majeureFiliere["+element+"]");
        majeureFiliere.className = "majeureFiliere";
        majeureFiliere.setAttribute("value", document.getElementById("filiere").value);
        hiddendiv.appendChild(majeureFiliere);
        var majeureMajeureName = document.createElement("input");
        majeureMajeureName.setAttribute("type", "hidden");
        majeureMajeureName.setAttribute("name", "majeureName["+element+"]");
        majeureMajeureName.className = "majeureName";
        majeureMajeureName.setAttribute("value", document.getElementById("majeure").value);
        var majeureName = document.getElementById("majeureName["+element+"]");
        majeureName.innerText = document.getElementById("majeure").value;
        hiddendiv.appendChild(majeureMajeureName);
        majeuresHiddenDetails.appendChild(hiddendiv);
    } else {
        var majeureDiv = document.getElementById("majeures");
        var newMajeure = document.createElement("div");
        newMajeure.className = "majeurescontent";
        var left = document.createElement("div");
        left.className = "left";
        var majeureName = document.createElement("p");
        majeureName.innerText = "Nouvelle Majeure";
        majeureName.id = "majeureName["+majeurenumber+"]";
        left.appendChild(majeureName);
        newMajeure.appendChild(left);
        var right = document.createElement("div");
        right.className = "right";
        var editButton = document.createElement("button");
        editButton.setAttribute("type", "button");
        editButton.setAttribute("onclick", "updateMajeureList("+majeurenumber+")");
        editButton.innerText = "Edit";
        right.appendChild(editButton);
        var inputActive = document.createElement("input");
        inputActive.setAttribute("type", "checkbox");
        inputActive.setAttribute("name", "majeureActive[" + majeurenumber + "]");
        inputActive.checked = true;
        inputActive.className = "majeureActive";
        right.appendChild(inputActive);
        newMajeure.appendChild(right);
        majeureDiv.appendChild(newMajeure);

        var majeuresHiddenDetails = document.getElementById("majeuresHiddenDetails");
        var hiddendiv = document.createElement("div");
        var courses = document.getElementById("courses");
        hiddendiv.id = "hiddenCourse"+majeurenumber;
        var courseName = courses.getElementsByClassName("courseName");
        var courseHours = courses.getElementsByClassName("courseHours");
        var courseECTS = courses.getElementsByClassName("courseECTS");
        var courseActive = courses.getElementsByClassName("courseActive");
        for (let i = 0; i < courseName.length; i++) {
            var newCourseName = document.createElement("input");
            newCourseName.setAttribute("type", "hidden");
            newCourseName.setAttribute("name", "courseName["+majeurenumber+"]["+i+"]");
            newCourseName.className = "courseName";
            newCourseName.setAttribute("value",courseName[i].value);
            var newCourseHours = document.createElement("input");
            newCourseHours.setAttribute("type", "hidden");
            newCourseHours.setAttribute("name", "courseHours["+majeurenumber+"]["+i+"]");
            newCourseHours.className = "courseHours";
            newCourseHours.setAttribute("value",courseHours[i].value);
            var newCourseECTS = document.createElement("input");
            newCourseECTS.setAttribute("type", "hidden");
            newCourseECTS.setAttribute("name", "courseECTS["+majeurenumber+"]["+i+"]");
            newCourseECTS.className = "courseECTS";
            newCourseECTS.setAttribute("value",courseECTS[i].value);
            var newCourseActive = document.createElement("input");
            newCourseActive.setAttribute("type", "hidden");
            newCourseActive.setAttribute("name", "courseActive["+majeurenumber+"]["+i+"]");
            newCourseActive.className = "courseActive";
            newCourseActive.setAttribute("value",courseActive[i].checked);
            hiddendiv.appendChild(newCourseName);
            hiddendiv.appendChild(newCourseHours);
            hiddendiv.appendChild(newCourseECTS);
            hiddendiv.appendChild(newCourseActive);
        }
        var majeureNBPlaces = document.createElement("input");
        majeureNBPlaces.setAttribute("type", "hidden");
        majeureNBPlaces.setAttribute("name", "majeureNBPlaces["+majeurenumber+"]");
        majeureNBPlaces.className = "majeureNBPlaces";
        majeureNBPlaces.setAttribute("value", document.getElementById("nbPlaces").value);
        hiddendiv.appendChild(majeureNBPlaces);
        var majeureFiliere = document.createElement("input");
        majeureFiliere.setAttribute("type", "hidden");
        majeureFiliere.setAttribute("name", "majeureFiliere["+majeurenumber+"]");
        majeureFiliere.className = "majeureFiliere";
        majeureFiliere.setAttribute("value", document.getElementById("filiere").value);
        hiddendiv.appendChild(majeureFiliere);
        var majeureMajeureName = document.createElement("input");
        majeureMajeureName.setAttribute("type", "hidden");
        majeureMajeureName.setAttribute("name", "majeureName["+majeurenumber+"]");
        majeureMajeureName.className = "majeureName";
        majeureMajeureName.setAttribute("value", document.getElementById("majeure").value);
        majeureName.innerText = document.getElementById("majeure").value;
        hiddendiv.appendChild(majeureMajeureName);
        majeuresHiddenDetails.appendChild(hiddendiv);
        majeurenumber++;
    }
    document.getElementById("formUpdatingUniv").className = "active";
    document.getElementById("changeMajeureCourses").className = "";
    var bouttonMajeure = document.getElementById("submitMajeure");
    bouttonMajeure.setAttribute("onclick", "addMajeureToUniv()");
    bouttonMajeure.innerText = "Ajouter";
    majeureModif = 0;
    clearMajeure();
}

function updateUniv(element) {
    updateUrl = baseurl + "/updateUniv?"
    const formData = new FormData(element);
    const asString = new URLSearchParams(formData).toString();
    prompt("Copy to clipboard: Ctrl+C, Enter", updateUrl + asString);
}