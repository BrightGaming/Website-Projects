let body = document.body;

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   search.classList.remove('active');
}

let search = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () =>{
   search.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () =>{
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

window.onscroll = () =>{
    profile.classList.remove('active');
    search.classList.remove('active');

    if (window.innerWidth < 1200 && !sideBar.classList.contains('active')) {
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }
}

let toggleBtn = document.querySelector('#toggle-btn');
let darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () => {
   toggleBtn?.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enable');
};

const disableDarkMode = () => {
   toggleBtn?.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disable');
};

// Apply Dark Mode on Page Load
if (darkMode === 'enable') {
   enableDarkMode();
}

// Toggle Dark Mode on Button Click
toggleBtn?.addEventListener('click', () => {
   let darkMode = localStorage.getItem('dark-mode');
   if (darkMode === 'disable') {
       enableDarkMode();
   } else {
       disableDarkMode();
   }
});


// review java script

document.addEventListener("DOMContentLoaded", function () {
    let submitBtn = document.getElementById("submit-btn");
    let reviewName = document.getElementById("reviewer-name");
    let reviewEmail = ""; // Variable to store email
    let reviewsList = document.getElementById("reviews-list");

    // Auto-fill reviewer name and email if logged in
    let userData = localStorage.getItem("user");
    if (userData) {
        let user = JSON.parse(userData);
        if (reviewName) reviewName.value = user.name;
        reviewName.setAttribute("readonly", "true"); // Prevent editing
        reviewEmail = user.email; // Store email for review submission
    }

    function loadReviews() {
        fetch("reviews.php")
            .then(response => response.json())
            .then(data => {
                let reviewsList = document.getElementById("reviews-list");
                reviewsList.innerHTML = "";
                data.forEach(review => {
                    reviewsList.innerHTML += `
                        <div class="review">
                            <h4>${review.name} (${review.email}) - ${review.rating}⭐</h4>
                            <p>${review.comment}</p>
                            <small class="review-date">${review.created_at}</small> <!-- Date & Time -->
                        </div>
                    `;
                });
            })
            .catch(error => console.error("Error fetching reviews:", error));
    }    

    function submitReview() {
        let name = reviewName.value.trim();
        let rating = document.getElementById("review-rating").value;
        let comment = document.getElementById("review-comment").value.trim();

        if (name === "" || comment === "" || reviewEmail === "") {
            alert("Please fill in all fields.");
            return;
        }

        let formData = new FormData();
        formData.append("name", name);
        formData.append("email", reviewEmail); // Send email with review
        formData.append("rating", rating);
        formData.append("comment", comment);

        fetch("reviews.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success || data.error);
            if (data.success) {
                document.getElementById("review-comment").value = "";
                document.getElementById("review-rating").value = "5";
                loadReviews(); // Reload reviews after submitting
            }
        })
        .catch(error => console.error("Error submitting review:", error));
    }

    if (submitBtn) submitBtn.addEventListener("click", submitReview);
    loadReviews(); // Load reviews when page loads
});

//review part end//

//register part start//

document.addEventListener("DOMContentLoaded", function () {
    let registerForm = document.getElementById("registerForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let formData = new FormData(registerForm);

            fetch("register.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);  // Pop out success message
                    registerForm.reset(); // Clear form
                } else {
                    alert(data.error); // Pop out error message
                }
            })
            .catch(error => console.error("Error:", error));
        });
    }
});

//register part end//

//login part start//

document.addEventListener("DOMContentLoaded", function () {
    let loginForm = document.querySelector("form[action='login.php']");
    let profileSection = document.querySelector(".profile");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let formData = new FormData(loginForm);

            fetch("login.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    localStorage.setItem("user", JSON.stringify(data.user)); // Save user data
                    window.location.href = data.redirect; // Redirect to correct page
                } else {
                    alert(data.error);
                }
            })
            .catch(error => console.error("Error:", error));
        });
    }

    // Function to update the profile section
    function updateProfile() {
        let userData = localStorage.getItem("user");

        if (userData) {
            let user = JSON.parse(userData);
            profileSection.innerHTML = `
                <img src="picture/Profile_Guest.jpg" alt="">
                <h3>${user.name}</h3>
                <span>${user.user_role}</span>
                <div class="flex-btn">
                    <button onclick="logout()" class="option-btn">Logout</button>
                </div>
            `;
        }
    }

    updateProfile();

    // Logout function
    window.logout = function () {
        localStorage.removeItem("user"); // Remove user data
        fetch("logout.php") // Destroy session
            .then(() => {
                alert("Logged out successfully and see you soon!");
                window.location.href = "login.html";
            });
    };
});


//login part end//

//manage account part start//
document.addEventListener("DOMContentLoaded", function () {
    loadUsers();

    let userForm = document.getElementById("UserAccountForm");
    
    if (userForm) {
        userForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let userId = document.getElementById("userId").value;
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let role = document.getElementById("role").value;

            if (name === "" || email === "") {
                alert("Please fill in all fields.");
                return;
            }

            let formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);
            formData.append("role", role);
            if (password !== "") {
                formData.append("password", password); // Only send password if provided
            }

            let url = userId === "" ? "manage_account.php?action=add" : "manage_account.php?action=edit";
            if (userId !== "") formData.append("id", userId);

            fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.success || data.error);
                userForm.reset();
                document.getElementById("userId").value = "";
                loadUsers(); // Reload the updated user list
            })
            .catch(error => console.error("Error processing request:", error));
        });
    }
});

function loadUsers() {
    fetch("manage_account.php?action=fetch")
        .then(response => response.json())
        .then(data => {
            let userTableBody = document.querySelector("#UserAccountTable tbody");
            if (!userTableBody) return;

            userTableBody.innerHTML = ""; // Clear existing data

            data.forEach(user => {
                userTableBody.innerHTML += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.user_role}</td>
                        <td>
                            <button class="edit-btn" onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.user_role}')">Edit</button>
                            <button class="delete-btn" onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error("Error loading users:", error));
}

function editUser(id, name, email, role) {
    document.getElementById("userId").value = id;
    document.getElementById("name").value = name;
    document.getElementById("email").value = email;
    document.getElementById("role").value = role;
}

function deleteUser(id) {
    if (confirm("Are you sure you want to delete this user?")) {
        let formData = new FormData();
        formData.append("id", id);

        fetch("manage_account.php?action=delete", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success || data.error);
            loadUsers(); // Reload the user list
        })
        .catch(error => console.error("Error deleting user:", error));
    }
}
//manage account part end//

//load user (manage account) part start//
document.addEventListener("DOMContentLoaded", function () {
    let userTable = document.getElementById("UserAccountTable");
    if (userTable) {
        loadUsers();
    }

    let userForm = document.getElementById("UserAccountForm");
    if (userForm) {
        userForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let userId = document.getElementById("userId").value;
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let role = document.getElementById("role").value;

            if (name === "" || email === "") {
                alert("Please fill in all fields.");
                return;
            }

            let formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);
            formData.append("role", role);
            if (password !== "") {
                formData.append("password", password); // Only send password if it's provided
            }

            if (userId === "") {
                sendRequest("manage_account.php?action=add", formData);
            } else {
                formData.append("id", userId);
                sendRequest("manage_account.php?action=edit", formData);
            }
        });
    }
});

function loadUsers() {
    fetch("manage_account.php?action=fetch")
        .then(response => response.json())
        .then(data => {
            let userTableBody = document.querySelector("#UserAccountTable tbody");
            if (!userTableBody) return; // Prevents errors if table is missing

            userTableBody.innerHTML = ""; // Clear table before adding new data
            data.forEach(user => {
                userTableBody.innerHTML += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.user_role}</td>
                        <td>
                            <button class="edit-btn" onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.user_role}')">Edit</button>
                            <button class="delete-btn" onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error("Error loading users:", error));
}
//load user (manage account) part end//

document.addEventListener("DOMContentLoaded", function() {
    let selectedFolder = null;

    // Open upload dialog
    document.querySelectorAll(".add-file-btn").forEach(button => {
        button.addEventListener("click", function() {
            selectedFolder = this.closest(".folder").querySelector(".file-list");
            document.getElementById("upload-dialog").style.display = "block";
        });
    });

    // Handle file selection
    document.getElementById("fileInput").addEventListener("change", function() {
        let fileName = this.files[0] ? this.files[0].name : "No file selected";
        document.getElementById("fileName").textContent = fileName;
    });

    // Upload file (add to list)
    document.getElementById("uploadBtn").addEventListener("click", function() {
        let fileInput = document.getElementById("fileInput");
        if (fileInput.files.length > 0 && selectedFolder) {
            let file = fileInput.files[0];
            let listItem = document.createElement("li");
            let link = document.createElement("a");
            link.href = URL.createObjectURL(file);
            link.textContent = file.name;
            link.download = file.name;
            listItem.appendChild(link);
            selectedFolder.appendChild(listItem);
        }
        closeDialog();
    });

    // Cancel upload
    document.getElementById("cancelBtn").addEventListener("click", closeDialog);

    function closeDialog() {
        document.getElementById("upload-dialog").style.display = "none";
        document.getElementById("fileInput").value = "";
        document.getElementById("fileName").textContent = "No file selected";
    }
});



/*ict*/

