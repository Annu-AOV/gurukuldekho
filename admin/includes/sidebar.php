<div class="d-flex" id="wrapper">
    <!-- Sidebar -->

    <!-- style="width:200px;height: 2250px; -->
    <div class="bg-dark text-white" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-4">Admin Panel</div>

        <div class="list-group list-group-flush">
            <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white"><i
                    class="fas fa-tachometer-alt"></i>Dashboard</a>

            <!-- Student Dropdown -->
            <a class="list-group-item list-group-item-action bg-dark text-white dropdown-toggle"
                data-bs-toggle="collapse" href="#studentDropdown" role="button" aria-expanded="false"
                aria-controls="studentDropdown"><i class="fas fa-user-graduate"></i>Student</a>
            <div class="collapse" id="studentDropdown">
                <a href="../pages/manage-student.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Student</a>
                <a href="../pages/application.php"
                    class="list-group-item list-group-item-action bg-dark">Applications</a>
            </div>

            <!-- School Dropdown -->
            <a class="list-group-item list-group-item-action bg-dark text-white dropdown-toggle"
                data-bs-toggle="collapse" href="#schoolDropdown" role="button" aria-expanded="false"
                aria-controls="schoolDropdown"><i class="fas fa-school"></i>School</a>
            <div class="collapse" id="schoolDropdown">
                <a href="../pages/add-school.php" class="list-group-item list-group-item-action bg-dark">Add
                    School</a>
                <a href="../pages/manage-school.php" class="list-group-item list-group-item-action bg-dark">Manage
                    School</a>
                <a href="../pages/add-class.php" class="list-group-item list-group-item-action bg-dark">Add
                    Classes</a>
                <a href="../pages/manage-class.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Classes</a>
                <a href="../pages/add-city.php" class="list-group-item list-group-item-action bg-dark">Add
                    Cities</a>
                <a href="../pages/manage-city.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Cities</a>
                <a href="../pages/add-school-media.php" class="list-group-item list-group-item-action bg-dark">Add
                    Media</a>
                <a href="../pages/manage-school-media.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Media</a>
                <a href="../pages/add-schoolfeeStruct.php" class="list-group-item list-group-item-action bg-dark">Add
                    Fee Structure</a>
                <a href="../pages/manage-feeStructure.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Fee Structure</a>
                <a href="../pages/manage-school-quickfact.php"
                    class="list-group-item list-group-item-action bg-dark">Quick Fact</a>
                <a href="../pages/manage-school-lang.php" class="list-group-item list-group-item-action bg-dark">School
                    Language</a>
                <a href="../pages/manage-school-facility.php"
                    class="list-group-item list-group-item-action bg-dark">School Facility</a>
            </div>

            <!-- University Dropdown -->
            <a class="list-group-item list-group-item-action bg-dark text-white dropdown-toggle"
                data-bs-toggle="collapse" href="#universityDropdown" role="button" aria-expanded="false"
                aria-controls="universityDropdown"><i class="fas fa-university"></i>University</a>
            <div class="collapse" id="universityDropdown">
                <a href="../pages/add-university.php" class="list-group-item list-group-item-action bg-dark">Add
                    University</a>
                <a href="../pages/manage-university.php" class="list-group-item list-group-item-action bg-dark">Manage
                    University</a>
                <a href="../pages/add-course.php" class="list-group-item list-group-item-action bg-dark">Add
                    Course</a>
                <a href="../pages/manage-course.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Course</a>
            </div>

            <!-- Admission Dropdown -->
            <a class="list-group-item list-group-item-action bg-dark text-white dropdown-toggle"
                data-bs-toggle="collapse" href="#admissionDropdown" role="button" aria-expanded="false"
                aria-controls="admissionDropdown"><i class="fas fa-user-edit"></i>Admission</a>
            <div class="collapse" id="admissionDropdown">
                <a href="../pages/manage-admission.php" class="list-group-item list-group-item-action bg-dark">Manage
                    Admission</a>
                <a href="../pages/manage-school-document.php"
                    class="list-group-item list-group-item-action bg-dark">Manage Document</a>
            </div>

            <!-- Enquiry Dropdown -->
            <a class="list-group-item list-group-item-action bg-dark text-white dropdown-toggle"
                data-bs-toggle="collapse" href="#enquiryDropdown" role="button" aria-expanded="false"
                aria-controls="enquiryDropdown"><i class="fas fa-question-circle"></i>Admin - enquiries</a>
            <div class="collapse" id="enquiryDropdown">
                <a href="../pages/enquiry.php" class="list-group-item list-group-item-action bg-dark">Enquiry
                    About Admission</a>

            </div>
        </div>
    </div>

    <!-- Page Content style="width:100%" -->
    <div id="page-content-wrapper"> 
        <div class="container-fluid">
            <!-- Content goes here -->