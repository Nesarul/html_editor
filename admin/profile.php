<?php
require_once('./inc/header.php');
require_once('./db/db.php');
require_once('./function.php');
?>
<style>
    .card-header{
        background-color:#1D4354;
        color:white;
    }
    .card{
        box-shadow: 2px 4px 9px gray;
        -webkit-box-shadow: 2px 4px 9px gray;
        -moz-box-shadow: 2px 4px 9px gray;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 col-12 mt-5">
            <?php 
                $res = db::getInstance()->get('users',array('user_id','=',$data->user_id))->getResults();
                foreach($res as $key=>$rec):
            ?>
            <div class="card">
                <div class="card-header"><i class="far fa-address-card"></i> Profile Information for: <?php echo $rec->user_first_name.' '.$rec->user_last_name; ?></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 col-12 text-center">
                            <h5><img class="img-fluid" src="../assets/images/upload/<?php echo $rec->user_image; ?>" alt="User Image"> </h5>
                            <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Change Image</a>
                        </div>
                        <div class="col-sm-8 col-12">
                            <h5>First Name: <?php echo $rec->user_first_name; ?> ...<i class="fas fa-pencil-alt"></i> </h5>
                            <h5>Last Name: <?php echo $rec->user_last_name; ?> <i class="fas fa-pencil-alt"></i> </h5>
                            <h5>Login Name: <?php echo $rec->user_login_name; ?> <i class="fas fa-pencil-alt"></i> </h5>
                            <h5>Email: <?php echo $rec->user_email; ?> <i class="fas fa-pencil-alt"></i> </h5>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Change User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                conta
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>
<?php
require_once('./inc/footer.php');
?>