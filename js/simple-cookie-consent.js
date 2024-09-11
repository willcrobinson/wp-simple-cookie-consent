jQuery(document).ready(function($) {
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        var sameSite = "; SameSite=Lax";
        var secure = location.protocol === 'https:' ? "; Secure" : "";
        document.cookie = name + "=" + (value || "") + expires + sameSite + secure + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    var consentBar = $('#simple-cookie-consent');

    if (!getCookie('simple_cookie_consent')) {
        setTimeout(function() {
            consentBar.addClass('visible');
        }, 500);
    }

    $('#scc-accept').click(function() {
        setCookie('simple_cookie_consent', 'accept', sccData.consentPeriod);
        consentBar.removeClass('visible');
        location.reload();
    });

    $('#scc-decline').click(function() {
        setCookie('simple_cookie_consent', 'decline', sccData.consentPeriod);
        consentBar.removeClass('visible');
    });
});