<?php include '../includes/header2.php'; ?>

<div class="container mt-4">
    <h2>Nearby Schools</h2>
    <div id="school-list" class="row">
        <!-- Schools will be dynamically injected here -->
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Retrieve nearby schools from localStorage
        const nearbySchools = JSON.parse(localStorage.getItem("nearbySchools"));

        if (nearbySchools && nearbySchools.length > 0) {
            const schoolList = document.getElementById("school-list");

            // Create school cards dynamically
            nearbySchools.forEach((school) => {
                const schoolCard = `
                <div class="col-md-4 mb-3">
                    <div class="card">
                      <!-- School Photo -->
            <img 
                src="${school.photo ? school.photo : '../admin/uploads/school_photos/school.jpg'}" 
                class="card-img-top" 
                alt="${school.name}" 
                style="height: 200px; object-fit: cover;"
            >
                        <div class="card-body">
                            <h5 class="card-title">${school.name}</h5>
                            <p class="card-text">${school.address}</p>
                            <p class="card-text"><strong>Admission Status:</strong> ${school.admission_status}</p>
                            <a href="viewschool-details.php?id=${school.id}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            `;
                schoolList.innerHTML += schoolCard;
            });
        } else {
            // Show message if no schools are found
            document.getElementById("school-list").innerHTML = `
            <p>No nearby schools found. Please try again.</p>
        `;
        }
    });
</script>

<?php include '../includes/footer.php'; ?>