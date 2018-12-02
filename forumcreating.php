<?php
    require('connect.php');
    session_start();
    include('useronly.php');
    $imageuploaded = false;
    $imageFileName = "";
    
    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') 
    {
        $current_folder = dirname(__FILE__);
        
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

        return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    function file_is_an_image($temporary_path, $new_path) 
    {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png','application/pdf'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png','pdf'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);

        //does the same as getimagesize but for all types.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $actual_mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }
    
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

    if ($image_upload_detected) 
    { 
        $image_filename        = $_FILES['image']['name'];
        $temporary_image_path  = $_FILES['image']['tmp_name'];
        $new_image_path        = file_upload_path($image_filename);
        if (file_is_an_image($temporary_image_path, $new_image_path)) 
        {
            //this actually saves the image to the uploads file
            move_uploaded_file($temporary_image_path, $new_image_path);
            //insert into forums with $image_filename
            $imageuploaded = true;
            $imageFileName = $_FILES['image']['name'];
        }
    }
    
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = $_POST['description'];
    $rules = $_POST['rules'];
    if($_POST['category'] ==="")
    {
        $_POST['category'] = null;
    }
    $categoryId = $_POST['category'];

    date_default_timezone_set('America/Winnipeg');
    $date = date('Y-m-d');

    $username = $_SESSION['username'];

    if($imageuploaded = true)
    {
        $insertQuery = "INSERT INTO forums (title,description,rules,createdDate,username,categoryId,image) VALUES (:title,:description,:rules,:createdDate,:username,:categoryId,:image)";
    }
    else
    {
        $insertQuery = "INSERT INTO forums (title,description,rules,createdDate,username,categoryId) VALUES (:title,:description,:rules,:createdDate,:username,:categoryId)";
    }
    $insertStatement = $db-> prepare($insertQuery);
    $insertStatement->bindValue(':title',$title);
    $insertStatement->bindValue(':description',$description);
    $insertStatement->bindValue(':rules',$rules);
    $insertStatement->bindValue(':createdDate',$date);
    $insertStatement->bindValue(':username',$username);
    $insertStatement->bindValue(':categoryId',$categoryId);
    if($imageuploaded = true)
    {
        $insertStatement->bindValue(':image',$imageFileName);
    }
    $insertStatement->execute();
    header('Location: index.php');
    //what could i ever possibly do to turn this into a user page
    //header('Location: adminforumlist.php?orderBy=title');
?>