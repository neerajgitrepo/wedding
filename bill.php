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
    $albumSheet = htmlspecialchars($_POST['albumpage']);

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

   
    $bookingDate = date("d/m/Y");


    // Step 2: Insert into database
    $stmt = $conn->prepare("INSERT INTO `bookingdata` 
        (dulha, dulhan, shadiDate, bookingDate, barat, address, bookingKarta, mobile, dealAmount, initialPay, services, albumPage, extraQuery) 
        VALUES ('$dulha', '$dulhan', '$shadiDate','$bookingDate', '$baarat', '$address', '$bookingKarta', '$mobile', '$dealAmount', '$initialPay', '$servicesList','$albumSheet','$extraQuery')"
    );

// table create in database
$mobileTrim = trim($mobile); // Get mobile from form
$user = 'user' . $mobileTrim; // Dynamic table name, e.g., user9876543210

// SQL to create user-specific table
$createUser = "CREATE TABLE IF NOT EXISTS `$user` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  video VARCHAR(255),
  image VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
// Execute the query
if ($conn->query($createUser) === TRUE) {
    // folder create in server
    $videoDir = "admin/videos/$user";
    mkdir($videoDir, 0777, true);

    $albumDir = "admin/albums/$user";
    mkdir($albumDir, 0777, true);

} else {
    echo "Error creating table `$user`: " . $conn->error;
}


  $stmt->execute();
  if($stmt && $createUser){
   echo "<script>alert('Your Wedding Booking Successful');</script>";
  ?>  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Wedding Booking Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>/* General Reset */
body {
  font-family: 'Arial', sans-serif;
  font-size: 14px;
  margin: 0;
  padding: 0;
  background: #fff;
  color: #000;
}

/* Container Styling */
.invoice-box {
  width: 210mm;
  min-height: 297mm;
  padding: 20mm;
  margin: auto;
  border: 1px solid #ccc;
  box-sizing: border-box;
  background-color: #fff;
  page-break-after: auto;
}

/* Table Styling */
table {
  width: 100%;
  border-collapse: collapse;
}

table th,
table td {
  padding: 8px;
  border: 1px solid #000;
  text-align: left;
}

/* Headings */
h2 {
  text-align: center;
  margin-bottom: 20px;
}

/* Signature Boxes */
.sign-box {
  height: 50px;
  border-bottom: 1px solid #000;
  margin: 20px auto 5px;
  width: 80%;
}

.sign-label {
  font-size: 13px;
  font-weight: bold;
}

/* Utility Classes */
.text-end {
  text-align: right;
}
.text-center {
  text-align: center;
}
.mt-4 {
  margin-top: 1rem;
}
.mt-5 {
  margin-top: 2rem;
}
.mb-4 {
  margin-bottom: 1rem;
}

/* Row Layout */
.row {
  display: flex;
  flex-wrap: wrap;
}
.col-sm-6 {
  width: 50%;
}
.col-md-6 {
  width: 50%;
  padding: 0 10px;
}

/* Print Specific Rules */
@media print {
  body {
    width: 210mm;
    height: 297mm;
    margin: 0;
  }

  .invoice-box {
    border: none;
    box-shadow: none;
    padding: 15mm;
  }

  .table {
    page-break-inside: avoid;
  }

  .no-print {
    display: none;
  }
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
      <strong>Invoice by #:</strong> payalproduction.com<br>
      <strong>Booking Date:</strong> <?php echo $bookingDate; ?>
    </div>
  </div>

  <!-- Wedding Details -->
  <div class="mb-4">
    <strong>Dulha:</strong> <?php echo $dulha ?><br>
    <strong>Dulhan:</strong> <?php echo $dulhan ?><br>
    <strong>Shaadi ki Tareekh:</strong> <?php echo $shadiDate ?><br>
    <strong>Album Sheets:</strong> <?php echo $albumSheet ?><br>

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
      <li>किसी भी स्थिति में बुकिंग कैन्सल करने पर अग्रिम(Advance) जमा राशि Refund योग्य नहीं है,प्रोग्राम चालू होने की स्थिति में पूरा चार्ज भी लिया जा सकेगा ।</li>
      <li>शेष भुगतान शादी तारीख तक अनिवार्य रूप से करना होगा। भुगतान न होने की स्थिति में ऑर्डर  कैन्सल माना जा सकेगा।</li>
      <li> एल्बम की सीट बढ़ने पर चार्ज अलग से देना होगा !</li>
      <li>फोटोग्राफर ब स्टाफ को लाने ले जाने खाना, रुकना आदि की जिम्मेदारी ग्राहक की स्वयं की होगी,फोटोग्राफर बा उसकी टीम के साथ किसी भी प्रकार की बदसलूकी या दुर्ववाहर की स्थिति में फोटोग्राफर बा टीम को वापस बुलाया जा सकता है ऐसी स्थिति में जमा की गई राशि वापस नहीं की जावेगी !</li>
      <li> निर्धारित कार्य से अधिक कार्य करने पर 3000 रुपए घंटे के हिसाब से चार्ज देना होगा !</li>
      <li>ग्राहक द्वारा तैयार कराया गया परिधान/डिज़ाइन, वेडिंग शूट अथवा संबंधित सामग्री का उपयोग दुकान प्रचार एवं विज्ञापन के लिए किया जा सकता है। इस पर समस्त कॉपीराइट एवं मालिकाना हक दुकान के पास सुरक्षित रहेगा।</li>
      <li>किसी टेक्निकल प्रॉब्लम या सामग्री गुम होने या डाटा करप्ट हो जाने के कारण डाटा नहीं मिल पाने की स्थिति में स्टूडियो की कोई जवाबदारी नही होगी, अगर इस स्थिति में कस्टमर रुपए वापिस लेने या लड़ाई-झगड़े की कोशिश करता है तो उसपे कानूनी कार्यवाही की जा सकती है</li>
      <li>किसी भी विवाद की स्थिति में न्याय क्षेत्र भोपाल न्यायालय रहेगा।</li>
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
     echo "<script>alert('please try Again');</script>";
    }
}
?>
