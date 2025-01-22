<?php
session_start();
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["address"])) {
    include 'db_connectie.php';
    $db = maakVerbinding();
    $address = $_POST['address'];
    $client_username = $_SESSION["user_data"]["username"];
    $client_name = $_SESSION["user_data"]["first_name"];
    $personnel_username = isset($_SESSION['personnel_username']) ? $_SESSION['personnel_username'] : 'abrouwer';
    $status = '1';
    $datetime = date('Y-m-d H:i:s');

    $sql = "SELECT TOP 1 username FROM [User] WHERE username = :personnel_username";
    $stmt = $db->prepare($sql);
    $stmt->execute([':personnel_username' => $personnel_username]);
    $personnel_exists = $stmt->fetchColumn();

    if ($personnel_exists == 0) {
        die("Error: personnel_username does not exist in the User table.");
    }

    $winkelmandje = isset($_SESSION["Winkelmandje"]) ? $_SESSION["Winkelmandje"] : [];

    $aggregatedWinkelmandje = [];
    foreach ($winkelmandje as $item) {
        if (!isset($item['quantity'])) {
            $item['quantity'] = 1;
        }

        if (isset($aggregatedWinkelmandje[$item['name']])) {
            $aggregatedWinkelmandje[$item['name']]['quantity'] += $item['quantity'];
        } else {
            $aggregatedWinkelmandje[$item['name']] = $item;
        }
    }

    $sql = "INSERT INTO Pizza_Order (client_username, client_name, personnel_username, datetime, status, address) VALUES (:client_username, :client_name, :personnel_username, :datetime, :status, :address)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':client_username' => $client_username,
        ':client_name' => $client_name,
        ':personnel_username' => $personnel_username,
        ':datetime' => $datetime,
        ':status' => $status,
        ':address' => $address
    ]);

    $order_id = $db->lastInsertId();

    $batchSize = 500; // Adjust batch size as needed
    $batch = [];
    foreach ($aggregatedWinkelmandje as $item) {
        // Check if product exists in the Product table
        $sql = "SELECT COUNT(*) FROM [Product] WHERE name = :name";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $item['name']]);
        $product_exists = $stmt->fetchColumn();

        if ($product_exists == 0) {
            die("Error: Product " . $item['name'] . " does not exist in the Product table.");
        }

        $batch[] = [
            ':order_id' => $order_id,
            ':name' => $item['name'],
            ':quantity' => $item['quantity']
        ];

        if (count($batch) >= $batchSize) {
            insertBatch($db, $batch);
            $batch = [];
        }
    }

    if (!empty($batch)) {
        insertBatch($db, $batch);
    }
    session_destroy();
    header("Location: index.php");
    exit();
}

function insertBatch($db, $batch) {
    $sql = "INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) VALUES ";
    $values = [];
    $params = [];
    foreach ($batch as $index => $item) {
        $values[] = "(:order_id{$index}, :name{$index}, :quantity{$index})";
        $params[":order_id{$index}"] = $item[':order_id'];
        $params[":name{$index}"] = $item[':name'];
        $params[":quantity{$index}"] = $item[':quantity'];
    }
    $sql .= implode(", ", $values);
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
}


?>

<?php echo renderHeader(); ?>

<h3>Enter Your Address</h3>
<form method="post" action="gegevens.php">
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required><br><br>

    <button type="submit">Submit</button>
</form>
</body>
</html>