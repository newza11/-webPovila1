<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->bind_param("i", $contact_id);

    if ($stmt->execute()) {
        echo "Message deleted successfully!";
        header('Location: contact_user.php'); // Redirect back to the contact page
    } else {
        echo "Error deleting message: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
