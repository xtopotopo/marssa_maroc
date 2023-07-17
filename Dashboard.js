
document.addEventListener("DOMContentLoaded", function(event) {
    var employe_btn = document.getElementById("employe_btn");
    var admin_btn = document.getElementById("admin_btn");
    var admin_section = document.getElementById("admin_section");
    var employe_section = document.getElementById("employe_section");
    var admin_section2 = document.getElementById("admin_section2");
    var employe_section2 = document.getElementById("employe_section2");

    employe_btn.addEventListener("click", function() {
        admin_section.style.display = "none";
        admin_section2.style.display = "none";
        employe_section.style.display = "block";
        employe_section2.style.display = "block";
    });



    admin_btn.addEventListener("click", function() {
        admin_section.style.display = "block";
        admin_section2.style.display = "block";
        employe_section.style.display = "none";
        employe_section2.style.display = "none";
    });
});
