<?php
require "includes/common.php";
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AlphaThreads | Online Shopping Site for Men</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include 'includes/header_menu.php';
?>
<div class="d-flex justify-content-center">
                <div class=" col-md-6  my-5 table-responsive p-5">
                    <table class="table table-striped table-bordered table-hover ">
                    <?php
$sum = 0;
$user_id = $_SESSION['user_id'];
$query = " SELECT DISTINCT order_id FROM users_products WHERE users_products.user_id='$user_id' and status='Confirmed'";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) >= 1) {
    ?>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item Names</th>
                                <th>Prices</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                                <?php
while ($row = mysqli_fetch_array($result)) {
    $order_id = $row["order_id"];
    $query1 = "SELECT up.item_id, p.name, p.price FROM users_products AS up JOIN products AS p ON up.item_id = p.id WHERE up.order_id = '$order_id'";
    $result1 = mysqli_query($con, $query1);
    $item_names = "";
    $item_prices = "";
    $total_price = 0;
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $item_names .= $row1['name'] . "<br>";
        $item_prices .= "Rs." . $row1['price'] . "<br>";
        $total_price += $row1['price'];
    }
    echo "<tr><td>" . "#" . $row["order_id"] . "</td><td>" . $item_names . "</td><td>Rs " . $item_prices . "\n" . "Total - Rs." . $total_price . "</td></tr>";
    }
    ?>
                            </tbody>
                            <?php
} else {
    echo "<div> <img src='images/emptycart.png' class='image-fluid' height='150' width='150'></div><br/>";
    echo "<div class='text-bold  h5'>No orders yet!<div>";

}
?>
                        <?php
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--footer -->
         <?php include 'includes/footer.php'?>
        <!--footer end-->

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
$(document).ready(function() {

if(window.location.href.indexOf('#login') != -1) {
  $('#login').modal('show');
}

});
</script>
<?php if (isset($_GET['error'])) {$z = $_GET['error'];
    echo "<script type='text/javascript'>
$(document).ready(function(){
$('#signup').modal('show');
});
</script>";
    echo "<script type='text/javascript'>alert('" . $z . "')</script>";}?>
<?php if (isset($_GET['errorl'])) {$z = $_GET['errorl'];
    echo "<script type='text/javascript'>
$(document).ready(function(){
$('#login').modal('show');
});
</script>";
    echo "<script type='text/javascript'>alert('" . $z . "')</script>";}?>
</html>
