<?php
session_start();
include 'header.php';
if (!isset($_SESSION["gebruiker_ingelogd"]) || $_SESSION["gebruiker_ingelogd"] != true) {
    header("Location: Inloggen.php");
    exit();
}
$winkelmandje = isset($_SESSION["Winkelmandje"]) ? $_SESSION["Winkelmandje"] : [];

// Aggregate quantities of products with the same name
$aggregatedWinkelmandje = [];
foreach ($winkelmandje as $item) {
    // Ensure the quantity key exists
    if (!isset($item['quantity'])) {
        $item['quantity'] = 1; // Default quantity
    }

    if (isset($aggregatedWinkelmandje[$item['name']])) {
        $aggregatedWinkelmandje[$item['name']]['quantity'] += $item['quantity'];
    } else {
        $aggregatedWinkelmandje[$item['name']] = $item;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
</head>
<body>
<?php
echo renderHeader();
?>
<h3>Winkelmandje</h3>
<table>
    <tr>
        <th>Product</th>
        <th>Prijs</th>
        <th>Aantal</th>
    </tr>
    <?php if (!empty($aggregatedWinkelmandje)) : ?>
        <?php foreach ($aggregatedWinkelmandje as $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['price']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="3">Uw winkelmandje is leeg.</td>
        </tr>
    <?php endif; ?>
</table>

<?php if (!empty($aggregatedWinkelmandje)) : ?>
    <form method="post" action="gegevens.php">
        <button type="submit">Koop</button>
    </form>
<?php endif; ?>
</body>
</html>