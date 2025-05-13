<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bookingSubmit'])) {
    // Database connection
    require_once 'admin/dbconnect.php';

    // Step 1: Fetch form data
    $dulha = htmlspecialchars($_POST['dulha']);
    $dulhan = htmlspecialchars($_POST['dulhan']);
    $shadiDate = $_POST['shadiDate'];
    $baarat = htmlspecialchars($_POST['baarat']);
    $address = htmlspecialchars($_POST['address']);
    $bookingKarta = htmlspecialchars($_POST['bookingKarta']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $dealAmount = (float)$_POST['dealAmount'];
    $initialPay = (float)$_POST['initialPay'];
    $extraQuery = htmlspecialchars($_POST['extraQuery']);

    // Services as comma-separated string
    $services = [];
    if (isset($_POST['onlyPhoto']))       $services[] = $_POST['onlyPhoto'];
    if (isset($_POST['onlyVideo']))       $services[] = $_POST['onlyVideo'];
    if (isset($_POST['normalWedding']))   $services[] = $_POST['normalWedding'];
    if (isset($_POST['specialWedding']))  $services[] = $_POST['specialWedding'];
    if (isset($_POST['dron']))            $services[] = $_POST['dron'];
    if (isset($_POST['candid']))          $services[] = $_POST['candid'];
    if (isset($_POST['preWedding']))      $services[] = $_POST['preWedding'];
    if (isset($_POST['cinematic']))       $services[] = $_POST['cinematic'];

    $servicesList = implode(', ', $services);

    // Step 2: Insert into database
    $stmt = $conn->prepare("INSERT INTO `bookingdata` 
        (dulha, dulhan, shadiDate, barat, address, bookingKarta, mobile, dealAmount, initialPay, services, extraQuery) 
        VALUES ('$dulha', '$dulhan', '$shadiDate', '$baarat', '$address', '$bookingKarta', '$mobile', '$dealAmount', '$initialPay', '$servicesList', '$extraQuery')"
    );

    $stmt->execute();
    if($stmt){
  ?>  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Wedding Booking Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .invoice-box {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border: 1px solid #eee;
      border-radius: 15px;
      background: #fff;
      font-size: 16px;
    }
    .invoice-box h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .table td, .table th {
      vertical-align: middle;
    }
    .total-row th {
      background-color: #f8f9fa;
    }
    .sign-box {
      height: 80px;
      border-bottom: 1px solid #000;
      margin-bottom: 5px;
    }
    .sign-label {
      font-weight: bold;
      text-align: center;
      margin-top: 5px;
    }
  </style>
</head>
<body>

<div class="invoice-box mt-5">
  <h2>Payal Production Wedding Booking Invoice</h2>

  <!-- Customer & Booking Info -->
  <div class="row mb-4">
    <div class="col-sm-6">
      <strong>Customer Name:</strong> <?php echo $bookingKarta ?><br>
      <strong>Mobile:</strong> <?php echo $mobile ?><br>
    </div>
    <div class="col-sm-6 text-end">
      <strong>Invoice #:</strong> payalproduction.com<br>
      <strong>Date:</strong> <?php echo $shadiDate ?>
    </div>
  </div>

  <!-- Wedding Details -->
  <div class="mb-4">
    <strong>Dulha:</strong> <?php echo $dulha ?><br>
    <strong>Dulhan:</strong> <?php echo $dulhan ?><br>
    <strong>Shaadi ki Tareekh:</strong> <?php echo $shadiDate ?><br>
    <strong>Address:</strong> <?php echo $address ?>
  </div>

  <!-- Services Table -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Service</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr><td><?php echo $servicesList ?></td><td>✓</td></tr>
    </tbody>
  </table>

  <!-- Payment Summary -->
  <table class="table table-bordered mt-4">
    <tbody>
      <tr>
        <th>Deal Amount (₹)</th>
        <td><?php echo $dealAmount ?></td>
      </tr>
      <tr>
        <th>Initial Payment (₹)</th>
        <td><?php echo $initialPay ?></td>
      </tr>
      <tr class="total-row">
        <th>Remaining Amount (₹)</th>
        <td><strong><?php echo $dealAmount - $initialPay ?></strong></td>
      </tr>
    </tbody>
  </table>

  <!-- Terms & Conditions -->
  <div class="mt-4">
    <h5>Terms & Conditions:</h5>
    <ul>
      <li>Booking confirmation only after advance payment.</li>
      <li>Cancellation charges apply as per policy.</li>
      <li>Balance amount must be paid before or on event date.</li>
      <li>Damage to property will be borne by the customer.</li>
      <li>This invoice serves as official booking proof.</li>
    </ul>
  </div>

  <!-- Signatures -->
  <div class="row mt-5 text-center">
    <div class="col-md-6">
      <div class="sign-box"></div>
      <div class="sign-label">Booking Party Signature</div>
    </div>
    <div class="col-md-6">
      <div class="sign-box"></div>
      <div class="sign-label">Shop Owner Signature</div>
    </div>
  </div>

  <div class="text-center mt-4">
    <p><strong>Thank you for choosing us!</strong></p>
    <small>This is a system generated invoice.</small>
  </div>
</div>

</body>
</html>
<?php
    $stmt->close();
    $conn->close();
    }else{
      alert("problem");
    }

}
?>
