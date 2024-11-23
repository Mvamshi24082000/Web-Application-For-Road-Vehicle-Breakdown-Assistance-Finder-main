<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../adminsignlogin.php");
    exit();
}
$host ="localhost";
$username = "root";
$password = "";
$database = "breakdown_assistance";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operation = $_POST["operation"];

    // Your database connection code...

    if ($operation == "insert") {
        $service_name = $_POST['service_name'];
        $service_description = $_POST['service_description'];

        $sql = "INSERT INTO services (service_name, service_description) VALUES (:service_name, :service_description)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':service_name', $service_name);
        $stmt->bindParam(':service_description', $service_description);

        if ($stmt->execute()) {
            echo '<script>alert("Record inserted successfully!");</script>';
        } else {
            echo '<script>alert("Error inserting record.");</script>';
        }
    } elseif ($operation == "update") {
        $service_id = $_POST['service_id'];
        $service_name = $_POST['service_name'];
        $service_description = $_POST['service_description'];

        $sql = "UPDATE services SET service_name = :service_name, service_description = :service_description WHERE service_id = :service_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':service_name', $service_name);
        $stmt->bindParam(':service_description', $service_description);
        $stmt->bindParam(':service_id', $service_id);

        if ($stmt->execute()) {
            echo '<script>alert("Record updated successfully!");</script>';
        } else {
            echo '<script>alert("Error updating record.");</script>';
        }
    } elseif ($operation == "delete") {
        $service_id = $_POST['service_id'];

        $sql = "DELETE FROM services WHERE service_id = :service_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':service_id', $service_id);

        if ($stmt->execute()) {
            echo '<script>alert("Record deleted successfully!");</script>';
        } else {
            echo '<script>alert("Error deleting record.");</script>';
        }
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
    <style>
        /* Light mode styles */
.table1 {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table1 th, .table1 td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.table1 th {
    background-color: #f2f2f2;
}

.table1 tbody {
    height: 200px; /* Set the desired height for the table body */
    overflow-y: auto;
}

/* Optional: Add a hover effect for rows */
.table1 tbody tr:hover {
    background-color: #f5f5f5;
}

/* Dark mode styles */
.dark .table1 {
    background-color: #333;
    color: #fff;
}

.dark .table1 th, .dark .table1 td {
    border-color: #555;
}

.dark .table1 th {
    background-color: #444;
}

.dark .table1 tbody tr:hover {
    background-color: #555;
}


   /* Light mode styles */
.combined {
    width: 300px;
    margin: 20px auto;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    transition: background-color 0.3s ease;
}

.combined label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.combined select,
.combined input[type="text"],
.combined input[type="submit"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.combined select {
    height: 34px; /* Match the height of input elements for consistency */
}

.combined input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
}

.combined input[type="submit"]:hover {
    background-color: #45a049;
}

/* Optional: Add styling for form elements on focus */
.combined input:focus,
.combined select:focus {
    outline: none;
    border-color: #2196F3;
    box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
}

/* Dark mode styles */
.dark .combined {
    background-color: #333;
    color: #fff;
}

.dark .combined label {
    color: #fff;
}

.dark .combined select,
.dark .combined input[type="text"],
.dark .combined input[type="submit"] {
    border-color: #555;
    background-color: #444;
    color: #fff;
}

.dark .combined input[type="submit"]:hover {
    background-color: #3d8b40;
}
/* Apply a bit of styling to the form container */
.form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Style labels for better readability */
.form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

/* Style select boxes for consistency */
.form select {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Style the button for a more prominent look */
.form button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Add a bit of hover effect to the button */
.form button:hover {
    background-color: #0056b3;
}

    </style>


	<title>Admin</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Admin</span>
		</a>
		<ul class="side-menu top">
            <li>
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="map.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Map view</span>
				</a>
			</li>
			<li>
				<a href="mechanic.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Mechanic</span>
				</a>
			</li>
			<li class="active">
				<a href="servicelist.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Service</span>
				</a>
			</li>
			<li>
				<a href="shop.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Home Shop</span>
				</a>
			</li>
            <li>
				<a href="chat.php">
					<i class='bx bxs-chat' ></i>
					<span class="text">ChatBot message</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="profile/index.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form id="searchForm">
			<div class="form-input">
				<input type="search" placeholder="Search..." list="searchOptions" id="searchInput">
				<datalist id="searchOptions">
					<option value="Dashboard">
					<option value="Map view">
					<option value="Mechanic">
					<option value="Service">
					<option value="Home Shop">
					<!-- Add more options as needed -->
				</datalist>
				<button onclick="redirectBasedOnSearch()" class="search-btn"><i class='bx bx-search'></i></button>
			</div>
		</form>

		<script>
			function redirectBasedOnSearch() {
				var searchInput = document.getElementById("searchInput").value.toLowerCase();

				// Define your links based on the search input
				switch (searchInput) {
					case "dashboard":
						document.getElementById("searchForm").action = "index.php";
						break;
					case "map view":
						document.getElementById("searchForm").action = "map.php";
						break;
					case "mechanic":
						document.getElementById("searchForm").action = "mechanic.php";
						break;
					case "service":
						document.getElementById("searchForm").action = "servicelist.php";
						break;
					case "home shop":
						document.getElementById("searchForm").action = "shop.php";
						break;
					default:
						// Handle default case or display an error message
						alert("Invalid search option");
						return false; // Prevent form submission
				}

				// Continue with form submission
				document.getElementById("searchForm").submit();
			}
		</script>

			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
            <a href="index.php" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">
					<?php
					// Use htmlspecialchars to properly escape user input
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "breakdown_assistance";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

					$sql_count = "SELECT COUNT(*) as total FROM locations ";
					$result_count = $conn->query($sql_count);

					if ($result_count) {
						$row = $result_count->fetch_assoc(); // Fetch the result as an associative array
						$total = $row['total']; // Extract the count value
						echo "<span class='text'><h3>$total</h3></span>";
					} else {
						echo "Error: " . $conn->error; // Handle the query error if any
					}
					?>
				</span>
			</a>
			<a href="profile/index.php" class="profile">
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>service List</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Service list</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>

      

<table class="table1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
    </tr>

    <?php
    // Retrieve and display mechanics data (replace with your database query)
    $conn = new mysqli("localhost", "root", "", "breakdown_assistance");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["service_id"] . "</td>";
            echo "<td>" . $row["service_name"] . "</td>";
            echo "<td>" . $row["service_description"] . "</td>";
           

            echo "</tr>";
            
        }
    } else {
        echo "<tr><td colspan='5'>No services found.</td></tr>";
    }

    $conn->close();
    ?>
</table>
<form class="combined" method="post">
    <label for="operation">Select Operation:</label>
    <select name="operation" id="operation" required>
        <option value="insert">Insert</option>
        <option value="update">Update</option>
        <option value="delete">Delete</option>
    </select>

    <p>Record Details</p>

    <input type="text" name="service_id" value="ID" required><br>
    <input type="text" name="service_name" value="Name" required><br>
    <input type="text" name="service_description" value="Description" required><br>
    
    <input type="submit" name="submit" value="Submit">
</form>




		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>