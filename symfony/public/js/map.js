var esaipUnivs = {
    "Esaip Angers": { "lat": 47.463972, "lon": -0.497227 },
    "Esaip Aix-en-Provence": { "lat": 43.5276723, "lon": 5.4314262 }
}
// On initialise la latitude et la longitude de l'ESAIP (centre de la carte)
var lat = 47.463972;
var lon = -0.497227;
var macarte = null;
var currentUnivLocation = null;
var ignoreClick = 0;

//initialisation layerGroups
var recherche = null;
var esaip = null;
var sep = null;
var ir = null;

var redIcon = L.icon({
    iconUrl: "/images/map/marker-iconRed.png",
    shadowUrl: "/images/map/marker-shadow.png",
    iconSize: [25, 41],
    shadowSize: [41, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
});

var greenIcon = L.icon({
    iconUrl: "/images/map/marker-iconGreen.png",
    shadowUrl: "/images/map/marker-shadow.png",
    iconSize: [25, 41],
    shadowSize: [41, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
});

var blueIcon = L.icon({
    iconUrl: "/images/map/marker-iconBlue.png",
    shadowUrl: "/images/map/marker-shadow.png",
    iconSize: [25, 41],
    shadowSize: [41, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
});

var yellowIcon = L.icon({
    iconUrl: "/images/map/marker-iconYellow.png",
    shadowUrl: "/images/map/marker-shadow.png",
    iconSize: [25, 41],
    shadowSize: [41, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
});

var cyanIcon = L.icon({
    iconUrl: "/images/map/marker-iconCyan.png",
    shadowUrl: "/images/map/marker-shadow.png",
    iconSize: [25, 41],
    shadowSize: [41, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
});

function searchOPSM() {
    macarte.removeLayer(recherche);
    recherche = L.featureGroup().addTo(macarte);
    if(currentUnivLocation){currentUnivLocation.addTo(recherche);}
    var search = document.getElementById("searchtext").value;
    if (search != "") {
        var searchbaseurl = "https://nominatim.openstreetmap.org/search?format=json&q=";
        var url = searchbaseurl + search;
        var httpreq = new XMLHttpRequest();
        httpreq.overrideMimeType("application/json");
        httpreq.open("GET", url, true);
        httpreq.onload = function () {
            var jsonResponse = JSON.parse(httpreq.responseText);
            updateSearchMarkers(jsonResponse);
            macarte.fitBounds(recherche.getBounds());
        };
        httpreq.send(null);
    }
}

function updateSearchMarkers(jsonObjects) {
    for (let i = 0; i < jsonObjects.length; i++) {
        var coord = [jsonObjects[i].lat, jsonObjects[i].lon];
        var markerName = jsonObjects[i].display_name.split(",")[0];
        var marker = L.marker(coord, { icon: redIcon }).addTo(recherche);
        marker.bindPopup(markerName + "<br><button type=\"button\" class=\"searchpopup\" onclick=\"updateLocation(" + coord[0] + "," + coord[1] + ")\">Choisir</button>");
    }
}

// Fonction d'initialisation de la carte
function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
    macarte = L.map('map', { worldCopyJump: true }).setView([lat, lon], 6);

    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a> - <a href="https://www.openstreetmap.org/copyright">© les contributeurs d’OpenStreetMap</a>',
        minZoom: 2,
        maxZoom: 20,
    }).addTo(macarte);
}

// function checkTicked() {
//     ir.on("add", function (ev) { console.log("ir added") });
//     sep.on("add", function (ev) { console.log("sep added") });
//     ir.on("remove", function (ev) { console.log("ir removed") });
//     sep.on("remove", function (ev) { console.log("sep removed") });
// }

//utiliser un script comme dans home.html.twig pour lancé toute les fonction au démarrage
// window.onload = function () {
//     // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
//     initMap();
//     checkTicked();
// };

function addUnivToMap() {
    //initialisation layers
    sep = L.layerGroup().addTo(macarte);
    ir = L.layerGroup().addTo(macarte);
    esaip = L.layerGroup().addTo(macarte);
    //Ajout du menu
    var langueDestination = { "Destinations IR": ir, "Destinations SEP": sep };
    L.control.layers(null, langueDestination).addTo(macarte);
    //Code pour afficher les marker qui sont dans 2 trucs
    ir.on("remove", function (ev) {
        if (ignoreClick == 0) {
            ignoreClick = 2;
            sepButton = document.getElementsByClassName("leaflet-control-layers-selector")[1];
            sepButton.click();
            console.log("SEP Click");
            setTimeout(() => { sepButton.click(); }, 20)
        }
        ignoreClick--;
    });
    sep.on("remove", function (ev) {
        if (ignoreClick == 0) {
            ignoreClick = 2;
            irButton = document.getElementsByClassName("leaflet-control-layers-selector")[0];
            irButton.click();
            console.log("IR Click");
            setTimeout(() => { sepButton.click(); }, 20)
        }
        ignoreClick--;
    });

    //Ajout de la légende
    var legende = L.control({ position: "bottomleft" });
    legende.onAdd = function (macarte) {
        var div = L.DomUtil.create("div", "legende");
        div.innerHTML = '<div><img src="/images/map/marker-iconBlue.png"><p>Destination Anglaise</p></div>' +
            '<div><img src="/images/map/marker-iconYellow.png"><p>Destination Espagnole</p></div>' +
            '<div><img src="/images/map/marker-iconGreen.png"><p>Destination Allemande</p></div>' +
            '<div><img src="/images/map/marker-iconCyan.png"><p>ESAIP</p></div>';

        return div;
    };
    legende.addTo(macarte);
    for (esaipUniv in esaipUnivs) {
        var marker = L.marker([esaipUnivs[esaipUniv].lat, esaipUnivs[esaipUniv].lon], { icon: cyanIcon });;
        marker.addTo(esaip);
        marker.bindPopup(esaipUniv);
    }
    for (univ in univsJSON) {
        univMarker = null;
        switch (univsJSON[univ]["language"]) {
            case "Anglais":
                univMarker = L.marker([univsJSON[univ]["lat"], univsJSON[univ]["lon"]], { icon: blueIcon });
                break;
            case "Allemand":
                univMarker = L.marker([univsJSON[univ]["lat"], univsJSON[univ]["lon"]], { icon: greenIcon });
                break;
            case "Espagnol":
                univMarker = L.marker([univsJSON[univ]["lat"], univsJSON[univ]["lon"]], { icon: yellowIcon });
                break;
            default:
                univMarker = L.marker([univsJSON[univ]["lat"], univsJSON[univ]["lon"]], { icon: redIcon });
                console.log("Probleme de langue sur l'université " + univsJSON[univ]["name"]);
                break;
        }
        var usedMajor = [];
        for (major in univsJSON[univ]["majors"]) {
            if (!usedMajor.includes(univsJSON[univ]["majors"][major]["branch"])) {
                usedMajor.push(univsJSON[univ]["majors"][major]["branch"]);
                switch (univsJSON[univ]["majors"][major]["branch"]) {
                    case "IR":
                        univMarker.addTo(ir);
                        break;
                    case "SEP":
                        univMarker.addTo(sep);
                        break;
                    default:
                        univMarker.addTo(macarte);
                        console.log("Probleme de majeur sur l'université " + univsJSON[univ]["name"]);
                        break;
                }
            }
        }
        univMarker.bindPopup(univsJSON[univ]["name"]
            + "<br>Langue : " + univsJSON[univ]["language"]
            + "<br>Filière : " + usedMajor);
    }
}

function addCurrentUnivLocation(univLat, univLon) {
    recherche.removeLayer(currentUnivLocation);
    currentUnivLocation = L.marker([univLat, univLon], { icon: greenIcon, pane: "currentLocation" });
    currentUnivLocation.bindPopup("Adresse actuelle");
    currentUnivLocation.addTo(recherche);
}

function rechercheUniv() {
    recherche = L.featureGroup().addTo(macarte);
    macarte.createPane("currentLocation");
    macarte.getPane("currentLocation").style.zIndex = 999;
}