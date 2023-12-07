
    <?php
    include 'connection.php';
    
    if (isset($_POST['custID'])) {
        $CustID = $_POST['custID'];
    $orderperpage=3;
    if(isset($_GET['page'])&& is_numeric($_GET['page']))
      $page=$_GET['page'];
    else
      $page=1;

      $start=($page-1)*$orderperpage;

    $sql = "SELECT customers.ContactName AS CustomerName,
    customers.CustomerID,
    customers.Phone AS CustomerPhone,
    customers.CompanyName,
    customers.ContactTitle,
    customers.Address,
    countries.Name AS CountryName,
    cities.Name AS CityName
    FROM customers
    INNER JOIN cities ON customers.CityID = cities.CityID
    INNER JOIN countries ON cities.CountryID = countries.CountryID
    WHERE customers.CustomerID='$CustID'";
 
       $result=mysqli_query($con,$sql);
       $r=mysqli_fetch_assoc($result);

       $orders="SELECT customerID,orders.OrderDate,order_details.OrderID,sum(UnitPrice*Quantity) AS tot
               from order_details 
               inner join orders on orders.OrderID=order_details.OrderID
               group by customerID,order_details.OrderID
               having  CustomerID='$CustID' Limit $start, $orderperpage";
       $rorder=mysqli_query($con,$orders);
       

       $ordercount = "SELECT COUNT(*) AS totalorders FROM orders WHERE CustomerID='$CustID'";
       $rstotalorder = mysqli_query($con, $ordercount);
       $totalorder = mysqli_fetch_assoc($rstotalorder);
      

       $totalpages=ceil($totalorder['totalorders'] / $orderperpage);
       

    }else{
        echo "Customer ID not provided.";
    }

       ?>
    
<table id="example" class="table table-striped" style="width:90%">
        <thead>
            <tr>
                
            <th>OrderID</th>
            <th>OrderDate</th>
            <th>Amount</th>
               
                
            </tr>
        </thead>
        <tbody>
        <?php while ($roworder = mysqli_fetch_array($rorder)) { ?>
        <tr>
            <td><?php echo $roworder['OrderID']; ?></td>
            <td><?php echo date('d/m/y', strtotime($roworder['OrderDate'])); ?></td>
            <td><?php echo number_format( $roworder['tot']); ?></td>
        </tr>
    <?php } ?>
           
            
        </tbody>
    </table>
   

       
    

   