        var songLimit = false;
        var songBtn = document.getElementById("newSong");
        var songs = document.getElementById("songs");
        if (songBtn) {songBtn.addEventListener("click", addSong);}
        var hide = songs.querySelectorAll(".hide");
        var i = 0;
//shows more song inputs
        function addSong() {
            var hidden = document.querySelector("p.hidden");
            if (hidden) {
                hidden.classList.remove('hidden');
            } else {
                var errorList = document.getElementById("errors");
                var p = document.createElement("p");
                var limitNotice = document.createTextNode("You've hit the song limit!");
                p.classList.add("noMore")
                if (!(document.querySelector(".noMore"))) {
                    p.appendChild(limitNotice);
                    errorList.appendChild(p);
                }

            }
        }
//hides empty song inputs
         function limit() {
            var i = 0;
           if (document.getElementById("song4").value == '') {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song5").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song6").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song7").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song8").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song9").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song10").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song11").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song12").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song13").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song14").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song15").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song16").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song17").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song18").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song19").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song20").value)) {
            hide[i].classList.add('hidden');
           };
           }
        limit();
//error effect
    if (page == "insert"){
        var errorsExist = document.querySelector(".errorEffect");
        var errorDiv = document.querySelector("#errors");
        var cover = document.getElementById("cover");
        if (cover) {
          if(cover.value == '') {
            var error = document.createElement("p");
            var errorList = document.getElementById("errorList");
            var eText = document.createTextNode("If you do not add a cover, a default will be used.");
            var trackHeader = document.querySelector(".tracks");
            var form = document.querySelector("#insertForm")
            error.classList.add("warning", "pl-3", "coverWarning");
            error.appendChild(eText);
            form.insertBefore(error, trackHeader);
        }
        }
        if (errorsExist) {
            errorDiv.classList.add("errorEffectDiv");
        }
    }
        // cool function that added new song inputs... doesnt work with php ;-;
        // function addSong() {
        //     if (songLimit == false) {
        //     var p = document.createElement("p");
        //     var label = document.createElement("label");
        //     var title = document.createTextNode("Title:");
        //     var input = document.createElement("input");
        //     p.classList.add("col-10", "row");
        //     label.setAttribute("for", "song".concat(i));
        //     label.classList.add("col-3", "col-md-2", "col-xl-1");
        //     label.appendChild(title);
        //     input.setAttribute("name", "song".concat(i));
        //     input.setAttribute("id", "song".concat(i));
        //     input.setAttribute("type", "text");
        //     input.classList.add("col-9", "col-md-10", "col-xl-11");
        //     p.appendChild(label);
        //     p.appendChild(input);
        //     songs.appendChild(p);
        //     limit();
        //     } else {


        //     }

        // }

        // function limit() {
        //     if (i <= 15) {
        //     i++} else {
        //         songLimit = true;
        //         var errorList = document.getElementById("errors")
        //         var p = document.createElement("p");
        //         var limitNotice = document.createTextNode("You've hit the song limit!");
        //         p.appendChild(limitNotice);
        //         errorList.appendChild(p);
        //     }
        //     console.log(i)
        // }
