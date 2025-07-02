function showMenu() {
    document.getElementById("navLinks").classList.add("active");
    document.getElementById("mobileHeadBtnWrapper").classList.add("active");
    document.getElementById("openMenu").style.display = "none";
    document.getElementById("closeMenu").style.display = "block";
}

function hideMenu() {
    document.getElementById("navLinks").classList.remove("active");
    document.getElementById("mobileHeadBtnWrapper").classList.remove("active");
    document.getElementById("openMenu").style.display = "block";
    document.getElementById("closeMenu").style.display = "none";
}


document.addEventListener("DOMContentLoaded", function () {
  const resourcesToggle = document.getElementById('resourcesToggle');
  const resourcesDropdown = document.getElementById('resourcesDropdown');

  // Toggle dropdown visibility
  resourcesToggle.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent the click from bubbling up to the document
    const isVisible = resourcesDropdown.style.display === 'flex';
    resourcesDropdown.style.display = isVisible ? 'none' : 'flex';
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function (e) {
    if (
      !resourcesDropdown.contains(e.target) &&
      !resourcesToggle.contains(e.target)
    ) {
      resourcesDropdown.style.display = 'none';
    }
  });
});