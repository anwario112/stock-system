<?php
include 'connection.php';

$order_result = null; // Initialize $order_result as null
$ordID = "";

if (isset($_POST['ordID'])) {
    $ordID = $_POST['ordID'];
    $orderperpage = 3;

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $start = ($page - 1) * $orderperpage;

    $order_detail = "SELECT order_details.OrderID, products.ProductID, ProductName, order_details.UnitPrice, Quantity, Discount, order_details.Quantity * order_details.UnitPrice as LineTotal
        FROM order_details 
        INNER JOIN products ON products.ProductID = order_details.ProductID
        WHERE order_details.OrderID = '$ordID'";

        $customername="SELECT customers.CompanyName,orders.OrderDate,customers.Address,customers.Phone,customers.ContactName
                       FROM customers
                       inner join orders on orders.CustomerID=customers.CustomerID
                       WHERE OrderID='$ordID'";
                      
                       
                       
                       $rcustomername=mysqli_query($con,$customername);
                       $rowcustomer=mysqli_fetch_assoc($rcustomername);
                       $order_result = mysqli_query($con, $order_detail);

    if (!$order_result) {
        // Handle the SQL query error, e.g., display an error message
        echo "Error: " . mysqli_error($con);
    }
}
?>

  <div>
      <div style="color:red;" align="center">OrderID : <?php echo $ordID;?></div>
      <div style="color:red;" align="center">OrderDate : <?php echo  date('d/w/y',strtotime($rowcustomer['OrderDate'])); ?></div>
      <div class="companyname">CompanyName : <?php echo $rowcustomer['CompanyName'];?></div>
      <div class="address">Address : <?php echo $rowcustomer['Address'];?></div>
      <div class="contactname">ContactName : <?php echo $rowcustomer['ContactName'];?></div>
      <div class="phone">Phone : <?php echo $rowcustomer['Phone'];?></div>
    </div>
    

<table id="order" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ProductID</th>
            <th>ProductName</th>
            <th>UnitPrice</th>
            <th>Quantity</th>
            <th>Discount</th>
            <th>Line Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $OrderTotal=0;
        if ($order_result) { // Check if $order_result is defined
            while ($roworder = mysqli_fetch_array($order_result)) {
                // Display order details here
                ?>
                <tr>
                    <td align='center'><?php echo $roworder['ProductID']; ?></td>
                    <td align='center'><?php echo $roworder['ProductName']; ?></td>
                    <td align='center'><?php echo number_format($roworder['UnitPrice']); ?></td>
                    <td align='center'><?php echo $roworder['Quantity']; ?></td>
                    <td align='center'><?php echo $roworder['Discount']; ?></td>
                    <td align='center'><?php echo '$'.number_format($roworder['LineTotal']);  ?></td>
                </tr>
            <?php
             $OrderTotal+=$roworder['LineTotal'];  
          }
        } else {
            // Handle the case where $order_result is not defined (e.g., display a message)
            echo "No order details found.";
        }
        ?>
        <tr>
          <td colspan='5' align="right" style="color:red; font-weight:'bold';">Order Total</td>
          <td align='right'><?php echo '$'.number_format($OrderTotal );?></td>
        </tr>
    </tbody>
</table>