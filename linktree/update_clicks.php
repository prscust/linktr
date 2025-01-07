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

// Periksa jika ada request POST dari AJAX
if (isset($_POST['linkName'])) {
    $linkName = $_POST['linkName'];

    // Cek apakah link sudah ada di database
    $stmt = $pdo->prepare("SELECT * FROM link_clicks WHERE link_name = ?");
    $stmt->execute([$linkName]);
    $link = $stmt->fetch();

    if ($link) {
        // Jika sudah ada, update jumlah klik
        $stmt = $pdo->prepare("UPDATE link_clicks SET click_count = click_count + 1 WHERE link_name = ?");
        $stmt->execute([$linkName]);
    } else {
        // Jika belum ada, tambahkan entri baru
        $stmt = $pdo->prepare("INSERT INTO link_clicks (link_name, click_count) VALUES (?, 1)");
        $stmt->execute([$linkName]);
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No linkName provided']);
}
?>
