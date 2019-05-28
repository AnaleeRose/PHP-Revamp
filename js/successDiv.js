    function errorToSuccess(){
        var imgSuccess = document.body.querySelector("#success");
        if (imgSuccess) {
            imgSuccess  .parentElement.parentElement.parentElement.classList.remove("errorEffectDiv");
            imgSuccess  .parentElement.parentElement.parentElement.classList.add("successEffectDiv");
            imgSuccess  .parentElement.parentElement.setAttribute("id", "successEffectUl");
        }
    }

     window.onload = errorToSuccess;
