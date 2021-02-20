<?php
require_once('./function.php');
require_once('./db/db.php');
require_once('./inc/header.php');
?>
<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col-sm-6 col-12">
            <form class="form-login" action="./pu.php" method="post">
                <div class="login-title">
                    <p><i class="fas fa-exchange-alt"></i> Change Password</p>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="log_id">User Name</label>
                            <input type="text" class="form-control" name="log_id" id="log_id" disabled value="<?php echo $data->user; ?>">
                        </div>
                        <div class="form-group">
                            <label for="old_pass">Old Password</label>
                            <input type="password" class="form-control" name="old_pass" id="old_pass">
                        </div>                    
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="new_pass">New Password</label>
                            <input type="password" class="form-control" id="new_pass" name="new_pass">
                        </div>
                        <div class="form-group">
                            <label for="conf_new_pass">Confirm New Password</label>
                            <input type="password" class="form-control" id="conf_new_pass" name="conf_new_pass">
                        </div>                   
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success"><i class="fas fa-exchange-alt"></i> Change</button>
                        <button type="btn" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Cancel</button>
                    </div> 
                </div>                
            </form>
        </div>
    </div>
</div>

<?php
    require_once("./inc/footer.php");
?>
