<?php
require('../model/database.php');
include '../view/header.php';

session_start();

if (!isset($_SESSION['customerID'])) {
    header('Location: index.php');
    exit;
}

$customerName = $_SESSION['customerName'];
$customerID = $_SESSION['customerID'];


$query = 'SELECT * FROM products';
$statement = $db->prepare($query);
$statement->execute();
$products = $statement->fetchAll();
$statement->closeCursor();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productCode = filter_input(INPUT_POST, 'productCode', FILTER_SANITIZE_STRING);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    if ($productCode && $title && $description) {
        $dateOpened = date('Y-m-d H:i:s');

        // Insert the incident
        $query = 'INSERT INTO incidents (customerID, productCode, dateOpened, title, description)
                  VALUES (:customerID, :productCode, :dateOpened, :title, :description)';
        $statement = $db->prepare($query);
        $statement->bindValue(':customerID', $customerID);
        $statement->bindValue(':productCode', $productCode);
        $statement->bindValue(':dateOpened', $dateOpened);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->execute();
        $statement->closeCursor();

       
        header('Location: incident_success.php');
        exit;
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>

    <h2>Create Incident</h2>
    <p>Customer: <?php echo htmlspecialchars($customerName); ?></p>
    <form action="" method="post">
        <label for="productCode">Product:</label>
        <select id="productCode" name="productCode" required>
            <?php foreach ($products as $product) : ?>
                <option value="<?php echo $product['productCode']; ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <button type="submit">Create Incident</button>
    </form>

    <?php if (!empty($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

<?php include '../view/footer.php'; ?>