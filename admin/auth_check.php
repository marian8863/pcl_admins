
<?php

require_once '../config.php';

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}



// Page must define $required_menu_name before including this
if (!isset($required_menu_name)) {
    die("Authentication check error: No menu name defined.");
}

// Get the menu_id for this menu name
$menu_sql = "SELECT id FROM menus WHERE `url` = ?";
$menu_stmt = $con->prepare($menu_sql);
if (!$menu_stmt) {
    die("Prepare failed: " . $con->error);
}
$menu_stmt->bind_param("s", $required_menu_name);
$menu_stmt->execute();
$menu_result = $menu_stmt->get_result();

if ($menu_result->num_rows === 0) {
    die("Menu not found: " . htmlspecialchars($required_menu_name));
}

$menu_id = $menu_result->fetch_assoc()['id'];
$menu_stmt->close();

// Check if user has access to this menu
$access_sql = "SELECT menu_id FROM user_menu_access WHERE user_id = ? AND menu_id = ?";
$access_stmt = $con->prepare($access_sql);
if (!$access_stmt) {
    die("Prepare failed: " . $con->error);
}
$access_stmt->bind_param("ii", $u_id, $menu_id);
$access_stmt->execute();
$access_result = $access_stmt->get_result();

if ($access_result->num_rows === 0) {
     include 'access_denied.php'; 
    exit();
}
$access_stmt->close();
?>
