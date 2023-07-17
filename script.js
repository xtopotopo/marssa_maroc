
        document.addEventListener("DOMContentLoaded", function(event) {
            var ajouteBtn = document.getElementById("ajoute_btn");
            var annulerBtn = document.getElementById("annuler_btn");
            var form = document.getElementById("navire_forme");
            var btnDiv = document.getElementById("btn_div");


            ajouteBtn.addEventListener("click", function() {
                ajouteBtn.style.display = "none";
                form.style.display = "block";
            });

        

            annulerBtn.addEventListener("click", function() {
                ajouteBtn.style.display = "inline-block";
                
                form.style.display = "none";
            });
        });
 

