<?php
include 'dbconnect.php'; // Database connection
error_reporting(1);
// demo photo upload section----------------------------------------------

if (isset($_POST['photoUpload']) && isset($_FILES['photoInput'])) {
    $files = $_FILES['photoInput'];
    $uploadDir = '../images/photos/';
    for ($i = 0; $i < count($files['name']); $i++) {
        if (!empty($files['name'][$i])) {
            $fileName = basename($files['name'][$i]);
            $fileTmp = $files['tmp_name'][$i];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExt, $allowed)) {
                echo "File type not allowed: " . $fileName . "<br>";
                continue;
            }

            $newFileName = time() . "_" . rand(1000, 9999) . "_" . $fileName;
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $stmt = $conn->prepare("INSERT INTO demoImages (image) VALUES (?)");
                $stmt->bind_param("s", $targetPath);
                $stmt->execute();
                $stmt->close();
                echo "Uploaded: $fileName<br>";
            } else {
                echo "Failed to upload: $fileName<br>";
            }
        }
    }
}


// demo wedding short upload section--------------------------------------

if (isset($_POST['weddingShortUpload']) && isset($_FILES['weddingInput'])) {
    $weddingDir = '../videos/weddingShorts/';
    $fileName = basename($_FILES['weddingInput']['name']);
    $fileTmp = $_FILES['weddingInput']['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allow only video formats
    $allowed = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
    if (!in_array($fileExt, $allowed)) {
        echo "File type not allowed: " . $fileExt;
        exit;
    }

    $newFileName = time() . "_" . rand(1000, 9999) . "_" . $fileName;
    $targetPath = $weddingDir . $newFileName;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $stmt = $conn->prepare("INSERT INTO demowedding (items) VALUES (?)");
        $stmt->bind_param("s", $targetPath);
        $stmt->execute();
        $stmt->close();
        echo "Wedding video uploaded successfully.";
    } else {
        echo "Failed to upload wedding video.";
    }
}

// demo Pre wedding short upload section----------------------------------

if (isset($_POST['PreWeddingUpload']) && isset($_FILES['preweddingInput'])) {
    $weddingDir = '../videos/preWedding/';
    $fileName = basename($_FILES['preweddingInput']['name']);
    $fileTmp = $_FILES['preweddingInput']['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allow only video formats
    $allowed = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
    if (!in_array($fileExt, $allowed)) {
        echo "File type not allowed: " . $fileExt;
        exit;
    }

    $newFileName = time() . "_" . rand(1000, 9999) . "_" . $fileName;
    $targetPath = $weddingDir . $newFileName;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $stmt = $conn->prepare("INSERT INTO demoprewedding (items) VALUES (?)");
        $stmt->bind_param("s", $targetPath);
        $stmt->execute();
        $stmt->close();
        echo "Wedding video uploaded successfully.";
    } else {
        echo "Failed to upload wedding video.";
    }
}

// Album upload section-------------------------------------------------

if (isset($_POST['albumUpload'])) {
    $user = 'user'.trim($_POST['videoUser']); // Mobile number used as table name and folder
    $files = $_FILES['album'];
    $uploadDir = 'albums/'.$user.'/';
    for ($i = 0; $i < count($files['name']); $i++) {
        if (!empty($files['name'][$i])) {
            $fileName = basename($files['name'][$i]);
            $fileTmp = $files['tmp_name'][$i];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validate file type
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExt, $allowed)) {
                echo "File type not allowed: " . $fileName . "<br>";
                continue;
            }

            // Unique file name
            $newFileName = time() . "_" . rand(1000, 9999) . "_" . $fileName;
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                // Save to database
                $stmt = $conn->prepare("INSERT INTO `$user` (image) VALUES (?)");
                $stmt->bind_param("s", $targetPath);
                $stmt->execute();
                $stmt->close();
                echo "Uploaded: " . $fileName . "<br>";
            } else {
                echo "Failed to upload: " . $fileName . "<br>";
            }
        }
    }
}


// video upload section -----------------------------------------------

if (isset($_POST['videoUpload']) && isset($_FILES['video']) && isset($_POST['videoUser'])) {
    $user = 'user'.trim($_POST['videoUser']); // Mobile number used as table name and folder

    // Create user-specific video folder
    $uploadDir = "videos/$user/";
    $fileName = basename($_FILES['video']['name']);
    $fileTmp = $_FILES['video']['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed video formats
    $allowed = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
    if (!in_array($fileExt, $allowed)) {
        echo "File type not allowed.";
        exit;
    }

    // Unique file name
    $newFileName = time() . "_" . rand(1000, 9999) . "_" . $fileName;
    $targetPath = $uploadDir . $newFileName;

    // Move the file
    if (move_uploaded_file($fileTmp, $targetPath)) {

        // Store in dynamic table
        $tableName = $conn->real_escape_string($user); // Sanitize table name
        $videoPath = $targetPath;

        // Insert path into user's table in `video` column
        $sql = "INSERT INTO `$tableName` (video) VALUES (?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $videoPath);
            $stmt->execute();
            $stmt->close();
            echo "Video uploaded and saved for user: $user";
        } else {
            echo "Table '$tableName' not found or invalid. Please create table or check name.";
        }

    } else {
        echo "Failed to upload video.";
    }
}

?>
