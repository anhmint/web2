<?php
include 'config.php'; // kết nối DB

$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

$sql = "SELECT c.id, c.name, SUM(o.total_price) AS total_spent
        FROM customers c
        JOIN orders o ON c.id = o.customer_id
        WHERE o.order_date BETWEEN ? AND ?
        GROUP BY c.id
        ORDER BY total_spent DESC
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$topCustomers = [];
while ($row = $result->fetch_assoc()) {
    $topCustomers[] = $row;
}
echo json_encode($topCustomers);
?>
