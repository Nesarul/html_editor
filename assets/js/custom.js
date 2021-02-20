/* User */
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