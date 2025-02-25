<?php
session_start(); // Start session to manage user authentication

include("config.php"); // Include database connection


// Redirect user to login page if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"]; // Get logged-in user ID

// Fetch unpaid bills for the user
$query = "SELECT bill_id, amount, due_date FROM bills WHERE user_id = ? AND status = 'Pending' ORDER BY due_date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include("header.php"); ?> <!-- Include header -->
<link rel="stylesheet" href="css/payment.css"> <!-- Link to payment CSS -->

<div class="payment-container">
    <h2>Make a Payment</h2>

    <!-- Display unpaid bills -->
    <form id="payment-form" action="process_payment.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Amount ($)</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["bill_id"]); ?></td>
                        <td><?php echo number_format($row["amount"], 2); ?></td>
                        <td><?php echo date("F j, Y", strtotime($row["due_date"])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>

</div>

<?php include("footer.php"); ?> <!-- Include footer -->
<script src="js/payment.js"></script> <!-- Link to JavaScript file -->