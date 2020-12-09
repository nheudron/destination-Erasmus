loc = window.location;
baseurl = loc.protocol + "//" + loc.hostname + ":" + loc.port;

function toggleFav(button, id) {
    toggleUrl = baseurl + "/togglefav/" + id;
    var httpreq = new XMLHttpRequest();
    httpreq.overrideMimeType("application/json");
    httpreq.open("GET", toggleUrl, true);
    httpreq.onload = function () {
        var jsonResponse = JSON.parse(httpreq.responseText);
        if (jsonResponse["redirect"]) {
            window.location.href = baseurl + "/login";
        } else {
            toggleHeart(button, jsonResponse["present?"]);
            favs = getCookie("listFavorites");
            currentuniv = ",univ"+id;
            if(jsonResponse["present?"]){
                favs += currentuniv;
                setCookie("listFavorites",favs, 10/60/24);//minutes
            }else{
                favs = favs.replace(currentuniv,"");
                setCookie("listFavorites", favs, 10/60/24);//minutes
            }
        }
    };
    httpreq.send(null);
}

function checkFav() {
    getFavUrl = baseurl + "/getallfav";

    try {
        favs = getCookie("listFavorites");
        if (favs != "") {
            favList = favs.split(',');
            console.log(favList);
            for (const univ in favList) {
                button = document.getElementById(favList[univ]);
                if (button != null) {
                    toggleHeart(button, true);
                }
            }
        } else {
            var httpreq = new XMLHttpRequest();
            httpreq.overrideMimeType("application/json");
            httpreq.open("GET", getFavUrl, true);
            httpreq.onload = function () {
                var jsonResponse = JSON.parse(httpreq.responseText);
                if (jsonResponse["connected"]) {
                    var univs = jsonResponse["univs"];
                    cookiecontent = "done";
                    if(univs.length > 0){
                        cookiecontent += ","+univs
                    }
                    setCookie("listFavorites", cookiecontent, 10/60/24);//minutes
                    for (const univ in univs) {
                        button = document.getElementById(univs[univ]);
                        if (button != null) {
                            toggleHeart(button, true);
                        }
                    }
                }
            };
            httpreq.send(null);
        }
    } catch (error) {
        console.log(error);
    }
}

function toggleHeart(button, state) {
    fav = "fas fa-heart";
    nofav = "far fa-heart";
    var heart = button.children[0];

    if (state) {
        heart.className = fav;
    } else {
        heart.className = nofav;
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}