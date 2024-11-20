<?php
session_start();
require_once 'db.php'; // Include the database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");  // Redirect to login if not logged in or not admin
    exit();
}

// Fetch the data from the database
$sql = "SELECT * FROM supply WHERE status != 'pulled out'"; // Fetch records that are not pulled out
$result = $conn->query($sql);
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

    <div class="container mt-5 pt-5">
        <h2 class="mb-4">Dashboard</h2>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fund Cluster</th>
                    <th>Serial Number</th>
                    <th>PO Number</th>
                    <th>Supplier</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Target Delivery Date</th>
                    <th>Office</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['fundCluster']); ?></td>
                            <td><?php echo htmlspecialchars($row['serialNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['poNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['supplierName']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo "$" . number_format($row['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['targetDeliveryDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['office']); ?></td>
                            <td>
                                <!-- Form to mark item as pulled out -->
                                <form method="POST" action="pulloutitem.php" style="display:inline;">
                                    <input type="hidden" name="serialNumber" value="<?php echo htmlspecialchars($row['serialNumber']); ?>">
                                    <button type="submit" name="pullout" class="btn btn-success btn-sm">Pullout</button>
                                </form>

                                <!-- Form to delete item -->
                                <form method="POST" action="deleteitem.php" style="display:inline;">
                                    <input type="hidden" name="serialNumber" value="<?php echo htmlspecialchars($row['serialNumber']); ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
