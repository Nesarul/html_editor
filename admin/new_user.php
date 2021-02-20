<?php
require_once('./db/db.php');
header('Content-type: application/json');
$uploadDir = '../assets/images/upload/'; 
$response = array( 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
); 
$fn = new DateTime();
$fil = $fn->getTimestamp();
if(isset($_POST['first_name'])){ 
    $name   = $_POST['first_name'];
    $lname  = $_POST['last_name'];
    $email  = $_POST['user_email']; 
    $pass   = $_POST['passwd']; 
    $cpass  = $_POST['passc'];
    $login  = $_POST['login_id'];
    $ph     = $_POST['phone'];

    if(!empty($name) && !empty($email)){ 
        //First of all check does the email exist. 
        $res = db::getInstance()->get('users',array('user_email','=',$email))->count();
        if($res != 0){
            $response['message'] = 'Email Already Exist!'; 
            echo json_encode($response);
            exit(0);
        }
        str_replace(' ','',$login);
        if(strlen($login)<2){
            $response['message'] = 'Login ID at least 2 characters long and contain no space.'; 
            echo json_encode($response);
            exit(0);
        }
        $res = db::getInstance()->get('users',array('user_login_name','=',$login))->count();
        if($res != 0){
            $response['message'] = 'Login ID already Exists!'; 
            echo json_encode($response);
            exit(0);  
        }
        if(strcmp($pass,$cpass) != 0)
        {
            $response['message'] = 'Password & Verify Password Not Match.'; 
            echo json_encode($response);
            exit(0);  
        }
        

        //Validate email 
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){ 
            $response['message'] = 'Please enter a valid email.'; 
        }else{ 
            $uploadStatus = 1; 
                
            // Upload file 
            $uploadedFile = ''; 
            if(!empty($_FILES["user_image"]["name"])){ 
                    
                // File path config 
                $fileName       = basename($_FILES["user_image"]["name"]); 
                $targetFilePath = $uploadDir . $fileName; 
                $fileType       = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                $fil = $fil.'.'.$fileType;
                $targetFilePath = $uploadDir . $fil;
                // Allow certain file formats 
                $allowTypes = array('jpg', 'png', 'jpeg'); 
                
                if(in_array($fileType, $allowTypes)){ 
                    // Upload file to the server 
                    if(move_uploaded_file($_FILES["user_image"]["tmp_name"], $targetFilePath)){ 
                        $uploadedFile = $fil; 
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    } 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, JPG, JPEG, & PNG files are allowed to upload.'; 
                } 
            } 
                
            if($uploadStatus == 1){ 
                $jDate = $fn->format('Y-m-d H:i:s');
                $ps = password_hash($pass, PASSWORD_DEFAULT);
                db::getInstance()->insert('users',array('user_first_name' => $name,'user_last_name' => $lname,'user_login_name' => $login,'user_email' => $email,'user_pass' => $ps,'user_image' => $fil,'user_phone' => $ph,'user_type' => '3','user_permission' => '0','date_join' => $jDate));
                $response['message']="User Created Successfully. Please wait for an administrator to approve your account. ";
            } 
        } 
    }else{ 
            $response['message'] = 'Please fill all the mandatory fields (name and email).'; 
    } 
}
echo json_encode($response);