<?php
require('../model/database.php');
include '../view/header.php';

session_start();
if (!isset($_SESSION['customerID'])) {
    header('Location: index.php');
    exit;
}

?>


    <h2>Create Incident</h2>
    <p>This incident was added to our database.</p>
    <a href="index.php">Back to Home</a>

<?php include '../view/footer.php'; ?>