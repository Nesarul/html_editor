<?php
    require_once('../admin/function.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    if($data->type === "3")
        header("Location: ../dashboard/index.php");
    require_once('../admin/db/db.php');
    require_once('../assets/inc/header.php');    
    
    $sql = "SELECT u.user_id, u.user_first_name, u.user_last_name, u.user_email, tp.type_name, u.user_permission, u.user_phone, u.user_image FROM users AS u LEFT JOIN user_type AS tp ON u.user_type = tp.type_id";
    $usersList = db::getInstance()->query($sql)->getResults();
?>

<!-- leftbar -->
<div class="left-bar">
    <p class="text-center"><img src="../assets/images/logo.png" alt="" width="50%"></p>
    <img src="../assets/images/upload/<?php echo($data->image); ?>" alt="" class="mx-auto d-block rounded-circle" width="50">
    <h6>Welcome<br/><?php echo $data->user; ?></h6>

    <hr>
    <!-- Menu -->
    <ul class="list-unstyled menu">
        <?php foreach($menu_data->item as $key => $rec):?>
            <li>
                <a class="main-menu" href="<?php echo $rec->link; ?>">
                    <?php echo '<i class="'.$rec->image.'"></i> &nbsp;'. $rec->caption; ?>
                </a>
            </li>   
        <?php endforeach; ?>
    </ul>
</div>
<div class="right-bar">
    <div class="container-fluid">
        <h2 style="border-bottom:1px solid #999">Users</h2>
        <div class="row">
            <div class="col-12">
                <?php if($data->type == "1")
                    echo '<a type="button" class="btn btn-outline-success" onclick="userWithData(0)">Add New User</a>';
                ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <caption></caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Permission</th>
                                <th>Settings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($usersList as $key => $rec): ?>
                            <tr>
                                <td><img src="../assets/images/upload/<?Php echo $rec->user_image ?>" width="35" class="me-4" /><?php echo $rec->user_first_name." ".$rec->user_last_name;?></td>
                                <td><?php echo $rec->user_email;?></td>
                                <td><?php echo $rec->type_name;?></td>
                                <td>
                                    <style>
                                        /* 
                                            Code Copied From: https://codepen.io/bbodine1/pen/novBm
                                            .slideThree 
                                        
                                        */
                                        .user_state {
                                            width: 80px;
                                            height: 26px;
                                            background: #333;
                                            margin: 0px auto;
                                            position: relative;
                                            border-radius: 50px;
                                            box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px rgba(255, 255, 255, 0.2);
                                        }
                                        .user_state:after {
                                            content: 'OFF';
                                            color: #000;
                                            position: absolute;
                                            right: 10px;
                                            z-index: 0;
                                            font: 12px/26px Arial, sans-serif;
                                            font-weight: bold;
                                            text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.15);
                                        }
                                        .user_state:before {
                                            content: 'ON';
                                            color: #27ae60;
                                            position: absolute;
                                            left: 10px;
                                            z-index: 0;
                                            font: 12px/26px Arial, sans-serif;
                                            font-weight: bold;
                                        }
                                        .user_state label {
                                            display: block;
                                            width: 34px;
                                            height: 20px;
                                            cursor: pointer;
                                            position: absolute;
                                            top: 3px;
                                            left: 3px;
                                            z-index: 1;
                                            background: #fcfff4;
                                            background: linear-gradient(to bottom, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
                                            border-radius: 50px;
                                            transition: all 0.4s ease;
                                            box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
                                        }
                                        .user_state input[type=checkbox] {
                                            visibility: hidden;
                                        }
                                        .user_state input[type=checkbox]:checked + label {
                                            left: 43px;
                                        }

                                        /* end .user_state */                       
                                    </style>
                                    <div class="user_state">  
                                        <input type="checkbox" value="None" id="user_state-<?php echo $rec->user_id; ?>" name="check" <?php echo $rec->user_permission == 1 ? 'checked':''; ?> />
                                        <label for="user_state-<?php echo $rec->user_id; ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" id="view-<?php echo $rec->user_id; ?>" class="btn btn-primary btn-sm" onClick="userInfo(this.id)"><i class="far fa-eye"></i></button>
                                    <button type="button" id="<?php echo $rec->user_id; ?>" class="btn btn-success btn-sm" onClick="userWithData(this.id);"><i class="far fa-edit"></i></button>
                                    <?php if( $data->type == "1"): ?>
                                        <a type="button" id="log-<?php echo $rec->user_id."-".$data->type; ?>" class="btn btn-danger btn-sm" href="javascript:void(0);" onClick="deleteUser(this.id);"><i class="far fa-trash-alt"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="newUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header"  style="background-color:#212F3C;color:white">
                    <h5 class="modal-title" id="newUserLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="" method="post" id="cu">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name">
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
                                        <label for="pass">Password</label>
                                        <input type="password" class="form-control" id="pass" name="pass">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="conf_pass">Confirm Password</label>
                                        <input type="password" class="form-control" id="conf_pass" name="conf_pass">
                                    </div>    
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="user_type">User Type</label>
                                        <select class="form-select" aria-label="Select User Type" name="user_type" id="user_type">
                                            <option value="1">Admin</option>
                                            <option value="2">Instructional Designer</option>
                                            <option value="3">Subject Matter Expert</option>
                                        </select>
                                    </div>    
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="user_permission">Permission</label>
                                        <select class="form-select" aria-label="Select User Status" name="user_permission" id="user_permission">
                                            <option value="1">Active</option>
                                            <option value="0">On Hold</option>
                                        </select>
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
                            <div class="form-group">
                                <label for="user_image">User Image</label>
                                <input class="form-control form-control-sm" id="user_image" name="user_image" type="file">
                            </div>
                        </div>
                    </div>
                    
                        <!-- <button type="submit" class="btn btn-primary">Submit</button>                     -->
                    </form>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btn_create_user" data-id="" data-action="" type="button" class="btn btn-primary"  onClick=" createUser(this.id)" >Save changes</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="view_user" tabindex="-1" aria-labelledby="view_userLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header" style="background-color:#212F3C;color:white">
                    <h5 class="modal-title" id="view_userLabel_info"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8 col-12">
                                <div id="info_cont">
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <img id="info_user_image" src="" alt="User Image" width="100%" />
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <style>.agreement-stripe{width:100%;padding:15px;margin:0;background-color:rgb(96,8,8);color:white;}.btn-close {background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;}</style>
        <div class="modal fade" id="delete_user" data-user="" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete_userLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header agreement-stripe">
                        <h5 class="modal-title" id="delete_userLabel"><i class="fas fa-exclamation-triangle"></i> Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deleting a user will remove all associated courses, units and pages, Do you agree?</p>                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="btn-confirm-delete">Yes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function userInfo(id)
    {
        if(id != 0)
        {
            var a = id.split('-');
            $.ajax({
                type: "POST",
                url:'../admin/user_info.php',
                dataType: 'json',
                data:{id:a[1]},
                success:function(response){
                    var k = "<table class='green-table'><tr><th>User ID :</th><td>"+response.user_id+
                    "</td></tr><tr><th>First Name :</th><td>"+response.user_first_name+
                    "</td></tr><tr><th>Last Name :</th><td>"+response.user_last_name+
                    "</td></tr><tr><th>Email ID :</th><td>"+response.user_email+
                    "</td></tr><tr><th>Login Name :</th><td>"+response.user_login_name+
                    "</td></tr><tr><th>Phone :</th><td>"+response.user_phone+
                    "</td></tr><tr><th>Permission :</th><td>"+response.user_permission+
                    "</td></tr><tr><th>Status :</th><td>"+response.user_type+
                    "</td></tr><tr><th>Date of Join :</th><td>"+response.date_join+
                    "</td></tr></table>";
                    $('#info_cont').html(k);
                    $('#view_userLabel_info').text("View Details of - "+response.user_first_name+" "+response.user_last_name);
                    $('#info_user_image').attr('src','../assets/images/upload/'+response.info_user_image);
                    $('#view_user').modal('show');
                },
                error: function(){

                }
            }); 
        }
    }
    function userWithData(id)
    {
        if(id != 0){
            $.ajax({
                type: "POST",
                url:'../admin/fill_user.php',
                data:{uid:id},
                success: function(data)
                {
                    var x = JSON.parse(data);
                    $('#first_name').val(x[0]['user_first_name']);
                    $('#last_name').val(x[0]['user_last_name']);
                    $('#user_email').val(x[0]['user_email']);
                    $('#pass').val(x[0]['user_pass']);
                    $('#conf_pass').val("");
                    $('#user_type').val(x[0]['user_type']);
                    $('#user_permission').val(x[0]['user_permission']);
                    $('#login_id').val(x[0]['user_login_name']);
                    $('#phone').val(x[0]['user_phone']);
                    $('#btn_create_user').text("Update").data("action","update").data("id",x[0]['user_id']);
                    $('#newUserLabel').text("Update "+x[0]['user_first_name']+" "+x[0]['user_last_name']);
                    $('#user_email').prop('disabled',true);
                    $('#login_id').prop('disabled',true);
                    $("#newUser").modal("show");
                }
            });
        } else{
            $('#first_name').val("");
            $('#last_name').val("");
            $('#user_email').val("");
            $('#pass').val("");
            $('#conf_pass').val("");
            $('#user_type').val("");
            $('#user_permission').val("");
            $('#login_id').val("");
            $('#phone').val("");
            $('#btn_create_user').text("Create User").data("action","create");
            $('#newUserLabel').text("Add New User");
            $('#user_email').prop('disabled', false);
            $('#login_id').prop('disabled', false);
            $("#newUser").modal("show");
        }

    }

    function createUser(e)
    {
        var act = $('#'+e).data('action');
        var id = $('#'+e).data('id');
        alert(act);
        if(act === "update")
        {
            var first_name =        $('#first_name').val()
            var last_name =         $('#last_name').val()
            var user_email =        $('#user_email').val()
            var pass =              $('#pass').val()
            var conf_pass =         $('#conf_pass').val()
            var user_type =         $('#user_type').val()
            var user_permission =   $('#user_permission').val()
            var login_id =          $('#login_id').val()
            var phone =             $('#phone').val()

            var text = first_name + ", " +last_name + ", " +user_email + ", " +pass + ", " +conf_pass + ", " +user_type + ", " +user_permission + ", " +login_id + ", " +phone;
            $.ajax({
            type: "POST",
                url:'../admin/update_user.php',
                data:{uid:id,first_name: first_name,last_name: last_name,user_email: user_email,pass: pass,conf_pass: conf_pass,user_type: user_type,user_permission: user_permission,login_id: login_id,phone: phone},
                success: function(data)
                {
                    $("#newUser").modal("hide");
                }
            });
        } else if(act === "create")
        {
            let myForm = document.getElementById('cu');
            let formData = new FormData(myForm);
            var x = $('#user_type').val();
            var y = $('#user_permission').val();
            formData.append('user_type',$('#user_type').val());
            formData.append('user_permission',$('#user_permission').val());
            $.ajax({
                type: 'POST',
                url: '../admin/new_user_adm.php',
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
    }
    function deleteUser(e){
        $('#delete_user').data('user',e);
        $("#delete_user").modal("show");
    }
    $("#btn-confirm-delete").on('click',function(){
        var x = $('#delete_user').data('user');
        var ut = x.split('-');
        if(ut[2] != "1"){
            alert("Only administrator can Delete a User....");
            return;
        }
        $.ajax({
            type: "POST",
            url:'../admin/delete_user.php',
            data:{id:ut[1]},
            success: function(data){location.reload();}
        });
    });

    $('[id^="user_state-"]').on('change',function(){
        var x = $(this).attr('id');
        var st = $(this).is(":checked") ? '1' : '0';
        var id = x.split('-');
        $.ajax({
            type: "POST",
            url:'../admin/change_permission.php',
            data:{id:id[1],perm:st},
            success: function(data){location.reload();}
        });
    });
</script>
<?php
    require_once("../assets/inc/footer.php");
?>