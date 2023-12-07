<?php
include 'connection.php';

if (isset($_POST['productID'])) {
    $productID = $_POST['productID'];

    // Query the database to get the product details based on the productID
    $sql = "SELECT ProductID,ProductName, UnitPrice ,product_cover,CategoryName,QuantityPerUnit
    FROM products
    inner join categories on categories.CategoryID=products.CategoryID
      WHERE ProductID = $productID";
    $result = mysqli_query($con, $sql);
  
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $productCoverPath = 'public/products/images/' . $product['product_cover'];


        // Display the product details
        echo '<img class="img" src="' . $productCoverPath . '" alt="' . $product['ProductName'] . '">';
        echo '<h1 class="pro">' . $product['ProductName'] . '</h1>';
        echo '<h1 class="categoname">' . $product['CategoryName'] . '</h1>';
        echo '<p class="price">Unit Price: $' . number_format($product['UnitPrice'],2) . '</p>';
        echo '<p class="per">' . $product['QuantityPerUnit'] . '</p>';
        echo '<hr class="line">';
        echo '<a href="cart.php?PID=' . $product['ProductID'] . '" class="btns btn btn-danger">Add To Cart</a>';
        // Add more details as needed
    } else {
        echo 'Product not found.';
    }
} else {
    echo 'Invalid request.';
}
?>