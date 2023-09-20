// Funciones de ayuda para FreshChat

function initFreshChat() {
    window.fcWidget.init({
        token: "d1717533-0125-4907-8fb1-568df5349462",
        host: "https://visionwinsoftwaresl-help.freshchat.com"
    });
        // Limpia el chat del cliente cada vez que conecta
        //window.fcWidget.user.clear(); 


}

function initialize(i, t) {
    var e; i.getElementById(t) ?
        initFreshChat() : ((e = i.createElement("script")).id = t, e.async = !0,
            e.src = "https://visionwinsoftwaresl-help.freshchat.com/js/widget.js", e.onload = initFreshChat, i.head.appendChild(e))
}
function initiateCall() { initialize(document, "Freshchat-js-sdk") }

function paisPermitido() {

    var country = ''
    var allowed_countries = ['ES', 'FR', 'AD']

    try {
        $.ajax({
            url: 'https://ipgeolocation.abstractapi.com/v1/?api_key=6d267a358de04745a5f3916ae7f20516',
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
                country = data.country_code;
            },
            error: function (error) {
                console.log('Error al obtener el pais : ' + error.responseText );
                country = 'ES';
            }
        })
    } catch (error) {
        console.log('Error al obtener el pais');
        country = 'ES';
    }

    return allowed_countries.includes(country);
}


function freshChat() {

    if (paisPermitido()) {

        window.addEventListener ? window.addEventListener("load", initiateCall, !1) :
            window.attachEvent("load", initiateCall, !1);
    }
}

