<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle admin promotion
if (isset($_GET['make_admin'])) {
    $id = $_GET['make_admin'];
    $stmt = $conn->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$search = $_GET['search'] ?? '';

// Fetch users
$stmt = $conn->prepare("SELECT id, firstname, lastname, email, is_admin FROM users WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ?");
$search_param = "%$search%";
$stmt->bind_param("sss", $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="users-admin.css">
</head>
<body> <a href="logout.php" style="float: right; color: red; text-decoration: none;">Logout</a> <!-- Logout button -->
<a href="admin.php"   style="float: right; color: blue; text-decoration: none;">Offers</a>
<a href="dashboard.php"   style="float: right; color: blue; text-decoration: none;">Dashboard</a>
    <div class="admin-container">
        <h1>Manage Users</h1> 
        <form method="GET">
            <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['is_admin'] ? 'Admin' : 'User'; ?></td>
                    <td>
                        <a href="users.admin.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        <?php if (!$user['is_admin']): ?>
                            <a href="users.admin.php?make_admin=<?php echo $user['id']; ?>">Make Admin</a>
                        <?php endif; ?>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>

