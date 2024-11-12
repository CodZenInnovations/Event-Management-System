<?php
session_start();
error_reporting(E_ALL); // Enable error reporting for debugging
include('includes/dbconnection.php');

if (strlen($_SESSION['odmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['submit'])) {
    $eid = $_GET['editid'];
    $bookingid = $_GET['bookingid'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    $sql = "UPDATE tblbooking SET Status = :status, Remark = :remark WHERE ID = :eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':remark', $remark, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Remark has been updated")</script>';
    echo "<script>window.location.href ='all-booking.php'</script>";
}

$eid = $_GET['editid'];

if (!isset($eid) || empty($eid)) {
    echo "Error: No booking ID specified.";
    exit;
}

$sql = "SELECT tbluser.FullName, tbluser.MobileNumber, tbluser.Email, tblbooking.BookingID, tblbooking.BookingDate, tblbooking.BookingFrom, tblbooking.EventType, tblbooking.Numberofguest, tblbooking.Message, tblbooking.Remark, tblbooking.Status, tblbooking.UpdationDate, tblservice.ServiceName, tblservice.SerDes 
        FROM tblbooking 
        JOIN tblservice ON tblbooking.ServiceID = tblservice.ID 
        JOIN tbluser ON tbluser.ID = tblbooking.UserID 
        WHERE tblbooking.ID = :eid";

$query = $dbh->prepare($sql);
$query->bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();

if ($query->rowCount() == 0) {
    echo "No booking details found.";
    exit;
}

$result = $query->fetch(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Online Event Management System - View Booking</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>

        <!-- Main Container -->
        <main id="main-container">
            <div class="content">
                <h2 class="content-heading">View Booking</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="block block-themed">
                            <div class="block-header bg-gd-emerald">
                                <h3 class="block-title">View Booking</h3>
                            </div>
                            <div class="block-content">
                                <table border="1" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                    <tr>
                                        <th colspan="5" style="text-align: center;font-size: 20px;color: blue;">Booking Number: <?php echo $result->BookingID; ?></th>
                                    </tr>
                                    <tr>
                                        <th>Client Name</th>
                                        <td><?php echo $result->FullName; ?></td>
                                        <th>Mobile Number</th>
                                        <td><?php echo $result->MobileNumber; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo $result->Email; ?></td>
                                        <th>Booking From</th>
                                        <td><?php echo $result->BookingFrom; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Number of Guests</th>
                                        <td><?php echo $result->Numberofguest; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Event Type</th>
                                        <td><?php echo $result->EventType; ?></td>
                                        <th>Message</th>
                                        <td><?php echo $result->Message; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Event Name</th>
                                        <td><?php echo $result->ServiceName; ?></td>
                                        <th>Event Description</th>
                                        <td><?php echo $result->SerDes; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Apply Date</th>
                                        <td><?php echo $result->BookingDate; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order Final Status</th>
                                        <td class="font-w600">
                                            <?php if ($result->Status == ''): ?>
                                                <span class="badge badge-warning">Not Processed Yet</span>
                                            <?php elseif ($result->Status == 'Approved'): ?>
                                                <span class="badge badge-success"><?php echo $result->Status; ?></span>
                                            <?php elseif ($result->Status == 'Cancelled'): ?>
                                                <span class="badge badge-danger"><?php echo $result->Status; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <th>Admin Remark</th>
                                        <td><?php echo $result->Remark ? htmlentities($result->Remark) : "Not Updated Yet"; ?></td>
                                    </tr>
                                </table>

                                <?php if ($result->Status == ''): ?>
                                    <p align="center" style="padding-top: 20px">
                                        <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Take Action</button>
                                    </p>
                                <?php endif; ?>

                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" name="submit">
                                                    <table class="table table-bordered table-hover data-tables">
                                                        <tr>
                                                            <th>Remark:</th>
                                                            <td>
                                                                <textarea name="remark" placeholder="Remark" rows="4" cols="30" class="form-control wd-450" required="true"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status:</th>
                                                            <td>
                                                                <select name="status" class="form-control wd-450" required="true">
                                                                    <option value="Approved" selected="true">Approved</option>
                                                                    <option value="Cancelled">Cancelled</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        <?php include_once('includes/footer.php'); ?>
    </div>
    <!-- END Page Container -->

    <!-- Codebase Core JS -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="assets/js/core/jquery.appear.min.js"></script>
    <script src="assets/js/core/jquery.countTo.min.js"></script>
    <script src="assets/js/core/js.cookie.min.js"></script>
    <script src="assets/js/codebase.js"></script>
</body>
</html>
