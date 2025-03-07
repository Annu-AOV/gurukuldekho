<?php
// Include database connection
include('../includes/db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the school ID from the form
    $school_id = $_POST['school_id'];

    // Prepare the list of language fields
    $language_fields = [
        'english', 'hindi', 'french', 'spanish', 'german', 'chinese', 'japanese', 'arabic', 
        'russian', 'portuguese', 'italian', 'korean', 'bengali', 'urdu', 'turkish', 'sanskrit'
    ];

    // Initialize an array to store the language values
    $language_values = [];

    // Loop through the language fields and check if they are selected (set to 1)
    foreach ($language_fields as $field) {
        $language_values[$field] = isset($_POST[$field]) ? 1 : 0;
    }

    // Check if school_id is not empty
    if (!empty($school_id)) {
        // Prepare SQL query to insert or update the languages for the selected school
        $update_query = "INSERT INTO school_language (school_id, english, hindi, french, spanish, german, chinese, japanese, arabic, 
            russian, portuguese, italian, korean, bengali, urdu, turkish, sanskrit) 
            VALUES ('$school_id', '{$language_values['english']}', '{$language_values['hindi']}', '{$language_values['french']}', 
            '{$language_values['spanish']}', '{$language_values['german']}', '{$language_values['chinese']}', '{$language_values['japanese']}', 
            '{$language_values['arabic']}', '{$language_values['russian']}', '{$language_values['portuguese']}', '{$language_values['italian']}', 
            '{$language_values['korean']}', '{$language_values['bengali']}', '{$language_values['urdu']}', '{$language_values['turkish']}', 
            '{$language_values['sanskrit']}') 
            ON DUPLICATE KEY UPDATE 
            english = '{$language_values['english']}',
            hindi = '{$language_values['hindi']}',
            french = '{$language_values['french']}',
            spanish = '{$language_values['spanish']}',
            german = '{$language_values['german']}',
            chinese = '{$language_values['chinese']}',
            japanese = '{$language_values['japanese']}',
            arabic = '{$language_values['arabic']}',
            russian = '{$language_values['russian']}',
            portuguese = '{$language_values['portuguese']}',
            italian = '{$language_values['italian']}',
            korean = '{$language_values['korean']}',
            bengali = '{$language_values['bengali']}',
            urdu = '{$language_values['urdu']}',
            turkish = '{$language_values['turkish']}',
            sanskrit = '{$language_values['sanskrit']}'";

        // Execute the query
        if (mysqli_query($conn, $update_query)) {
            // Redirect to a success page or display success message
            header('Location: manage-school-lang.php?success=1');
        } else {
            // Redirect to an error page or display error message
            header('Location: manage-school-lang.php?error=1');
        }
    } else {
        // Redirect back to the form with an error if school_id is not provided
        header('Location: manage-school-lang.php?error=2');
    }
} else {
    // Redirect back to the form if the request method is not POST
    header('Location: manage-school-lang.php?error=3');
}
?>
