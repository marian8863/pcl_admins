<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $selected_menus = isset($_POST['menus']) ? $_POST['menus'] : [];

    if ($user_id > 0) {
        // Delete old access
        $con->query("DELETE FROM user_menu_access WHERE user_id = $user_id");

        // Insert new access
        foreach ($selected_menus as $menu_id) {
            $menu_id = intval($menu_id);
            $con->query("INSERT INTO user_menu_access (user_id, menu_id) VALUES ($user_id, $menu_id)");
        }

        // Show SweetAlert2 success popup and redirect
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
               position: "top-end",
               icon: "success",
               title: "User access updated successfully",
               showConfirmButton: false,
               timer: 1500
            }).then(function() {
               window.location.href = "view_authorizers";
            });
        });
        </script>';
        exit();
    } else {
        echo "Invalid user ID.";
    }
}
?>
