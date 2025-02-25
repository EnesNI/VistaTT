<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Check if the user ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the user data
    $stmt = $conn->prepare("SELECT id, firstname, lastname, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user ID provided.";
    exit();
}

// Handle form submission for updating user info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $firstname, $lastname, $email, $id);
    $stmt->execute();
    $stmt->close();

    echo "User updated successfully! <a href='users.admin.php'>Go back</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit User</h1>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>

            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <button type="submit">Update User</button>
        </form>
        <a href="users.admin.php">Cancel</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
