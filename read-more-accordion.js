var acc = document.getElementsByClassName("accordion");

acc.forEach(function(e){
    e.onclick = function() {
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("tease");
        this.nextElementSibling.classList.toggle("show");
    }
    e.onmouseover = function() {
        if (!this.classList.contains("active")) {
            this.nextElementSibling.classList.add("tease");
        }
    }
    e.onmouseout = function() {
        if (!this.classList.contains("active")) {
            this.nextElementSibling.classList.remove("tease");
        }
    }
})