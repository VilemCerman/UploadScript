<?php
$formMessage = "Nahrajte soubor";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Upload</title>
</head>
<body>
<div class="container">
    <?php
    if($_FILES) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileType2 = substr($_FILES['uploadedName']['type'], 0, strpos($_FILES['uploadedName']['type'], '/'));

        if($fileType2 === "video"){
            echo "<video controls><source src='$targetFile'></video>";
        }elseif($fileType2 === "audio"){
            echo "<audio controls><source src='$targetFile'></audio>";
        }
        else{
            echo "<img src='$targetFile'>";
        }

        $uploadSuccess = true;

        if ($_FILES['uploadedName']['error'] != 0) {
            $formMessage ="chyba serveru";
            $uploadSuccess = false;
        } elseif (file_exists($targetFile)) {
            $formMessage = "soubor jiz existuje";
            $uploadSuccess = false;
        } elseif ($_FILES['uploadedName']['size'] > 8000000) {
            $formMessage = "soubor moc velky";
            $uploadSuccess = false;
        }

//        if(!$uploadSuccess){
//            echo "doslo k chybe uploadu";
//        }
        else {
            if (move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)) {
                echo "Soubor " . basename($_FILES['uploadedName']['name']) . " byl ulozen";
            } else {
                echo "doslo k chybe uploadu";
            }
        }
    }
    ?>
<form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formFile" class="form-label"><?php echo $formMessage?></label>
        <input  class="form-control" type="file" name="uploadedName" accept="audio/*, video/*, image/*">
        <input type="submit" value="Nahrát" name="submit">
    </div>
</form>
</div>
</body>
</html>