<!DOCTYPE html>
<html>
<head>
    <title>Image Upload and Save</title>
</head>
<body>
<?php
    if($_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $imagename = $_FILES['image']['name'];
        $imagetemp = $_FILES['image']['tmp_name'];

        if(is_uploaded_file($imagetemp)) {
            if(move_uploaded_file($imagetemp, __DIR__ . "/uploads/" . $imagename)) {
                echo "Sussecfully uploaded your image\n";
                exec("./inkifier ./uploads/$imagename");
                unlink("./uploads/$imagename");
                $filename = pathinfo($imagename, PATHINFO_FILENAME);
                $extention = pathinfo($imagename, PATHINFO_EXTENSION);
                $new_file_name = uniqid($filename . "_") . "." . $extention;
                rename("output.png", $new_file_name);
                echo "<a href=\"" .$_SERVER['REQUEST_URI'] . "$new_file_name\">Download Image</a>";
            }
            else {
                echo "Failed to move your image.";
            }
        }
        else {
            echo "Failed to upload your image.";
        }
    }
?>
<form method="POST" enctype="multipart/form-data" action="">
    Upload an image:
    <input type="file" name="image" />
    <input type="submit" value="Upload Image">
</form>
</body>
</html>