<?php
// Include the header.php file
include('../includes/header2.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .about-header {
            background: url('admin/uploads/homepage_images/cover.png') no-repeat center;
            background-size: cover;
            /* padding: 80px 0; */
            text-align: center;
            position: relative;
        }

        .about-text {
            font-size: 40px;
            font-weight: bold;
            color: #D80032;
        }

        .about-subtext {
            font-size: 38px;
            font-style: italic;
            color: #000;
        }

        .about-section {
            text-align: center;
            padding: 50px 20px;
        }

        .about-section h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .about-section p {
            font-size: 18px;
            color: #555;
            max-width: 900px;
            margin: auto;
        }

        .our-values {
            background: #fff;
        }

        .our-values h2 {
            font-weight: bold;
            color: #000;
        }

        .value-icon {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
            /* filter: invert(28%) sepia(77%) saturate(746%) hue-rotate(340deg) brightness(90%) contrast(96%); */
        }

        .join-us-section {
            background: #fff;
        }

        .position-relative {
            position: relative;
            display: inline-block;
        }

        .about-img {
            max-width: 100%;
            height: auto;
        }

        .text-overlay {
            position: absolute;
            top: 55%;
            left: 60%;
            transform: translate(-50%, -50%);
            /* background: rgba(255, 255, 204, 0.9); Light Yellow Transparent */
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            text-align: center;
        }

        .overlay-title {
            position: absolute;
            top: -50px;
            /* Adjusted for better visibility */
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            font-weight: bold;
            color: #000;
        }

        .text-overlay h3 {
            font-weight: bold;
            color: #000;
            margin-top: 20px;
            /* Adjust for spacing */
        }

        .text-overlay p {
            font-size: 16px;
            color: #333;
        }

        .btn-danger {
            background-color: #d9534f;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .ideas-section {
            padding: 50px 0;
            position: relative;
        }

        .ideas-line {
            position: absolute;
            top: 43%;
            left: 0;
            width: 100%;
            height: 3px;
            background: black;
            z-index: 1;
        }

        .ideas-wrapper {
            position: relative;
            z-index: 2;
        }

        .idea-item {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .icon-container {
            position: relative;
            display: inline-block;
            background: white;
            padding: 5px;
            /* border-radius: 50%;
            border: 3px solid red; */
        }

        .icon-container img {
            height: 80px;
            /* width: 50px; */
        }

        .listHeads {
            font-weight: bold;
            margin-top: 10px;
        }

        .careerSecDesc {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>


    <!-- Header Section with Background Image -->
    <div class="about-header">
        <img src="../admin/uploads/homepage_images/cover.png" alt="About Us Cover" style="width:100%;">
    </div>

    <!-- Vision Section -->
    <div class="about-section">
        <h2>Our Vision</h2>
        <p>
            GurukulDekho is a technologically driven admissions platform that bridges the gap between admission-seeking
            parents and schools.
            We believe that parenting is the toughest journey in a person's life, and so we have made it our mission to
            create a one-stop destination for all your parenting worries.
        </p>
        <p>
            Our quest is to guide parents in their decision of choosing the right school for their child as we
            understand the impact this decision can have on their family's future.
            Parents aren’t the only group we are helping through our platform. We help schools boost their admissions by
            completely digitalizing and streamlining the process.
        </p>
    </div>

    <section class="our-values text-center py-5">
        <h2 class="mb-4">Our Values</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-4">
                    <img src="../admin/uploads/homepage_images/v1.png" alt="Accountability" class="value-icon">
                    <p>Accountability</p>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <img src="../admin/uploads/homepage_images/v2.png" alt="Continuous Learning" class="value-icon">
                    <p>Continuous learning</p>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <img src="../admin/uploads/homepage_images/v3.png" alt="Bias for action" class="value-icon">
                    <p>Bias for action</p>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <img src="../admin/uploads/homepage_images/v4.png" alt="Innovation" class="value-icon">
                    <p>Innovation</p>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <img src="../admin/uploads/homepage_images/v5.png" alt="Value Centricity" class="value-icon">
                    <p>Value centricity</p>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <img src="../admin/uploads/homepage_images/v6.png" alt="Inclusivity" class="value-icon">
                    <p>Inclusivity</p>
                </div>
            </div>
        </div>
    </section>

    <section class="join-us-section text-center">
        <div class="container">
            <div class="position-relative text-center">
                <img src="../admin/uploads/homepage_images/aboutus.png" alt="About Us" class="about-img">
                <div class="text-overlay">
                    <h2 class="overlay-title">Join Us</h2>
                    <h3><b>Applying safely through GurukulDekho</b></h3>
                    <p>
                        GurukulDekho is a completely safe & secure admissions portal where we accept forms officially
                        for
                        the authorised schools who have been partnered with us. To provide our users with the best
                        possible
                        experience and additional layers of trust, we have a dedicated support team to answer all of
                        your queries.
                        With GurukulDekho, you can also track the status of your submitted forms. We have multiple
                        reviews that can
                        attest to the convenience and integrity of our website.
                    </p>
                    <p>
                        GurukulDekho’s safety rules policy helps in maintaining data integrity and your privacy, thus
                        providing you
                        with a safe browsing experience. Eliminate your hesitations today and apply to the best school
                        for your child
                        through GurukulDekho.
                    </p>
                    <a href="#" class="btn btn-danger">Apply Now</a>
                </div>
            </div>
        </div>
    </section>

    <section class="ideas-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center position-relative">
                    <div class="ideas-line"></div>
                    <div class="ideas-wrapper d-flex justify-content-between">

                        <!-- Idea 1 -->
                        <div class="idea-item text-center">
                            <div class="icon-container">
                                <img src="../admin/uploads/homepage_images/ab1.png" alt="Ownership">
                            </div>
                            <p class="listHeads">Ownership :</p>
                            <span class="careerSecDesc" style="font-size: 15px;font-weight: 400;">Initiative &amp;<br>
                                accountability</span>
                        </div>

                        <!-- Idea 2 -->
                        <div class="idea-item text-center">
                            <div class="icon-container">
                                <img src="../admin/uploads/homepage_images/ab2.png" alt="ESOP policy">
                            </div>
                            <p class="listHeads">ESOP policy :</p>
                            <p class="careerSecDesc">Sharing is success</p>
                        </div>

                        <!-- Idea 3 -->
                        <div class="idea-item text-center">
                            <div class="icon-container">
                                <img src="../admin/uploads/homepage_images/ab3.png" alt="Youth-driven">
                            </div>
                            <p class="listHeads mt-3">Youth-driven<br> Company</p>
                        </div>

                        <!-- Idea 4 -->
                        <div class="idea-item text-center">
                            <div class="icon-container">
                                <img src="../admin/uploads/homepage_images/ab4.png" alt="Valuing ideas">
                            </div>
                            <p class="listHeads mt-3">Valuing ideas<br> over hierarchy</p>
                        </div>

                        <!-- Idea 5 -->
                        <div class="idea-item text-center">
                            <div class="icon-container">
                                <img src="../admin/uploads/homepage_images/ab5.png" alt="A team">
                            </div>
                            <p class="listHeads mt-3">A team<br> that is empowered, <br>diverse and inclusive</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<?php include '../includes/footer.php'; ?>
</html>