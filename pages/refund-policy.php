<?php
// Include the header.php file
include('../includes/header2.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Policy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .refund-header {
            background:#accbeb;
            color: #0086c9;
            text-align: center;
            padding: 50px 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .refund-content {
            padding: 40px 15%;
            font-size: 16px;
            line-height: 1.8;
            color: #333;
        }

        .refund-content h5 {
            font-weight: bold;
            color: #0086c9;
        }

        .refund-content ul {
            margin-top: 10px;
        }

        .refund-content ul li {
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .refund-content {
                padding: 20px 5%;
            }
        }
    </style>
</head>
<body>

    <div class="refund-header">
        REFUND POLICY
    </div>

    <div class="refund-content">
        <p>
            We value your trust. In order to honor that trust, GurukulDekho adheres to ethical standards in accepting payments. Please read this privacy policy carefully before using the Website, our portal.
        </p>

        <h5>We provide refund in very specific cases only so it is requested from the users to go through the following points:</h5>
        
        <ul>
            <li>Refunds will only be initiated in case multiple payments are made for the same application.</li>
            <li>In such a case, <strong>the request will be initiated within 2 working days</strong> and payment will be refunded within the next 7 to 10 working days.</li>
            <li>There will be no refund for any application fee processed in order to complete an application form. It is the responsibility of the user to ensure that all applications are accurately and completely filled in at the time of submitting the application.</li>
            <li>Applications will not be amended in any way after submission and there will be no refund processed for cancellation of an application.</li>
            <li>Notwithstanding this policy, any specific terms and conditions mentioned on individual service pages, or as agreed with a user before/during/after the transaction, will override the terms and conditions mentioned here.</li>
        </ul>
        
        <p>
            We may make changes to our services, and associated terms & conditions (including terms and conditions on refund and cancellation), from time to time. You are advised to refer to our latest terms and conditions on this page and associated service-specific terms and conditions before making a payment.
        </p>
    </div>

</body>
<?php include '../includes/footer.php'; ?>
</html>
