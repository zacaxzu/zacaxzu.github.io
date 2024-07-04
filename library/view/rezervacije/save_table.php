<?php

// Check if all required POST parameters are set
if (isset($_POST['row'], $_POST['day'], $_POST['value'])) {
    // Sanitize input
    $row = intval($_POST['row']); // Ensure $row is an integer
    $day = intval($_POST['day']); // Ensure $day is an integer
    $value = htmlspecialchars($_POST['value']); // Sanitize $value for safe storage

    // Load existing table data from JSON file
    $tableData = [];
    $jsonFile = 'table_data.json';

    if (file_exists($jsonFile)) {
        $tableData = json_decode(file_get_contents($jsonFile), true);
    }

    // Update the specific cell value
    if (isset($tableData[$row])) {
        $tableData[$row][$day + 1] = $value; // +1 for skipping the first column (time record)
    }

    // Save updated table data back to JSON file
    if (file_put_contents($jsonFile, json_encode($tableData, JSON_PRETTY_PRINT))) {
        echo "Data saved successfully."; // Response message for successful save
    } else {
        http_response_code(500); // Internal Server Error response code
        echo "Failed to save data."; // Response message for save failure
    }
} else {
    http_response_code(400); // Bad Request response code
    echo "Missing POST parameters."; // Response message for missing parameters
}
