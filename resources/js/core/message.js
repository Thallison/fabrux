App.message = function(message, type="success"){

    const html = `
    <div class="alert alert-${type} alert-dismissible fade show flash-msg" role="alert" aria-live="assertive">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    `;

    const container = document.getElementById("content_area");

    if(container){
        container.insertAdjacentHTML("afterbegin", html);

        if(App.defaultMessageDuration){
            const alert = container.querySelector('.flash-msg');

            if(alert){
                setTimeout(function(){
                    alert.remove();
                }, App.defaultMessageDuration);
            }
        }
    }

};