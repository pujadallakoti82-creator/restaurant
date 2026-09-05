<?php 
    //include constants page
    include('../config/constants.php');

    if(isset($_GET['id']))
    {
        //process to delete
        //1. get id
        $id = $_GET['id'];

        //2. delete order from database
        $sql = "DELETE FROM tbl_order WHERE id=$id";
        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query executed or not and set the session message respectively
        if($res==true)
        {
            //order deleted
            $_SESSION['delete'] = "<div class='success'>Order Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-order.php');
            exit();
        }
        else
        {
            //failed to delete order
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Order.</div>";
            header('location:'.SITEURL.'admin/manage-order.php');
            exit();
        }
    }
    else
    {
        //redirect to manage order if id is not set
        header('location:'.SITEURL.'admin/manage-order.php');
        exit();
    }
?>
