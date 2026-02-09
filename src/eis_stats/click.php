<?php
// --------------------
// Database config
// --------------------
$host = "localhost";
$dbname = "eis";
$user = "pn";
$pass = "4321";

// --------------------
// Check parameter
// --------------------
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid link");
}

$linkname = $_GET['id'];

try {
    // --------------------
    // Connect DB (PDO)
    // --------------------
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // --------------------
    // Get link data
    // --------------------
    $stmt = $pdo->prepare(
        "SELECT linkurl FROM eis_stats WHERE linkname = :linkname LIMIT 1"
    );
    $stmt->execute(['linkname' => $linkname]);
    $row = $stmt->fetch();

    if (!$row) {
        die("Link not found");
    }

    // --------------------
    // Update click count
    // --------------------
    $update = $pdo->prepare(
        "UPDATE eis_stats 
         SET linkcount = linkcount + 1 
         WHERE linkname = :linkname"
    );
    $update->execute(['linkname' => $linkname]);

    // --------------------
    // Redirect
    // --------------------
    header("Location: " . $row['linkurl']);
    exit;

} catch (PDOException $e) {
    die("Database error");
}
?>