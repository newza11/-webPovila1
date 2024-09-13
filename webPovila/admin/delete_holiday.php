<?php
if (isset($_GET['id'])) {
    include 'db_connection.php';

    $holiday_date = $_GET['id'];

    // Prepare SQL statement to delete the holiday
    $sql = "DELETE FROM holidays_db WHERE holiday_date=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $holiday_date);

    if ($stmt->execute()) {
        // Successful deletion
        $response = array('status' => 'success', 'message' => 'Holiday deleted successfully!');
    } else {
        // Failed deletion
        $response = array('status' => 'error', 'message' => 'Error deleting holiday: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    // Return response as JSON
    echo json_encode($response);
}
?>
