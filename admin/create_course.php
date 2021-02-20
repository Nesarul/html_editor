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
        $message = course::getInstance()->create($course,$sme,$title,$css_path,$js_path);
    }    
    echo json_encode($response);