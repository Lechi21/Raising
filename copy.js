// COPY ACCOUNT NUMBER

function copyAccountNumber() {
    const button = document.querySelector(".copyDetails");
    const accountNumber = document.getElementById("accountNumber").textContent.trim();

    navigator.clipboard.writeText(accountNumber).then(() => {
        button.innerHTML = 'Copied! ✅';
        setTimeout(() => {
        button.innerHTML = 'Copy <span class="material-icons-sharp">content_copy</span>';
        }, 1500);
    })
    .catch(err => {
        console.error("Failed to copy account number: ", err);
        alert("Failed to copy account number. Please try again.");
    });
}


// Function to handle loading book from localStorage
    function loadBookDetails() {
        const book = JSON.parse(localStorage.getItem('selectedBook'));

        if (!book) {
            document.body.innerHTML = `
            <div class="text-center mt-20">
                <p class="text-xl text-gray-600 mb-4">No book selected.</p>
                <a href="index.html" class="text-blue-600 hover:underline">Go back to catalogue</a>
            </div>`;
            return;
        }

        // Populate elements with book data
        document.getElementById('bookImage').src = book.image;
        document.getElementById('bookImage').alt = book.title + " cover";
        document.getElementById('bookTitle').textContent = book.title;
        document.getElementById('bookDescription').textContent = book.description;
        document.getElementById('bookPrice').textContent = book.price;

         // Set the title in the readonly form input
        const formBookTitle = document.getElementById('formBookTitle');
        formBookTitle.value = book.title.toUpperCase();
        formBookTitle.style.textTransform = "uppercase";
        formBookTitle.style.fontWeight = "bold";
    }

    // function loadCourseDetails() {
    //     const course = JSON.parse(localStorage.getItem('selectedCourse'));

    //     if (!course) {
    //         document.body.innerHTML = `
    //         <div class="text-center mt-20">
    //             <p class="text-xl text-gray-600 mb-4">No course selected.</p>
    //             <a href="index.html" class="text-blue-600 hover:underline">Go back to catalogue</a>
    //         </div>`;
    //         return;
    //     }

    //     // Populate elements with course data
    //     document.getElementById('courseImage').src = course.image;
    //     document.getElementById('courseImage').alt = course.title + " cover";
    //     document.getElementById('courseTitle').textContent = course.title;
    //     document.getElementById('courseDescription').textContent = course.description;
    //     document.getElementById('coursePrice').textContent = course.price;

    //      // Set the title in the readonly form input
    //     const formCourseTitle = document.getElementById('formCourseTitle');
    //     formCourseTitle.value = course.title.toUpperCase();
    //     formCourseTitle.style.textTransform = "uppercase";
    //     formCourseTitle.style.fontWeight = "bold";
    // }

      // Back button logic
    function goBack() {
        window.history.back();
    }

      // Call on page load
    window.onload = loadBookDetails;
    // window.onload = loadCourseDetails;


