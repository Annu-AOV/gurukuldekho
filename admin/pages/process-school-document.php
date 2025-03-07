<?php
// Include database connection
include('../includes/db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the school ID from the form
    $school_id = $_POST['school_id'];

    // Prepare the list of document fields
    $document_fields = [
        'address_proof', 'birth_certificate', 'medical_certificate', 'photo', 'caste_certificate',
        'family_photo', 'last_school_details', 'parent_guardian_photo', 'religion_proof', 'report_card',
        'differently_abled_proof', 'sibling_alumni_proof', 'first_girl_child', 'aadhaar_card'
    ];

    // Initialize an array to store the document values
    $document_values = [];

    // Loop through the document fields and check if they are selected (set to 1)
    foreach ($document_fields as $field) {
        if (isset($_POST[$field]) && $_POST[$field] == 1) {
            $document_values[$field] = 1;  // Required
        } else {
            $document_values[$field] = 0;  // Optional
        }
    }

    // Check if school_id is not empty
    if (!empty($school_id)) {
        // Prepare SQL query to update the documents for the selected school
        $update_query = "INSERT INTO school_documents (school_id, address_proof, birth_certificate, medical_certificate, photo, caste_certificate,
            family_photo, last_school_details, parent_guardian_photo, religion_proof, report_card,
            differently_abled_proof, sibling_alumni_proof, first_girl_child, aadhaar_card)
            VALUES ('$school_id', '{$document_values['address_proof']}', '{$document_values['birth_certificate']}', '{$document_values['medical_certificate']}',
            '{$document_values['photo']}', '{$document_values['caste_certificate']}', '{$document_values['family_photo']}',
            '{$document_values['last_school_details']}', '{$document_values['parent_guardian_photo']}', '{$document_values['religion_proof']}',
            '{$document_values['report_card']}', '{$document_values['differently_abled_proof']}', '{$document_values['sibling_alumni_proof']}',
            '{$document_values['first_girl_child']}', '{$document_values['aadhaar_card']}') 
            ON DUPLICATE KEY UPDATE
            address_proof = '{$document_values['address_proof']}',
            birth_certificate = '{$document_values['birth_certificate']}',
            medical_certificate = '{$document_values['medical_certificate']}',
            photo = '{$document_values['photo']}',
            caste_certificate = '{$document_values['caste_certificate']}',
            family_photo = '{$document_values['family_photo']}',
            last_school_details = '{$document_values['last_school_details']}',
            parent_guardian_photo = '{$document_values['parent_guardian_photo']}',
            religion_proof = '{$document_values['religion_proof']}',
            report_card = '{$document_values['report_card']}',
            differently_abled_proof = '{$document_values['differently_abled_proof']}',
            sibling_alumni_proof = '{$document_values['sibling_alumni_proof']}',
            first_girl_child = '{$document_values['first_girl_child']}',
            aadhaar_card = '{$document_values['aadhaar_card']}'";

        // Execute the query
        if (mysqli_query($conn, $update_query)) {
            // Redirect to a success page or display success message
            header('Location: manage-school-document.php?success=1');
        } else {
            // Redirect to an error page or display error message
            header('Location: manage-school-document.php?error=1');
        }
    } else {
        // Redirect back to the form with an error if school_id is not provided
        header('Location: manage-school-document.php?error=2');
    }
} else {
    // Redirect back to the form if the request method is not POST
    header('Location: manage-school-document.php?error=3');
}
?>
