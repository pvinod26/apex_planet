<?php
include "db.php";
$res = $conn->query("SELECT * FROM candidates ORDER BY votes DESC");
$total_votes = $conn->query("SELECT SUM(votes) as total FROM candidates")->fetch_assoc()['total'] ?: 1;
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h2>Live Results</h2>
        <?php while($row = $res->fetch_assoc()){ 
            $percent = round(($row['votes'] / $total_votes) * 100);
        ?>
            <div style="margin: 20px 0; text-align: left;">
                <div style="display:flex; justify-content:space-between">
                    <span><?= $row['name'] ?></span>
                    <span><?= $row['votes'] ?> votes</span>
                </div>
                <div style="background:#334155; height:8px; border-radius:10px; margin-top:5px;">
                    <div style="background:var(--primary); height:100%; width:<?= $percent ?>%; border-radius:10px;"></div>
                </div>
            </div>
        <?php } ?>
        <a href="logout.php"><button style="background:#ef4444">Logout</button></a>
    </div>
</body>
</html>