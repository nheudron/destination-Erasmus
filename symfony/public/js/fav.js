fav = "fas fa-heart";
nofav = "far fa-heart";
    
function toggleFav(button, id){
    loc = window.location;
    url = loc.protocol +"//"+ loc.hostname+":"+loc.port+"/togglefav/"+id;
    var httpreq = new XMLHttpRequest();
    httpreq.overrideMimeType("application/json");
    httpreq.open("GET", url, true);
    httpreq.onload = function () {
        var jsonResponse = JSON.parse(httpreq.responseText);
        var heart = button.children[0];
        console.log(jsonResponse["present?"])
        if (jsonResponse["present?"]) {
            heart.className = fav;
        }else{
            heart.className = nofav;
        }
    };
    httpreq.send(null);
}

function checkFav(){

}