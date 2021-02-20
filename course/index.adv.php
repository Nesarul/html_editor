<?php
    require_once('../admin/db/db.php');
    require_once('../admin/function.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    if($data->type === "3")
        header("Location: ../dashboard/index.php");
    
    require_once('../assets/inc/header.php');        
?>
<style>
    .table {
        border: 1px solid #ccc;
        border-collapse: collapse;
    }
    .table th, .table td {
        border: 1px solid #ccc;
    }
    .table th, .table td {
        padding: 0.5rem;
    }
    .draggable {
        cursor: move;
        user-select: none;
    }
    .placeholder {
        background-color: #edf2f7;
        border: 2px dashed #cbd5e0;
    }
    .clone-list {
        border-top: 1px solid #ccc;
    }
    .clone-table {
        border-collapse: collapse;
        border: none;
    }
    .clone-table th, .clone-table td {
        border: 1px solid #ccc;
        border-top: none;
        padding: 0.5rem;
    }
    .dragging {
        background: #fff;
        border-top: 1px solid #ccc;
        z-index: 999;
    }
    </style>
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
        <!-- <div class="modal fade" id="createCourse" name="createCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createCourseLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#212F3C;color:white">
                        <h5 class="modal-title" id="createCourseLabel">Add New Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="cc" name="cc">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-6 col-12">
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
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="css_file" class="form-label">CSS File(s)</label>
                                                <input class="form-control" type="file" id="css_file" name="css_file[]" multiple  accept=".css">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="js_files" class="form-label">JS File(s)</label>
                                                <input class="form-control" type="file" id="js_files" name="js_files[]" multiple accept=".js">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                                                      
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="create_course" onClick="createCourse();">Create Course</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                
                </div>
            </div>
        </div> -->
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
                                        <th data-type="number">No.</th>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            alert("Sucks");
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
                rowContent +='<tr><td>'+ p +'</td><td>'+x[p]['unit_name']+'</td><td>'+x[p]['unit_created']+'</td><td>'+x[p]['unit_author']+'</td><td><a  type="button" id="read_unit-'+x[p]["unit_id"]+'" class="btn btn-success btn-sm" href="read_course.php?id='+x[p]["unit_id"]+'">Edit</a></td></tr>'
            
            $('#edit_unit_list tbody').html(rowContent);
            // $('#table tbody').html(rowContent);
            run_as();
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

  /* 
    Code copied from : 
    https://htmldom.dev/drag-and-drop-table-row/

    Source Code found Here: 
    https://github.com/phuoc-ng/html-dom/blob/master/demo/drag-and-drop-table-row/index.html
  */
function run_as(){
    // alert("Success");
//   });
//     document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('table');

    let draggingEle;
    let draggingRowIndex;
    let placeholder;
    let list;
    let isDraggingStarted = false;

    // The current position of mouse relative to the dragging element
    let x = 0;
    let y = 0;

    // Swap two nodes
    const swap = function(nodeA, nodeB) {
        const parentA = nodeA.parentNode;
        const siblingA = nodeA.nextSibling === nodeB ? nodeA : nodeA.nextSibling;

        // Move `nodeA` to before the `nodeB`
        nodeB.parentNode.insertBefore(nodeA, nodeB);

        // Move `nodeB` to before the sibling of `nodeA`
        parentA.insertBefore(nodeB, siblingA);
    };

    // Check if `nodeA` is above `nodeB`
    const isAbove = function(nodeA, nodeB) {
        // Get the bounding rectangle of nodes
        const rectA = nodeA.getBoundingClientRect();
        const rectB = nodeB.getBoundingClientRect();

        return (rectA.top + rectA.height / 2 < rectB.top + rectB.height / 2);
    };

    const cloneTable = function() {
        const rect = table.getBoundingClientRect();
        const width = parseInt(window.getComputedStyle(table).width);

        list = document.createElement('div');
        list.classList.add('clone-list');
        list.style.position = 'absolute';
        //list.style.left = `${rect.left}px`;
        list.style.left = '1rem';
        // list.style.top = `${rect.top}px`;
        list.style.top = '1rem';
        table.parentNode.insertBefore(list, table);

        // Hide the original table
        table.style.visibility = 'hidden';

        table.querySelectorAll('tr').forEach(function(row) {
            // Create a new table from given row
            const item = document.createElement('div');
            item.classList.add('draggable');

            const newTable = document.createElement('table');
            newTable.setAttribute('class', 'clone-table');
            newTable.style.width = `${width}px`;

            const newRow = document.createElement('tr');
            const cells = [].slice.call(row.children);
            cells.forEach(function(cell) {
                const newCell = cell.cloneNode(true);
                newCell.style.width = `${parseInt(window.getComputedStyle(cell).width)}px`;
                newRow.appendChild(newCell);
            });

            newTable.appendChild(newRow);
            item.appendChild(newTable);
            list.appendChild(item);
        });
    };

    const mouseDownHandler = function(e) {
        // Get the original row
        const originalRow = e.target.parentNode;
        draggingRowIndex = [].slice.call(table.querySelectorAll('tr')).indexOf(originalRow);

        // Determine the mouse position
        x = e.clientX;
        y = e.clientY;

        // Attach the listeners to `document`
        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', mouseUpHandler);
    };

    const mouseMoveHandler = function(e) {
        if (!isDraggingStarted) {
            isDraggingStarted = true;

            cloneTable();

            draggingEle = [].slice.call(list.children)[draggingRowIndex];
            draggingEle.classList.add('dragging');
            
            // Let the placeholder take the height of dragging element
            // So the next element won't move up
            placeholder = document.createElement('div');
            placeholder.classList.add('placeholder');
            draggingEle.parentNode.insertBefore(placeholder, draggingEle.nextSibling);
            placeholder.style.height = `${draggingEle.offsetHeight}px`;
        }

        // Set position for dragging element
        draggingEle.style.position = 'absolute';
        draggingEle.style.top = `${draggingEle.offsetTop + e.clientY - y}px`;
        draggingEle.style.left = `${draggingEle.offsetLeft + e.clientX - x}px`;

        // Reassign the position of mouse
        x = e.clientX;
        y = e.clientY;

        // The current order
        // prevEle
        // draggingEle
        // placeholder
        // nextEle
        const prevEle = draggingEle.previousElementSibling;
        const nextEle = placeholder.nextElementSibling;
        
        // The dragging element is above the previous element
        // User moves the dragging element to the top
        // We don't allow to drop above the header 
        // (which doesn't have `previousElementSibling`)
        if (prevEle && prevEle.previousElementSibling && isAbove(draggingEle, prevEle)) {
            // The current order    -> The new order
            // prevEle              -> placeholder
            // draggingEle          -> draggingEle
            // placeholder          -> prevEle
            swap(placeholder, draggingEle);
            swap(placeholder, prevEle);
            return;
        }

        // The dragging element is below the next element
        // User moves the dragging element to the bottom
        if (nextEle && isAbove(nextEle, draggingEle)) {
            // The current order    -> The new order
            // draggingEle          -> nextEle
            // placeholder          -> placeholder
            // nextEle              -> draggingEle
            swap(nextEle, placeholder);
            swap(nextEle, draggingEle);
        }
    };

    const mouseUpHandler = function() {
        // Remove the placeholder
        placeholder && placeholder.parentNode.removeChild(placeholder);
        
        draggingEle.classList.remove('dragging');
        draggingEle.style.removeProperty('top');
        draggingEle.style.removeProperty('left');
        draggingEle.style.removeProperty('position');

        // Get the end index
        const endRowIndex = [].slice.call(list.children).indexOf(draggingEle);

        isDraggingStarted = false;

        // Remove the `list` element
        list.parentNode.removeChild(list);

        // Move the dragged row to `endRowIndex`
        let rows = [].slice.call(table.querySelectorAll('tr'));
        draggingRowIndex > endRowIndex
            ? rows[endRowIndex].parentNode.insertBefore(rows[draggingRowIndex], rows[endRowIndex])
            : rows[endRowIndex].parentNode.insertBefore(rows[draggingRowIndex], rows[endRowIndex].nextSibling);

        // Bring back the table
        table.style.removeProperty('visibility');

        // Remove the handlers of `mousemove` and `mouseup`
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', mouseUpHandler);
    };

    table.querySelectorAll('tr').forEach(function(row, index) {
        // Ignore the header
        // We don't want user to change the order of header
        if (index === 0) {
            return;
        }

        const firstCell = row.firstElementChild;
        firstCell.classList.add('draggable');
        firstCell.addEventListener('mousedown', mouseDownHandler);
    });
// });
}

</script>

<?php
    require_once("../assets/inc/footer.php");
?>
