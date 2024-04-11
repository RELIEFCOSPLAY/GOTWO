// ------------------nav animation------------------
let slider_nav_animation = document.querySelector(".slider_nav_animation");
let slider_nav_animation_li = document.querySelectorAll(".nav_animation ul li");
let index_value = 0;
let left_position = 0;

slider_nav_animation_li.forEach((item, index) => {
  slider_nav_animation.style.width =
    slider_nav_animation_li[0].clientWidth + "px";
  slider_nav_animation.style.left = (left_position + 30) + "px";

  item.onclick = function () {
    slider_nav_animation.style.width = item.clientWidth + "px";
    console.log(index);
    index_value = index;
    get_left_position();
    slider_nav_animation.style.left = (left_position + 30) + "px";
    left_position = 0;
  };
});
// Getting left position for slider to slider
function get_left_position() {
  for (let i = 0; i < index_value; i++) {
    const element = slider_nav_animation_li[i];
    left_position += element.clientWidth;
    console.log(left_position);
  }
}
// ---------sidebar function---------
const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});
