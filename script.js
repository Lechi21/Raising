function showMenu() {
    document.getElementById("navLinks").classList.add("active");
    document.getElementById("mobileHeadBtnWrapper").classList.add("active");
    document.getElementById("openMenu").style.display = "none";
    document.getElementById("closeMenu").style.display = "block";
    // document.getElementById("genHeads").style.background = "white";
}

function hideMenu() {
    document.getElementById("navLinks").classList.remove("active");
    document.getElementById("mobileHeadBtnWrapper").classList.remove("active");
    document.getElementById("openMenu").style.display = "block";
    document.getElementById("closeMenu").style.display = "none";
    // document.getElementById("genHeads").style.background = "linear-gradient(to right, #fff 50%, #ffefd5 100%);";
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


// CONTACT FORM SEND
document.getElementById('contact-form').addEventListener('submit', function(e) {
  e.preventDefault(); // Prevent default form submit

  const form = e.target;
  const formData = new FormData(form);
  const messageBox = document.getElementById('form-message');

  fetch('send.php', {
    method: 'POST',
    body: formData
  })
  .then(async (response) => {
    const text = await response.text();

    if (response.ok) {
      messageBox.innerHTML = `<p style="color: green;">${text}</p>`;
      form.reset(); // Clear the form
    } else {
      messageBox.innerHTML = `<p style="color: red;">${text}</p>`;
    }
  })
  .catch(error => {
    messageBox.innerHTML = `<p style="color: red;">Error: ${error}</p>`;
  });
});