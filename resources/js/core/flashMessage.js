App.flash = function(text, type = "success") {

    sessionStorage.setItem("flash_message", JSON.stringify({
        text,
        type
    }));

};

App.initFlash = function() {

    const message = sessionStorage.getItem("flash_message");

    if (!message) return;

    const data = JSON.parse(message);

    App.message(data.text, data.type);

    sessionStorage.removeItem("flash_message");

};