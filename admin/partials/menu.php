<?php 
       include('../config/constants.php');
        include('login-check.php');
?>


<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <!----Menu section starts------>
        <div class="menu">
            <div class="wrapper">
                <div class="brand">
                    <span class="brand-mark">R</span>
                    <div>
                        <strong>Restaurant Admin</strong>
                        <small>Control Panel</small>
                    </div>
                </div>

                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="view-contact.php">Contact</a></li>
                    <li><a href="logout.php" class="logout-link">Logout</a></li>
                </ul>

                <div class="header-clock" aria-live="polite">
                    <span id="admin-date">Loading...</span>
                    <strong id="admin-time">--:--:--</strong>
                </div>
            </div>
        </div>

        <script>
            function updateAdminClock() {
                const now = new Date();
                const dateText = now.toLocaleDateString([], { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
                const timeText = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

                const dateEl = document.getElementById('admin-date');
                const timeEl = document.getElementById('admin-time');

                if (dateEl) dateEl.textContent = dateText;
                if (timeEl) timeEl.textContent = timeText;
            }

            updateAdminClock();
            setInterval(updateAdminClock, 1000);
        </script>
        <!------Menu section ends-->