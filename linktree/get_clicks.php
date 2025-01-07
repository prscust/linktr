<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'db_click';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil jumlah klik dari database
$stmt = $pdo->prepare("SELECT link_name, click_count FROM link_clicks");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kembalikan data dalam format JSON
echo json_encode($results);
?>
