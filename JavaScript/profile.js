var qrText = document.getElementById('qr-name').innerHTML;



qrcode.src="https://api.qrserver.com/v1/create-qr-code/?size=[250]x[250]&data=" + qrText;
    
// Get the modal and its elements
const modal = document.getElementById("myModal");

// Get all book buttons
const bookButtons = document.querySelectorAll(".view-button");

// Attach click event to each book button
bookButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault(); // Prevent the default behavior of anchor tags
        
    // Show the modal
    modal.style.display = "flex";
  });
});

// Close the modal when the 'x' is clicked or when clicking outside of it
const closeModal = document.getElementById("closeModal");
closeModal.addEventListener("click", () => {
  modal.style.display = "none";
});

window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

