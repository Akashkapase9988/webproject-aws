<?php
include 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Fetch word population data
$sql = "SELECT word, population_count, language, region FROM word_population ORDER BY population_count DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Word Population System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <div class="dashboard-content">
            <h3>Word Population Data</h3>
            
            <?php if (count($words) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Word</th>
                                <th>Population Count</th>
                                <th>Language</th>
                                <th>Region</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($words as $word): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($word['word']); ?></td>
                                    <td><?php echo number_format($word['population_count']); ?></td>
                                    <td><?php echo htmlspecialchars($word['language']); ?></td>
                                    <td><?php echo htmlspecialchars($word['region']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No word population data found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>