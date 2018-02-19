var acc = document.getElementsByClassName("accordion");

for (var i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("tease");
        this.nextElementSibling.classList.toggle("show");
    }
    acc[i].onmouseover = function() {
        if (!this.classList.contains("active")) {
            this.nextElementSibling.classList.add("tease");
        }
    }
    acc[i].onmouseout = function() {
        if (!this.classList.contains("active")) {
            this.nextElementSibling.classList.remove("tease");
        }
    }
}