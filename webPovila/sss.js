document.getElementById('confirmButton').addEventListener('click', function() {
    window.location.href = 'logout.php';
});

document.getElementById('cancelButton').addEventListener('click', function() {
    window.location.href = 'admin.php';  // Redirect to homepage
});