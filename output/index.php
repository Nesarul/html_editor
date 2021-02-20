<?php require_once('../admin/db/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Completed View</title>

    <!-- CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    <style>
        .accordion-button,
        .accordion-button:focus,
        .accordion-button:not(.collapsed) {
            background-color:#97adee;
            box-shadow:none;
            margin:3px 0px;
            color:black;
            font-size:16px;
            font-weight:bold;
            padding: 0.75rem 1.25rem;
        }
        .unit_names{
            list-style-type:none;
            margin:0;
            padding:0;
        }
        .unit_names>li{
            margin:1px;
        }
        .unit_names>li>a{
            display:block;
            line-height:40px;
            color:black;
            font-weight:bold;
            padding:0 1.25rem;
            text-decoration:none;
        }
        .unit_names>li>a:hover{
            background-color:white;
            text-decoration:none;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-8 col-12 mt-4">
                <?php $res = db::getInstance()->query("SELECT * FROM course")->getResults(); ?>
                <div class="accordion" id="accordion-course">
                    <?php foreach($res as $key=>$rec): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $key; ?>" style="">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $key; ?>">
                                <?php echo $rec->course_name; ?>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $key; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $key; ?>" data-bs-parent="#accordion-course">
                            <div class="accordion-body" style="background-color:#b9c8f4;padding:1rem 0.25rem;">
                                <ul class="unit_names">
                                    <?php
                                        $uRes = db::getInstance()->get('unit',array('course_id','=',$rec->course_id))->getResults();
                                        foreach($uRes as $uKey=>$uRec):
                                    ?>
                                        <li><a href="./view.php?uid=<?php echo $uRec->unit_id; ?>" target="_blank"><?php echo $uRec->unit_name.' - '.$uRec->unit_title; ?></a></li>
                                    <?php endforeach;?>
                                </u>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>