<?php 

require('connection.php');
// Include your database connection code here (e.g., $conn)

// Initialize variables to store user information
$name = '';
$email = '';
$phone = '';
$address = '';

if (isset($_GET["id"])) {
    $userId = $_GET["id"];

    // Fetch the user's information from the database
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $address = $row['address'];
    } else {
        // Handle the case where the user with the given id is not found
        echo "User not found.";
        exit;
    }
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update the user's information in the database
    $sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to the user's profile page or any other appropriate page after successful update
        header("Location: student_report.php");
        exit;
    } else {
        // Handle the case where the update query fails
        echo "Update failed: " . mysqli_error($conn);
    }
}

?>
<?php require('header.php'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Edit Your Details</h3>
                </div>
                <div class="card-body">
                    <form action="update.php?id=<?= $userId ?>" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" value="<?= $name ?>" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" value="<?= $email ?>" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" value="<?= $phone ?>" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= $address ?></textarea>
                        </div>
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('footer.php') ?>
