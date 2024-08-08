// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};
// sign out
document.getElementById('homeButton').addEventListener('click', function() {
  window.location.href = '../login.php';
});

// user
function toggleDropdown() {
  var dropdown = document.getElementById('userDropdown');
  if (dropdown.style.display === 'block') {
      dropdown.style.display = 'none';
  } else {
      dropdown.style.display = 'block';
  }
}

window.onclick = function(event) {
  if (!event.target.matches('.user img')) {
      var dropdowns = document.getElementsByClassName('dropdown');
      for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.style.display === 'block') {
              openDropdown.style.display = 'none';
          }
      }
  }
}