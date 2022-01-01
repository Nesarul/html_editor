<?php
    define('BP',$_SERVER['DOCUMENT_ROOT']);
    define('DS',DIRECTORY_SEPARATOR);
    require_once(BP.DS.'html_editor'.DS.'inc'.DS.'header.php');
    require_once(BP.DS.'html_editor'.DS.'admin'.DS.'session'.DS.'session.php');
    $data = Session::getInstance();
    if($data->logStatus === "logged")
        header("Location: ./dashboard/index.php");
?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-sm-4 col-12">
            <form class="form-login" action="./admin/login.php" method="post">
                <div class="login-title">
                    <p>Welcome to HTML Editor</p>
                </div>
                <div class="form-group">
                    <label for="log_id">Login ID</label>
                    <input type="text" class="form-control" name="log_id" id="log_id">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <p class="text-danger <?php if(isset($_GET['l'])) echo 'd-block'; else echo 'd-none'; ?>" id="wrong_login"><i class="fas fa-times-circle"></i> 
                    <?php if(isset($_GET['l']) && $_GET['l'] === 'v'): ?> 
                        Please ask an administrator to Verify your Login ID
                    <?php else: ?>
                            Invalid Email or Password!
                    <?php endif;?>
                </p>
                <div class="form-group mt-3">
                    <p><button type="submit" class="btn btn-success"><i class="fas fa-sign-in-alt fa-lg"></i> Log In</button>
                    &nbsp;&nbsp; No ID Please Register <a href="" data-bs-toggle="modal" data-bs-target="#newUser">Here</a></p>
                </div>
            </form>
        </div>

         <!-- Create New User -->
         <div class="modal fade" id="newUser" data-backdrop="static" tabindex="-1" aria-labelledby="newUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#212F3C;color:white">
                        <h5 class="modal-title" id="newUserLabel">Register a New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                    </div>
                    <div class="modal-body">
                        <form id="cu" name="cu" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="user_email">Email address</label>
                                        <input type="email" class="form-control" id="user_email" name="user_email">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="passwd">Password</label>
                                                <input type="password" class="form-control" id="passwd" name="passwd">
                                            </div>
                                        </div>
                                        <div class="col">
                                        <div class="form-group">
                                                <label for="passc">Password</label>
                                                <input type="password" class="form-control" id="passc" name="passc">
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            
                                
                                <div class="col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="login_id">Login id</label>
                                                <input type="text" class="form-control" id="login_id" name="login_id">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" id="phone" name="phone">
                                            </div>   
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="login_id">Upload Image</label>
                                                <input type="file" class="form-control" id="user_image" name="user_image" accept=".jpg,.png"><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn_create_user" onClick="CrUser();">Register</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function ts(){
        alert("done");
    }
    function CrUser()
    {
        let myForm = document.getElementById('cu');
        if(!myForm) alert("Failed to load form");
        let formData = new FormData(myForm);
        $.ajax({
            type: 'POST',
            url: './admin/new_user.php',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            success:function(response)
            { 
                alert(response.message);
                $("#newUser").modal("hide");
            },
            error:function(response){
                alert("Sucks");
            }
        });        
    }        
</script>
<?php
   require_once(BP.DS.'html_editor'.DS.'inc'.DS.'footer.php');
?>
