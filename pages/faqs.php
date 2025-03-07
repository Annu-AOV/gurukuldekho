<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - Frequently Asked Questions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .faq-header {
            background: #D4EDFF;
            padding: 50px 0;
            text-align: center;
        }

        .faq-header h2 {
            font-size: 32px;
            font-weight: bold;
            color: #008ecf;
        }

        .faq-container {
            max-width: 900px;
            margin: auto;
            padding: 40px 20px;
        }

        .faq-title {
            font-size: 22px;
            font-weight: bold;
            color: #0d335d;
            margin-bottom: 20px;
        }

        .faq-box {
            border-top: 1px solid #ddd;
            padding: 15px 0;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            color: #0d335d;
            justify-content: space-between;
            align-items: center;
        }

        .faq-box:last-child {
            border-bottom: 1px solid #ddd;
        }

        .faq-box:hover {
            color: #008ecf;
        }

        .faq-answer {
            display: none;
            padding: 10px 0;
            font-size: 16px;
            color: #666;
        }

        .arrow {
            font-size: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .rotate {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>

    <?php include '../includes/header2.php'; ?>

    <div class="faq-header">
        <h2>FAQs</h2>
    </div>

    <div class="faq-container mt-4 mb-4 p-3 bg-white shadow-sm rounded">
        <div class="faq-title">Frequently Asked Questions</div>

        <!-- FAQ 1 -->
        <div class="faq-box" onclick="toggleFAQ(1)">
            Q: Do I need to login to create a profile for my child for admissions?
            <span class="arrow" id="arrow1">&#9662;</span>
        </div>
        <div class="faq-answer" id="answer1">
            Yes, for creating your child's profile you must sign up on our platform first and create your account.
        </div>

        <!-- FAQ 2 -->
        <div class="faq-box" onclick="toggleFAQ(2)">
            Q: In case I am looking for admissions in two different classes, do I need to create two different accounts?
            <span class="arrow" id="arrow2">&#9662;</span>
        </div>
        <div class="faq-answer" id="answer2">
            If you are applying for more than one child you can simply create separate different child profiles in the
            same account.
        </div>

        <!-- FAQ 3 -->
        <div class="faq-box" onclick="toggleFAQ(3)">
            Q: What happens once I've submitted the application form?
            <span class="arrow" id="arrow3">&#9662;</span>
        </div>
        <div class="faq-answer" id="answer3">
            Once you have submitted the application form, you can keep a track of the application status through your
            dashboard. We will also update you through email and SMS. You can expect a call from the school as well in
            case your application is accepted by the school.
        </div>

        <!-- FAQ 4 -->
        <div class="faq-box" onclick="toggleFAQ(4)">
            Q: Do I need to pay anything again to the school if I apply through your platform?
            <span class="arrow" id="arrow4">&#9662;</span>
        </div>
        <div class="faq-answer" id="answer4">
            You don't need to pay the application form fee again in the school if you apply through our platform. Once
            the child is shortlisted then the payments according to formalities needs to be done at a later stage.
        </div>

        <!-- FAQ 5 -->
        <div class="faq-box" onclick="toggleFAQ(5)">
            Q: What if I don’t have clarity regarding which school is the best fit for my child?
            <span class="arrow" id="arrow5">&#9662;</span>
        </div>
        <div class="faq-answer" id="answer5">
            Don't worry! Our team of expert counselors is always there to help you out in case you have any doubts. You
            can simply put an enquiry or schedule a call and our team will get back to you as soon as possible.
        </div>

    </div>


    <script>
        function toggleFAQ(index) {
            var answer = document.getElementById("answer" + index);
            var arrow = document.getElementById("arrow" + index);

            if (answer.style.display === "block") {
                answer.style.display = "none";
                arrow.classList.remove("rotate");
            } else {
                answer.style.display = "block";
                arrow.classList.add("rotate");
            }
        }
    </script>

</body>
<?php
// Include the header.php file
include('../includes/footer.php');
?>

</html>