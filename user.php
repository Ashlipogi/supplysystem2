<?php
session_start();

// Check if the user is logged in and is a user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");  // Redirect to login if not logged in or not user
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 3.5rem;
            background-color: #f8f9fa;
            z-index: 100;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .navbar {
            background-color: #343a40;
            padding: 1rem;
        }
        .navbar-brand {
        color: white;
        font-size: 1rem;
        font-weight: bold;
        transition: font-size 0.3s ease, color 0.3s ease;
    }
        .content {
            margin-left: 240px;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: static;
                height: auto;
                padding-top: 0;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="user.php">
            <img src="logocsu.png" alt="CSU Logo" style="height: 40px; margin-right: 10px;">
           SUPPLY OFFICE TRANSACTION MONITORING SYSTEM
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item">
                            <a class="nav-link active" href="user.php">
                                <i class="bi bi-house-door"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="dashboarduser.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pulloutuser.php">
                            <i class="bi bi-list-check"></i> Pullout List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adduser.php">
                            <i class="bi bi-plus-circle"></i> Add
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php" id="logoutBtn">Logout</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
   


   

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const logoutBtn = document.getElementById('logoutBtn');
        const addItemForm = document.getElementById('addItemForm');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.navbar')) {
                navLinks.classList.remove('active');
            }
        });

        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            // Send the user to a PHP script to log out
            window.location.href = "logout.php";  // This will log the user out
        });

        addItemForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const itemName = document.getElementById('itemName').value;
            const itemDescription = document.getElementById('itemDescription').value;
            // Add item to the list or send to server
            console.log('New item:', { itemName, itemDescription });
            // Clear form
            addItemForm.reset();
        });
    </script>
</body>
</html>
