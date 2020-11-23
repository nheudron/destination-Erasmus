var univs = {
    "Esaip Angers": { "lat": 47.463972, "lon": -0.497227, "langue": "fr", "cursus": null },
    "Esaip Aix-en-Provence": { "lat": 43.5276723, "lon": 5.4314262, "langue": "fr", "cursus": null },
    "Université de Veliko Tarnovo": { "lat": 43.0783, "lon": 25.6492, "langue": "en", "cursus": "ir" },
    "Universidad Pablo de Olavide": { "lat": 37.356080899999995, "lon": -5.938167775804539, "langue": "es", "cursus": "ir" },
    "Leipzig University of Applied Sciences": { "lat": 51.3142081, "lon": 12.37297079388441, "langue": "de", "cursus": "sep" }
}
// On initialise la latitude et la longitude de l'ESAIP (centre de la carte)
var lat = 47.463972;
var lon = -0.497227;
var macarte = null;

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
    var search = document.getElementById("searchtext").value;
    var searchbaseurl = "https://nominatim.openstreetmap.org/search?format=json&q=";
    var url = searchbaseurl + search;
    var httpreq = new XMLHttpRequest();
    httpreq.overrideMimeType("application/json");
    httpreq.open("GET", url, true);
    httpreq.onload = function () {
        var jsonResponse = JSON.parse(httpreq.responseText);
        updatetext(jsonResponse);
    };
    httpreq.send(null);
}

function updatetext(jsonObjects) {
    var searchResults = document.getElementById("searchResults");
    while (searchResults.rows.length > 1) {
        searchResults.deleteRow(1);
    }
    for (let index = 0; index < jsonObjects.length; index++) {
        let ligne = searchResults.insertRow();
        let cellule1 = ligne.insertCell();
        let nom = document.createTextNode(jsonObjects[index].display_name);
        cellule1.appendChild(nom);
        let cellule2 = ligne.insertCell();
        let coord = document.createTextNode(jsonObjects[index].lat + "," + jsonObjects[index].lon);
        cellule2.appendChild(coord);
        let cellule3 = ligne.insertCell();
        var button = document.createElement('BUTTON');
        let textbutton = document.createTextNode("Voir");
        button.appendChild(textbutton);
        button.setAttribute("onclick", "addtoMap(this)");
        cellule3.appendChild(button);
    }
}

function addtoMap(button) {
    recherche.clearLayers();
    let obj = button.parentNode.parentNode;
    let coord = obj.children[1].innerHTML.split(',');
    let name = obj.children[0].innerHTML.split(',')[0];
    var marker = L.marker(coord, { icon: redIcon }).addTo(recherche);
    marker.bindPopup(name);
    macarte.setView(coord, 15);
}

// Fonction d'initialisation de la carte
function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
    macarte = L.map('map', { worldCopyJump: true }).setView([lat, lon], 6);
    //initialisation layers
    recherche = L.layerGroup().addTo(macarte);
    sep = L.layerGroup().addTo(macarte);
    ir = L.layerGroup().addTo(macarte);
    esaip = L.layerGroup().addTo(macarte);
    //Ajout du menu
    var langueDestination = { "Destinations IR": ir, "Destinations SEP": sep };
    L.control.layers(null, langueDestination).addTo(macarte);
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

    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a> - <a href="https://www.openstreetmap.org/copyright">© les contributeurs d’OpenStreetMap</a>',
        minZoom: 3,
        maxZoom: 20,
    }).addTo(macarte);
    for (univ in univs) {
        var marker = null;
        switch (univs[univ].langue) {
            case "fr":
                marker = L.marker([univs[univ].lat, univs[univ].lon], { icon: cyanIcon });
                break;
            case "en":
                marker = L.marker([univs[univ].lat, univs[univ].lon], { icon: blueIcon });
                break;
            case "es":
                marker = L.marker([univs[univ].lat, univs[univ].lon], { icon: yellowIcon });
                break;
            case "de":
                marker = L.marker([univs[univ].lat, univs[univ].lon], { icon: greenIcon });
                break;
            default:
                console.log(univ + " n'a pas de langue affecté, contacter l'administrateur du site")
                break;
        }
        switch (univs[univ].cursus) {
            case "sep":
                marker.addTo(sep);
                break;
            case "ir":
                marker.addTo(ir);
                break;
            default:
                marker.addTo(macarte);
                break;
        }
        marker.bindPopup(univ + "<br>" + univs[univ].langue + "," + univs[univ].cursus);
    }
}

window.onload = function () {
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    initMap();
};