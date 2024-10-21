<?php
require('../model/database.php');
include '../view/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email) {
       
        $query = 'SELECT * FROM customers WHERE email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $customer = $statement->fetch();
        $statement->closeCursor();

        if ($customer) {
            session_start();
            $_SESSION['customerID'] = $customer['customerID'];
            $_SESSION['customerName'] = $customer['firstName'] . ' ' . $customer['lastName'];
            header('Location: create_incident.php');
            exit;
        } else {
            $error_message = 'Customer not found. Please check your email.';
        }
    } else {
        $error_message = 'Invalid email address. Please try again.';
    }
}
?>

    <h2>Get Customer</h2>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <button type="submit">Get Customer</button>
    </form>
    <?php if (!empty($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

<?php include '../view/footer.php'; ?>