<!-- Header -->
<?php include('./sections/header.php'); ?>

<!-- Body -->
  <div class="container">
    <h2>Sales Table</h2>

      <!-- Filter options -->
      <form id="searchSubmit">
        <input class="form-control" id="customerInput" name="customer_name"  type="text" placeholder="Customer..">
        <input class="form-control" id="customerProduct" name="product_name" type="text" placeholder="Product..">
        <input class="form-control" id="customerPrice" name="product_price"  type="text" placeholder="Price..">
       </form>      
    <br>

    <!-- Filtered data table-->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sale Id</th>
          <th>Customer name</th>
          <th>Customer email</th>
          <th>Product ID</th>
          <th>Product name</th>
          <th>Product price</th>
          <th>Sale date</th>                
        </tr>
      </thead>
      <tbody id="salesTables">
      </tbody>
    </table>
  </div>

<!-- Footer -->
<?php include('./sections/footer.php'); ?>