function checkUrlInput() {
    let x, text
    x = document.getElementById("usrmng_url").value
    if (x.includes("http") || x.includes("www.") || x.includes("/") || x.includes("\\") || x.includes("_") || x.includes("#")) {
        text = "Inserisci soltanto il nome della tua pagina, non è necessario l'indirizzo completo"
    } else text = ""
    document.getElementById("users_error_message").innerHTML = text
}

function usrmngResize(url){
    document.getElementById('myIframeUsersManager-'+url).onload = function() {
        iFrameResize({ heightCalculationMethod: "taggedElement" }, "#myIframeUsersManager-"+url);
    }
}

function clickColor(el){
    var color = el.value;
    document.getElementById("usrmng_color").value = color
}