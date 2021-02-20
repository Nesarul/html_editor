<?php
    require_once('../admin/db/db.php');
    require_once('../admin/function.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    if($data->type === "3")
        header("Location: ../dashboard/index.php");
    
    require_once('../assets/inc/header.php');        
?>
<script src="../admin/src/js/jquery-ui/jquery-ui.min.js"></script>
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
                            <tr>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Author</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $res = db::getInstance()->query("SELECT * FROM course")->getResults();
                                foreach($res as $key => $rec):
                            ?>
                            <tr>
                                <td contenteditable='true' class="course_title"><?php echo '<span class="id_no">'.$rec->course_id.'</span><span>'. $rec->course_name .'</span>'; ?></td>
                                <td><?php echo $rec->date_created; ?></td>
                                <td><?php echo $rec->author; ?></td>
                                <td>
                                    <button  type="button" id="<?php echo "edit-".$rec->course_id; ?>" class="btn btn-primary btn-sm" onClick="course_edit(this.id);"><i class="far fa-edit"></i></button>
                                    <button  type="button" id="<?php echo "course-".$rec->course_id."-".$rec->sme; ?>" class="btn btn-success btn-sm" onClick="newUnit(this.id);"><i class="far fa-file-alt"></i></button>
                                    <button  type="button" id="<?php echo "course1-".$rec->course_id; ?>" class="btn btn-danger btn-sm" onClick="deleteCourse(<?php echo $rec->course_id; ?>);"><i class="fas fa-trash-alt"></i></button>
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
                                        <th class="d-none">id</th>
                                        <th>Unit Name</th>
                                        <th>Created</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="create_unit" onClick="ordPermanent();">Make order list Permanent</button>
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

        <!-- Delete Course -->
        <style>.agreement-stripe{width:100%;padding:15px;margin:0;background-color:rgb(96,8,8);color:white;}.btn-close {background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;}</style>
        <div class="modal fade" id="delete_course" data-course="" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete_courseLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header agreement-stripe">
                        <h5 class="modal-title" id="delete_courseLabel"><i class="far fa-folder-open"></i> Delete Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deleting a course will remove all associated units and pages, Do you agree?</p>                    
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
function createCourse()
{
    let myForm = document.getElementById('cc');
    let formData = new FormData(myForm);
    var cm = $('#sme_name_course option:selected').val();
    cm != '' ? formData.append('sme', cm):'';
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
            $("#createCourse").modal("hide");
            location.reload();
        },
        error:function(response){
            alert("Something Wrong Happen.");
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
                rowContent +='<tr><td class="d-none unitID">'+ x[p]['unit_id'] +'</td><td>'+x[p]['unit_name']+' - '+x[p]['unit_title']+'</td><td>'+x[p]['unit_created']+'</td><td>'+x[p]['unit_author']+'</td><td><a  type="button" id="read_unit-'+x[p]["unit_id"]+'" class="btn btn-success btn-sm" href="read_course.php?id='+x[p]["unit_id"]+'">Edit</a></td></tr>'
            
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
    if(unitName == '')
    {
        alert("Please Enter a Unit Name");
        return;
    }
    var title = $('#page_title').val();
    if(title == '')
    {
        alert("Please Enter Unit Title");
        return;
    }
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
            alert("Something wrong happen.");
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
    $('#delete_course').data('course',e);
    $('#delete_course').modal("show");
}


//   $('#table tbody').sortable();

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
        $('.table tbody tr').each(function (a, b) {
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
    $('#btn-confirm-delete').on('click',function(){
        $.ajax({
            type: "POST",
            url:'../admin/delete_course.php',
            data:{id:$('#delete_course').data('course')},
            success: function(data)
            {
                location.reload();
            }
        });
    });
</script>

<?php
    require_once("../assets/inc/footer.php");
?>
