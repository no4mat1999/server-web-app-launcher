document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll(".service-link");
    
    links.forEach(function(link) {
        link.addEventListener("click", function() {
            console.log(this.href);
        });
    });
});
