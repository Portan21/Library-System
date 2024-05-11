		// Get the modal and its elements
        const modal = document.getElementById("myModal");
        const modalTitle = document.getElementById("modal-title");
        const modalAuthor = document.getElementById("modal-author");
        const modalGenres = document.getElementById("modal-genres");
        const modalRating = document.getElementById("modal-rating");
        const modalAvailability = document.getElementById("modal-availability");
        const modalDescription = document.getElementById("modal-description")

        // Get all book buttons
        const bookButtons = document.querySelectorAll(".book-button");
        
        // Attach click event to each book button
        bookButtons.forEach((button) => {
          button.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent the default behavior of anchor tags

            // Extract book details from the table row (adjust the class selectors accordingly)
            const row = button.closest("tr");
            const bookName = row.querySelector(".book-button").textContent;
            const author = row.querySelector(".px-4.py-2.text-center.border:nth-child(2)").textContent;
            const genres = row.querySelector(".px-4.py-2.text-center.border:nth-child(3)").textContent;
            const rating = row.querySelector(".px-4.py-2.text-center.border:nth-child(4)").textContent;
            const availability = row.querySelector(".px-4.py-2.text-center.border:nth-child(5)").textContent;
            // const description = row.querySelector(".px-4.py-2.text-center.border:nth-child(6)").textContent;

            const description = button.getAttribute("data-description");
        
            // Populate the modal with book details
            modalTitle.textContent = bookName;
            modalAuthor.textContent = "Authors: " + author;
            modalGenres.textContent = "Genres: " + genres;
            modalRating.textContent = "Rating: " + rating;
            modalAvailability.textContent = "Availability: " + availability;
            modalDescription.textContent = "Description: " + description; // Update the description

        
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