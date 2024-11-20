<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");  // Redirect to login if not logged in or not admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
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
        .nav-link {
            color: #b3b3b3 !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: white !important;
        }
        .btn-login {
            background-color: transparent;
            color: white;
            border: 1px solid white;
        }
        .btn-login:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .btn-signup {
            background-color: #3498db;
            color: white;
        }
        .btn-signup:hover {
            background-color: #2980b9;
        }
        @media (max-width: 991px) {
            .navbar-nav, .navbar-nav .nav-item {
                margin-top: 0.5rem;
            }
            .navbar-nav .btn {
                display: block;
                width: 100%;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="admin.php">
            <img src="logocsu.png" alt="CSU Logo" style="height: 40px; margin-right: 10px;">
           SUPPLY OFFICE TRANSACTION MONITORING SYSTEM
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item">
                    
                            <a class="nav-link active" aria-current="page" href="admin.php">
                                <i class="bi bi-house-door"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pullout.php">
                                <i class="bi bi-list-check"></i> Pullout List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add.php">
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

    <div class="container-fluid">

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Welcome to Admin Dashboard</h1>
                </div>
            </main>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
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
