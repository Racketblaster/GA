<?php
header('Content-Type: application/json; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "";
$database = "remmacs_tech";
$conn = mysqli_connect($servername, $username, $password, $database);

$sql = "";


if (!empty($_GET["productId"])) {
    $sql = "SELECT * FROM `products` WHERE id=" . $_GET["productId"] . ";";
    $result = $conn->query($sql);

    if (($result->num_rows) > 0) {
        while ($row = $result->fetch_assoc()) {
            $product = $row;
            $product['id'] = intval($row["id"]);
            $product['quantity'] = intval($row["quantity"]);
            $product['price'] = doubleval($row["price"]);
        }
    }
    echo json_encode($product);
} elseif (!empty($_GET["searchTerm"])) {
    $sql = "SELECT * FROM `products` WHERE name LIKE '%" . $_GET["searchTerm"] . "%' LIMIT 5;";
    $result = $conn->query($sql);

    $products = [];
    #echo "Num rows: ". $result->num_rows;
    $index = 0;
    if (($result->num_rows) > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[$index] = $row;
            $products[$index]['id'] = intval($row["id"]);
            $products[$index]['quantity'] = intval($row["quantity"]);
            $products[$index]['price'] = doubleval($row["price"]);
            $index++;
        }
    }
    echo json_encode($products);
} else {
    $sql = "SELECT * FROM `products`;";
    $result = $conn->query($sql);

    $products = [];
    #echo "Num rows: ". $result->num_rows;
    if (($result->num_rows) > 0) {
        $index = 0;
        while ($row = $result->fetch_assoc()) {
            $products[$index] = $row;
            $products[$index]['id'] = intval($row["id"]);
            $products[$index]['quantity'] = intval($row["quantity"]);
            $products[$index]['price'] = doubleval($row["price"]);
            $index++;
        }
    }
    echo json_encode($products);
}

$conn->close();
