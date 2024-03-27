const list = document.querySelectorAll(".list");
var style = document.createElement("style");
var css = "";
for (let i = 0; i < list.length; i++) {
    if (list[i].querySelector("a span.text").innerHTML === "Logout")
        css += ".list:nth-child(" + (i + 1) * 1 + ").active ~ .indicator { transform: translateX(" + i * 70 + "px); background-color:red}";
    else
        css += ".list:nth-child(" + (i + 1) * 1 + ").active ~ .indicator { transform: translateX(" + i * 70 + "px); }";
}
style.innerHTML = css;
document.head.appendChild(style);

function setActive(item) {
    list.forEach((item) => {
        item.classList.remove("active");
    });
    item.classList.add("active");
    $(".content").load(item.querySelector("a").getAttribute("value"));
}

list.forEach((item) => {
    item.addEventListener("click", () => {
        setActive(item);
    });
});

setActive(list[0]);