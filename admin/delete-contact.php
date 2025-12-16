<?php
include('partials/menu.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Delete message from database
    $sql = "DELETE FROM tbl_contact WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if($res){
        $_SESSION['delete'] = "<div class='success'>Message deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete message.</div>";
    }

    header("location:".SITEURL."admin/view-contact.php");
} else {
    header("location:".SITEURL."admin/view-contact.php");
}
?>
