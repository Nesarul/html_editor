<?php
    require_once('./db/db.php');
    require_once('./function.php');
    setTimezone();
    $resonse = array(
        'Status' => 0,
        'Message' => ''
    );
    $title = '
    <div class="container-fluid">
        <div class="row">
            <div id="header-box" class="d-flex justify-content-center align-items-center">
                <h1></h1>
            </div>
        </div>

        <!-- End of Header -->
        <div class="row">
            <div class="col-12 p-0 mb-5">
                <div id="overviewCaption" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li data-target="#overviewCaption" data-slide-to="0" class="active"></li>
                        <li data-target="#overviewCaption" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="./images/c1/unit_01_intro_01.jpg" class="d-block w-100" alt="../../images/unit01_intro_01.jpg" />
                        </div>
                        <div class="carousel-item">
                            <img src="./images/c1/unit_01_intro_02.jpg" class="d-block w-100" alt="../../images/unit_01_intro_02.jpg" />
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#overviewCaption" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#overviewCaption" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                </div>
            </div>
        </div>
    </div>';

    $css_path = '<link href="./css/bootstrap.min.css" rel="stylesheet"><link href="./css/custom-c1.css" rel="stylesheet">';
    $js_path = '<script src="./js/jquery-3.5.1.min.js"></script>';

    if(isset($_POST['new_course']) && !empty($_POST['new_course']))
    {
        $course = $_POST['new_course'];
        $sme = empty($_POST['sme']) ? NULL:$_POST['sme'];
        $user = $data->user;
        $d = new DateTime();
        $now = $d->format("Y-m-d H:i:s");
        
        // $upload_dir = '../output/css/upload'.DIRECTORY_SEPARATOR; 
        // $allowed_types = array('css'); 
          
        // // Define maxsize for files i.e 2MB 
        // $maxsize = 2 * 1024 * 1024;  
      
        // // Checks if user sent an empty form  
        // if(!empty(array_filter($_FILES['css_file']['name']))) { 
      
        //     // Loop through each file in files[] array 
        //     foreach ($_FILES['css_file']['tmp_name'] as $key => $value) { 
                  
        //         $file_tmpname = $_FILES['css_file']['tmp_name'][$key]; 
        //         $file_name = $_FILES['css_file']['name'][$key]; 
        //         $file_size = $_FILES['css_file']['size'][$key]; 
        //         $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
      
        //         // Set upload file path 
        //         $filepath = $upload_dir.$file_name; 
      
        //         // Check file type is allowed or not 
        //         if(in_array(strtolower($file_ext), $allowed_types)) { 
      
        //             // Verify file size - 2MB max  
        //             if ($file_size > $maxsize)          
        //                 echo "Error: File size is larger than the allowed limit.";  
      
        //             // If file with name already exist then append time in 
        //             // front of name of the file to avoid overwriting of file 
        //             if(file_exists($filepath)) { 
        //                 $filepath = $upload_dir.time().$file_name; 
                          
        //                 if( move_uploaded_file($file_tmpname, $filepath)) { 
        //                     echo "{$file_name} successfully uploaded <br />"; 
        //                 }  
        //                 else {                      
        //                     echo "Error uploading {$file_name} <br />";  
        //                 } 
        //             } 
        //             else { 
                      
        //                 if( move_uploaded_file($file_tmpname, $filepath)) { 
        //                     echo "{$file_name} successfully uploaded <br />"; 
        //                 } 
        //                 else {                      
        //                     echo "Error uploading {$file_name} <br />";  
        //                 } 
        //             } 
        //         } 
        //         else { 
                      
        //             // If file extention not valid 
        //             echo "Error uploading {$file_name} ";  
        //             echo "({$file_ext} file type is not allowed)<br / >"; 
        //         }  
        //     } 
        // }  
        // else { 
              
        //     // If no files selected 
        //     echo "No files selected."; 
        // } 
        
        db::getInstance()->insert('course',array('course_name' => $course,'date_created' => $now,'author' => $user,'sme' => $sme,'c_title'=>$title,'c_css'=>$css_path,'c_js'=>$js_path));
        $response["Message"]="Successfully Inserted Record";
    }    
    echo json_encode($response);