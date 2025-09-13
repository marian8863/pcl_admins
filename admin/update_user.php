<?php
include '../config.php';

// if ($_SESSION['user']['user_type'] == 'admin' || $_SESSION['user']['user_type'] == 'ADM') {
//     die("Access denied");
// }

if (isset($_POST['update_user'])) {
    $id        = intval($_POST['user_id']);
    $username  = mysqli_real_escape_string($con, $_POST['username']);
    $email     = mysqli_real_escape_string($con, $_POST['email']);
    $phone     = mysqli_real_escape_string($con, $_POST['phone']);
    $user_type = mysqli_real_escape_string($con, $_POST['user_type']);
    $user_desc = mysqli_real_escape_string($con, $_POST['user_desc']);

    // Handle password change
    $update_password_sql = "";
    if (!empty($_POST['new_password'])) {
        $new_password = md5($_POST['new_password']); // ⚠️ In production use password_hash()
        $update_password_sql = ", password='$new_password'";
    }

    // Handle profile image upload
    $update_profile_sql = "";
    if (!empty($_FILES['profile']['name'])) {
        $targetDir = "uploads/";
        $fileName  = time() . "_" . basename($_FILES["profile"]["name"]); // unique name
        $targetFile = $targetDir . $fileName;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
                // Get current profile filename from DB
                $res = mysqli_query($con, "SELECT profile FROM users WHERE id=$id");
                if ($res && $row = mysqli_fetch_assoc($res)) {
                    $oldFile = $row['profile'];
                    if (!empty($oldFile) && $oldFile !== "default.png" && file_exists($targetDir . $oldFile)) {
                        unlink($targetDir . $oldFile); // delete old file
                    }
                }
                $update_profile_sql = ", profile='$fileName'";
            } else {
                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                       icon: "error",
                       title: "Upload Failed",
                       text: "There was a problem uploading the profile image."
                    }).then(function() {
                       window.history.back();
                    });
                });
                </script>';
                exit;
            }
        } else {
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                   icon: "error",
                   title: "Invalid File Type",
                   text: "Only JPG, PNG, and GIF files are allowed."
                }).then(function() {
                   window.history.back();
                });
            });
            </script>';
            exit;
        }
    }

    // Final update query
    $query = "UPDATE users SET 
                username='$username',
                email='$email',
                phone='$phone',
                user_type='$user_type',
                user_desc='$user_desc'
                $update_password_sql
                $update_profile_sql
              WHERE id=$id";

    // Show loading spinner before query
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Please wait...",
            text: "Updating user profile",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
    </script>
    ';

    if (mysqli_query($con, $query)) {
        echo '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
               position: "top-end",
               icon: "success",
               title: "User has been updated successfully",
               showConfirmButton: false,
               timer: 1500
            }).then(function() {
               window.location.href = "view_authorizers";
            });
        });
        </script>';
    } else {
        echo '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
               icon: "error",
               title: "Update Failed",
               text: "'.mysqli_error($con).'"
            }).then(function() {
               window.history.back();
            });
        });
        </script>';
    }
}
?>
