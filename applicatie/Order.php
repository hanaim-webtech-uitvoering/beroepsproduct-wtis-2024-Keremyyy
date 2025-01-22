<?php
require_once 'db_connectie.php';
session_start();
include 'header.php';

function isMedewerker() {
    if (isset($_SESSION["medewerker_ingelogd"]) && $_SESSION["medewerker_ingelogd"] == "ja") {
        return true;
    } else {
        return false;
    }
}

$db = maakVerbinding();

if (!isset($_SESSION["gebruiker_ingelogd"]) || $_SESSION["gebruiker_ingelogd"] != true) {
    header("Location: Inloggen.php");
    exit();
}

if (isMedewerker()) {
    $sql = "SELECT * FROM Pizza_Order";
    $data = $db->prepare($sql);
    $data->execute();
    $RESULT = $data->fetchAll();
} else {
    $sql = "SELECT * FROM Pizza_Order WHERE client_username = :username";
    $data = $db->prepare($sql);
    $data->execute(array(':username' => $_SESSION["username"]));
    $RESULT = $data->fetchAll();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"]) && isset($_POST["status"])) {
    $order_id = $_POST["order_id"];
    $status = (int)$_POST["status"];
    $update_sql = "UPDATE Pizza_Order SET status = :status WHERE order_id = :order_id";
    $update_data = $db->prepare($update_sql);
    $update_data->execute(array(':status' => $status, ':order_id' => $order_id));
    header("Location: Order.php");
    exit();
}

$statusMapping = [
    1 => 'Pending',
    2 => 'Processing',
    3 => 'Completed',
    4 => 'Cancelled'
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
</head>
<body>
<?php
echo renderHeader();
?>
<table>
    <tr>
        <th>order_id</th>
        <th>client_username</th>
        <th>client_name</th>
        <th>datetime</th>
        <th>address</th>
        <th>status</th>
        <th>change status</th>
    </tr>
    <?php if (!empty($RESULT)) : ?>
        <?php foreach ($RESULT as $row) : ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['client_username']; ?></td>
                <td><?php echo $row['client_name']; ?></td>
                <td><?php echo $row['datetime']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><span><?php echo $statusMapping[$row['status']]; ?></span></td>
                <td>
                    <?php if(isMedewerker()){ ?>
                        <form method="post" action="Order.php">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <select name="status">
                                <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Pending</option>
                                <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>>Processing</option>
                                <option value="3" <?php if ($row['status'] == 3) echo 'selected'; ?>>Completed</option>
                                <option value="4" <?php if ($row['status'] == 4) echo 'selected'; ?>>Cancelled</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <table>
                        <tr>
                            <th>product_name</th>
                            <th>quantity</th>
                        </tr>
                        <?php
                        $product_sql = "SELECT * FROM Pizza_Order_Product WHERE order_id = :order_id";
                        $product_data = $db->prepare($product_sql);
                        $product_data->execute(array(':order_id' => $row['order_id']));
                        $products = $product_data->fetchAll();
                        foreach ($products as $product) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($product['product_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['quantity']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
</body>
</html>