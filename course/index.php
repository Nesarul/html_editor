<?php
    require_once('../admin/db/db.php');
    require_once('../admin/function.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    if($data->type === "3")
        header("Location: ../dashboard/index.php");
    
    require_once('../assets/inc/header.php');        
?>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
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
        <div class="row">
            <div class="col-12 my-3">
                <h2><i class="fas fa-laptop-house"></i> Course</h2><hr>
            </div>
            <div class="col-12">   
                <a type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createCourse">Create Course</a>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <caption></caption>
                        <thead>
                            <tr class="text-center">
                                <th>Title</th>
                                <th>Created</th>
                                <th>Author</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $res = course::getInstance()->getAll()->getResults();
                                foreach($res as $key => $rec):
                            ?>
                            <tr>
                                <td contenteditable='true' class="course_title"><?php echo '<span class="id_no">'.$rec->course_id.'</span><span>'. $rec->course_name .'</span>'; ?></td>
                                <td><?php echo $rec->date_created; ?></td>
                                <td><?php echo $rec->author; ?></td>
                                <td class="text-center">
                                    <div class="btn-group-sm" role="group" aria-label="Basic example">
                                        <button  type="button" id="<?php echo "edit-".$rec->course_id; ?>" class="btn btn-primary btn-sm" onClick="course_edit(this.id);"><i class="far fa-edit"></i></button>
                                        <button  type="button" id="<?php echo "course-".$rec->course_id."-".$rec->sme; ?>" class="btn btn-success btn-sm" onClick="newUnit(this.id);"><i class="far fa-file-alt"></i></button>
                                        <button  type="button" id="<?php echo "course1-".$rec->course_id; ?>" class="btn btn-danger btn-sm" onClick="deleteCourse(<?php echo $rec->course_id; ?>);"><i class="fas fa-trash-alt"></i></button>
                                        <button  type="button" id="<?php echo "header-".$rec->course_id; ?>" class="btn btn-secondary btn-sm" onClick="viewHeader(<?php echo $rec->course_id; ?>);"><i class="fas fa-headset"></i></button>
                                        <button  type="button" id="<?php echo "footer-".$rec->course_id; ?>" class="btn btn-secondary btn-sm" onClick="viewFooter(<?php echo $rec->course_id; ?>);"><i class="fas fa-shoe-prints"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- New course -->
        <div class="modal fade" id="createCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createCourseLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#212F3C;color:white">
                        <h5 class="modal-title" id="createCourseLabel">Add New Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="cc" name="cc">
                            <div class="form-group">
                                <label for="new_course">Course Name to Create</label>
                                <input type="text" class="form-control" name="new_course" id="new_course" placeholder="New Course Name">
                            </div>
                            <div class="form-group">
                                <label for="sme_name_course">SME</label>
                                <select class="form-select" aria-label="An Select" id="sme_name_course" name="sme_name_course">
                                    <option value="" disabled selected hidden>Please Choose SME</option>
                                    <?php 
                                        $res = db::getInstance()->get('users',array('user_type','=','3'))->getResults();
                                        foreach($res as $key=>$rec):
                                    ?>
                                    <option value="<?php echo $rec->user_id; ?>"><?php echo $rec->user_first_name.' '.$rec->user_last_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="create_course" onClick="createCourse();">Create Course</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                
                </div>
            </div>
        </div>
        
        <!-- Edit course -->
        <div class="modal fade" id="editCourse" tabindex="-1" aria-labelledby="editCourseLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#212F3C;color:white">
                        <h5 class="modal-title" id="editCourseLabel">Edit / View Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" id="edit_unit_list">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>Unit Name</th>
                                        <th>Created</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="create_unit" onClick="ordPermanent();">Make order list Permanent</button>
                    </div>
                    </div>
                
                </div>
            </div>
        </div>

        <!-- New Unit -->
        <div class="modal fade" id="createUnit" tabindex="-1" aria-labelledby="createUnitLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header"  style="background-color:#212F3C;color:white">
                    <h5 class="modal-title" id="createUnitLabel">Add New Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="new_unit">Unit Name to Create</label>
                            <input type="text" class="form-control mt-1" name="new_unit" id="new_unit" placeholder="New Unit Name">
                        </div>
                        <div class="form-group">
                            <label for="new_unit">Page Title</label>
                            <input type="text" class="form-control mt-1" name="page_title" id="page_title" placeholder="New Unit Name">
                        </div>
                        <div class="form-group" id="sme1">
                            <label for="sme_name">SME</label>
                            <select class="form-select" aria-label="Default select example" id="sme_name" name="sme_name">
                                <option value="" disabled selected hidden>Please Choose SME</option>
                                <?php 
                                    $res = db::getInstance()->get('users',array('user_type','=','3'))->getResults();
                                    foreach($res as $key=>$rec):
                                ?>
                                <option value="<?php echo $rec->user_id; ?>"><?php echo $rec->user_first_name.' '.$rec->user_last_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="create_unit" onClick="createUnit();">Create Unit</button>
                </div>
                </div>
            </div>
        </div>

        <!-- View Header -->
        <div class="modal fade" id="viewHeader" tabindex="-1" aria-labelledby="viewHeaderLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header"  style="background-color:#212F3C;color:white">
                    <h5 class="modal-title" id="viewHeaderLabel"><i class="fas fa-headset"></i> View Header</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Header codes here" id="headerText" style="height: 200px"></textarea>
                            <label for="headerText">Header Codes</label>
                        </div>
                    </form>                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="create_unit" onClick="updateHeader();" disabled>Update</button>
                </div>
                </div>
            </div>
        </div>

        <!-- View Footer -->
        <div class="modal fade" id="viewFooter" tabindex="-1" aria-labelledby="viewFooterLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header"  style="background-color:#212F3C;color:white">
                    <h5 class="modal-title" id="viewFooterLabel"><i class="fas fa-shoe-prints"></i> View Footer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="frmUpdateFooter">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Header codes here" id="footerText" name="footerText" style="height: 200px"></textarea>
                            <label for="footerText">Footer Codes</label>
                        </div>
                    </form>                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-id="" id="update-footer" onClick="updateFooter();">Update</button>
                </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
function createCourse()
{
    let myForm = document.getElementById('cc');
    let formData = new FormData(myForm);
    $.ajax({
        type: 'POST',
        url: '../admin/create_course.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        success:function(response)
        { 
            alert(response.Message);
            $("#newUser").modal("hide");
            localtion.remoad();
        },
        error:function(response){
            alert("Something went serious Wrong!");
        }
    });      
}

function course_edit(e)
{
    var n = e.indexOf("-")+1;
    var no = e.substr(n,e.length);
    $.ajax({
        type: "POST",
        url:'./edit_course.php',
        data:{course:no},
        success: function(data)
        {
            var rowContent = '';
            
            var x = JSON.parse(data);
            var le = x.length;
            for(p = 0; p< le; p++)
                rowContent +='<tr><td class="d-none unitID">'+ x[p]['unit_id'] +'</td><td>'+x[p]['unit_name']+'</td><td>'+x[p]['unit_created']+'</td><td>'+x[p]['unit_author']+'</td><td><a  type="button" id="read_unit-'+x[p]["unit_id"]+'" class="btn btn-success btn-sm" href="read_course.php?id='+x[p]["unit_id"]+'&amp;course='+no+'">Edit</a></td></tr>'
            
            $('#edit_unit_list tbody').html(rowContent);
        }
    });

    $('#editCourse').modal("show");
}

function newUnit(e)
{
    var n = e.split('-');
    $('#createUnit').data("course",n[1]);
    n[2].length >= 1 ? $('#sme_name').val(n[2]).prop("disabled", true) : $('#sme_name').val("").prop("disabled", false);
    $('#createUnit').modal("show");
}
function createUnit()
{
    var x = $('#createUnit').data("course");
    var unitName = $('#new_unit').val();
    var title = $('#page_title').val();
    var sme = $('#sme_name option:selected').val();

    if(sme == '')
    {
        alert("Please select course SME");
        return;
    }
        
    $.ajax({
        type: "POST",
        url:'../admin/create_unit.php',
        data:{unit:unitName,course:x,sme:sme,pt:title},
        dataType: 'json',
        success: function(response){
            alert(response.Message);
            $('#new_course').modal("hide");
            location.reload();
        },
        error: function(){
            alert("it sucks");
        }
});
}
function readUnit(e)
{
    $.ajax({url:'../index-backup.php?love="none"'});
}

$('.course_title').unbind().focusout(function(){
    newID = $(this).children('.id_no').text();
    newText = $(this).children('span').next().text();
    
    $.ajax({
        type:  "POST",
        url: 'cname_update.php',
        data: {id:newID,val:newText},
        success: function(data)
        {
            alert("success");
        }
    });
})

function deleteCourse(e)
{
    var response = confirm("Are you Sure you want to delete this course\nIt will also delete all related units file. The Operation Cannot be Undone!");
    if(response)
    {
        $.ajax({
            type: "POST",
            url:'../admin/delete_course.php',
            data:{id:e},
            success: function(data)
            {
                location.reload();
            }
        });
    }else{
        alert("Void");
    }
}

function viewHeader(e){
    $.ajax({
        type: "POST",
        url:'../admin/get_header.php',
        data:{cid:'1'},
        dataType: 'json',
        success: function(response){
            $('#headerText').html(response.message);
            $('#viewHeader').modal('show');
        },
        error: function(){
            alert("Something wrong happen.");
        }

    });
}
function viewFooter(e){
    $('#update-footer').data('id',e);
    $.ajax({
        type: "POST",
        url:'../admin/get_footer.php',
        data:{cid:'1'},
        dataType: 'json',
        success: function(response){
            $('#footerText').html(response.message);
            $('#viewFooter').modal('show');
        },
        error: function(){
            alert("Something wrong happen.");
        }

    });
}

function updateFooter(){
    let myForm = document.getElementById('frmUpdateFooter');
    let formData = new FormData(myForm);
    formData.append('id',$('#update-footer').data('id'));
    $.ajax({
        type: 'POST',
        url: '../admin/update_footer.php',
        data: formData,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        success:function(response)
        { 
            alert(response.message);
            $("#viewFooter").modal("hide");
        },
        error:function(response){
            alert("Something went Wrong.");
        }
    });  
}
function updateHeader(e){

}
$('#table').sortable({
       items: "tr",
        cursor:"move",
        // update: function(event, ui) {
        //     var ary = [];
        //     $(function () {
        //         $('.table tbody tr').each(function (a, b) {
        //             var uid = $('.unitID', b).text();
        //             if(uid != "") ary.push({ unit_id: uid});
                
        //         });
        //         alert(JSON.stringify( ary));
        //     });
        // }
});
function ordPermanent(){
        var ary = [];
        $('#table tbody tr').each(function (a, b) {
            var uid = $('.unitID', b).text();
            if(uid != "") ary.push({ unit_id: uid});
        });
        
        $.ajax({
            type: 'POST',
            url: '../admin/sort_unit.php',
            data: {srt:ary},
            dataType: 'json',
            success:function(response)
            { 
                alert(response.message);
            },
            error:function(response){
                alert("Sucks");
            }
        });  
    }
</script>

<?php
    require_once("../assets/inc/footer.php");
?>
