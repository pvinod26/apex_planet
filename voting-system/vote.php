<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) header("Location: login.php");

$uid = $_SESSION['user_id'];
$user_stmt = $conn->prepare("SELECT has_voted FROM users WHERE id = ?");
$user_stmt->bind_param("i", $uid);
$user_stmt->execute();
$user_data = $user_stmt->get_result()->fetch_assoc();

if($user_data['has_voted']) header("Location: result.php");

if(isset($_POST['cast_vote'])){
    $cid = $_POST['candidate'];
    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
        $stmt1->bind_param("i", $cid);
        $stmt1->execute();

        $stmt2 = $conn->prepare("UPDATE users SET has_voted = 1 WHERE id = ?");
        $stmt2->bind_param("i", $uid);
        $stmt2->execute();

        $conn->commit();
        header("Location: result.php");
    } catch (Exception $e) { $conn->rollback(); }
}
$candidates = $conn->query("SELECT * FROM candidates");
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h2>Cast Your Vote</h2>
        <form method="POST">
            <?php while($row = $candidates->fetch_assoc()){ ?>
                <label class="candidate-card">
                    <input type="radio" name="candidate" value="<?= $row['id'] ?>" required>
                    <?= $row['name'] ?>
                </label>
            <?php } ?>
            <button name="cast_vote">Submit Vote</button>
        </form>
    </div>
</body>
</html>