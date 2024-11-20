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
        margin-top: 60px; /* Adjust for fixed navbar */
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

    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        font-size: 1rem;
        font-weight: bold;
        color: #555;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-sizing: border-box;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    input:focus, select:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #2980b9;
        cursor: pointer;
    }

    /* Responsive design */
    @media (max-width: 767px) {
        .form-container {
            padding: 20px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        button {
            font-size: 1rem;
            padding: 10px;
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
                        <a class="nav-link" href="admin.php">
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
                        <a class="nav-link active" href="add.php">
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

    <div class="container">
    <div class="form-container">
        <h2>Supply Information</h2>
        <form id="addItemForm" action="submit_add.php" method="POST">
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="fundCluster">Fund Cluster</label>
                    <input type="text" id="fundCluster" name="fundCluster" required class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="serialNumber">Serial Number</label>
                    <input type="text" id="serialNumber" name="serialNumber" required class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="supplierName">Supplier Name</label>
                    <input type="text" id="supplierName" name="supplierName" required class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" required class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" required class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="targetDeliveryDate">Target Delivery Date</label>
                    <input type="date" id="targetDeliveryDate" name="targetDeliveryDate" required class="form-control">
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-md-6 form-group">
                    <label for="PoNumber">PO Number</label>
                    <input type="text" id="PoNumber" name="PoNumber" required class="form-control">
                </div>
                <div class="col-md-6 form-group">
                    <label for="office">Office</label>
                    <select id="office" name="office" required class="form-control">
                        <option value="">Select Office</option>
                        <option value="Admin Office">Admin Office</option>
                        <option value="Finance Office">Finance Office</option>
                        <option value="IT Office">IT Office</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-50 d-flex justify-content-center mx-auto">Submit</button>

        </form>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const logoutBtn = document.getElementById('logoutBtn');

        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            // Send the user to a PHP script to log out
            window.location.href = "logout.php";  // This will log the user out
        });

        // Add form submission handling (you can modify the backend PHP script to process the form)
        const addItemForm = document.getElementById('addItemForm');
        addItemForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(addItemForm);
            fetch('submit_add.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert('Item added successfully!');
                      addItemForm.reset();
                  } else {
                      alert('Error adding item.');
                  }
              })
              .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
