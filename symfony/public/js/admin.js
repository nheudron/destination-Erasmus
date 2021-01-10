formToggle = 0;
mapToggle = 0;
coursenumber = 1;
filiereNumber = 1;
majeureNumber = 1;
loc = window.location;
baseurl = loc.protocol + "//" + loc.hostname + ":" + loc.port;

function updateForm(element) {
    form = document.getElementById("formWrapper");
    if (typeof (element) !== 'undefined') {
        id = parseInt(element.id.substring(4));
        univModifDetailsUrl = baseurl + "/univModifDetails/" + id;

        var httpreq = new XMLHttpRequest();
        httpreq.overrideMimeType("application/json");
        httpreq.open("GET", univModifDetailsUrl, true);
        httpreq.onload = function () {
            var jsonResponse = JSON.parse(httpreq.responseText);
            document.getElementById("modifUnivId").value = jsonResponse["id"];
            document.getElementById("modifUnivName").value = jsonResponse["name"];
            var langue = jsonResponse["language"];
            switch (langue) {
                case "Allemand":
                    document.getElementById("de").click();
                    break;
                case "Espagnol":
                    document.getElementById("es").click();
                    break;
                default:
                    document.getElementById("en").click();
                    break;
            }
            document.getElementById("modifUnivCity").value = jsonResponse["univCity"]["name"];
            document.getElementById("modifUnivCountry").value = jsonResponse["univCity"]["cityCountry"]["name"];
            document.getElementById("dormitoriescb").checked = jsonResponse["dormitories"];
            var majeurs = jsonResponse["majors"];
            document.getElementById("majeureSelect").getElementsByClassName("content")[0].innerHTML = "";
            majeureNumber = 0;
            if (majeurs.length)
                for (let i = 0; i < majeurs.length; i++) {
                    var currentSelector = addMajeure();
                    currentSelector.getElementsByClassName("majeure" + majeurs[i]["id"])[0].selected = true;
                }
            var prerequis = jsonResponse["prerequisites"];
            if (prerequis.length) {
                document.getElementById("modifUnivPreR").value = prerequis[prerequis.length - 1]["name"];
            }
            var matieres = jsonResponse["subjects"];
            document.getElementById("courses").innerHTML = "";
            coursenumber = 0;
            if (matieres.length) {
                for (let i = 0; i < matieres.length; i++) {
                    var currentMatiere = addCourseToList();
                    currentMatiere.getElementsByClassName("courseName")[0].value = matieres[i]["name"];
                    currentMatiere.getElementsByClassName("courseHours")[0].value = matieres[i]["credits"];
                    currentMatiere.getElementsByClassName("courseECTS")[0].value = matieres[i]["hoursPerWeek"];
                    currentMatiere.getElementsByClassName("courseActive")[0].checked = matieres[i]["active"];
                }
            }
            document.getElementById("modifUnivLat").value = jsonResponse["lat"];
            document.getElementById("modifUnivLong").value = jsonResponse["lon"];
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

function addCourseToList() {
    var courseDiv = document.getElementById("courses");
    var newCourse = document.createElement("div");
    newCourse.className = "coursescontent";
    var left = document.createElement("div");
    left.className = "left";
    var inputName = document.createElement("input");
    inputName.setAttribute("type", "text");
    inputName.setAttribute("name", "courseName[" + coursenumber + "]");
    inputName.setAttribute("placeholder", "Nom de la matière");
    inputName.setAttribute("required", "");
    inputName.className = "courseName";
    left.appendChild(inputName);
    var inputHours = document.createElement("input");
    inputHours.setAttribute("type", "number");
    inputHours.setAttribute("name", "courseHours[" + coursenumber + "]");
    inputHours.setAttribute("placeholder", "Heure");
    inputHours.setAttribute("required", "");
    inputHours.className = "courseHours";
    left.appendChild(inputHours);
    var inputECTS = document.createElement("input");
    inputECTS.setAttribute("type", "number");
    inputECTS.setAttribute("name", "courseECTS[" + coursenumber + "]");
    inputECTS.setAttribute("placeholder", "ECTS");
    inputECTS.setAttribute("required", "");
    inputECTS.className = "courseECTS";
    left.appendChild(inputECTS);
    newCourse.appendChild(left);
    var right = document.createElement("div");
    right.className = "right";
    var inputActive = document.createElement("input");
    inputActive.setAttribute("type", "checkbox");
    inputActive.setAttribute("name", "courseActive[" + coursenumber + "]");
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
    document.getElementById("en").value = "Anglais";
    document.getElementById("de").value = "Allemand";
    document.getElementById("es").value = "Espagnol";
    document.getElementById("en").click();
    document.getElementById("dormitoriescb").checked = false;
    document.getElementById("modifUnivChangeL").setAttribute("onclick", "changeLocation()");
    document.getElementById("courses").innerHTML = "";
    coursenumber = 0;
    addCourseToList();
    // document.getElementById("filiereSelect").getElementsByClassName("content")[0].innerHTML = "";
    // filiereNumber = 0;
    // addFiliere();
    document.getElementById("majeureSelect").getElementsByClassName("content")[0].innerHTML = "";
    majeureNumber = 0;
    addMajeure();
}

// function addFiliere(){
//     var container = document.getElementById("filiereSelect").getElementsByClassName("content")[0];
//     var rowsNB = container.getElementsByClassName("row").length;
//     if (rowsNB==2) {
//         return
//     }

//     var fTemplate = document.getElementById("hiddenBaseFiliereSelect");
//     var clone = fTemplate.content.cloneNode(true);
//     container.appendChild(clone);
//     var selects = document.getElementsByClassName("selectfiliere");
//     var selector = selects[selects.length - 1];
//     selector.setAttribute("name","filiere["+filiereNumber+"]");
//     filiereNumber++;
// }

function addMajeure() {
    var container = document.getElementById("majeureSelect").getElementsByClassName("content")[0];
    var rowsNB = container.getElementsByClassName("row").length;
    if (rowsNB == nbFiliere) {
        return
    }

    var fTemplate = document.getElementById("hiddenBaseMajeureSelect");
    var clone = fTemplate.content.cloneNode(true);
    container.appendChild(clone);
    var selects = document.getElementsByClassName("selectmajeure");
    var selector = selects[selects.length - 1];
    selector.setAttribute("name", "majeure[" + majeureNumber + "]");
    majeureNumber++;
    return selector;
}

function removeLine(el) {
    el.parentNode.remove()
}

function changeLocation() {
    if (mapToggle == 0) {
        document.getElementById("formUpdatingUniv").className = "";
        document.getElementById("checkLocations").className = "active";
        macarte.invalidateSize();
        var univNameText = document.getElementById("modifUnivName").value;
        var univLat = document.getElementById("modifUnivLat").value;
        var univLon = document.getElementById("modifUnivLong").value;
        document.getElementById("searchtext").value = univNameText;
        searchOPSM();
        if (univLat != "" && univLon != "") {
            addCurrentUnivLocation(univLat, univLon);
        } else {
            macarte.setView([lat, lon], 6);
        }
        mapToggle = 1;
    } else {
        document.getElementById("formUpdatingUniv").className = "active";
        document.getElementById("checkLocations").className = "";
        macarte.removeLayer(recherche);
        mapToggle = 0;
    }
}

function updateLocation(lat, long) {
    document.getElementById("formUpdatingUniv").className = "active";
    document.getElementById("checkLocations").className = "";
    document.getElementById("modifUnivLat").value = lat;
    document.getElementById("modifUnivLong").value = long;
    mapToggle = 0;
}

function updateUniv(element) {
    updateUrl = baseurl + "/updateUniv?"
    const formData = new FormData(element);
    const asString = new URLSearchParams(formData).toString();
    prompt("Copy to clipboard: Ctrl+C, Enter", updateUrl + asString);
}