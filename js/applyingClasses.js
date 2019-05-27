        var allLabels = document.body.querySelectorAll("label");
        var maxL = allLabels.length;


        var allTextInputs = document.body.querySelectorAll('input[type="text"]');
        var maxTI = allTextInputs.length;

        var allP = document.body.querySelectorAll('.formP');
        var maxP = allP.length;

        function labelClasses() {
                let i = 0;
            do {
                let label = allLabels[i];
                label.classList.add("col-12", "col-md-4" )
                i++;

            } while (i < maxL)
        }

        function inputClasses() {
                let i = 0;
            do {
                let input = allTextInputs[i];
                input.classList.add("col-12", "col-md-8");
                i++;

            } while (i < maxTI)
        }

        function pClasses() {
                let i = 0;
            do {
                let p = allP[i];
                p.classList.add("col-12", "col-md-8", "row");
                i++;

            } while (i < maxP)
        }

        function applyAllClasses () {
            labelClasses();
            inputClasses();
            pClasses();
        }

        applyAllClasses();
