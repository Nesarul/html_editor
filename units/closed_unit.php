<?php
    require_once('../admin/function.php');
    require_once('../admin/db/db.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    if($data->type === "3")
        header("Location: ../dashboard/index.php");
    require_once('../assets/inc/header.php');        
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
    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-12 my-3"><h2 style="color:#1E90FF"><i class="far fa-check-circle"></i> Approved Units <span style="font-size:40%">(Group By Course)</span></h2><hr></div>
            <div class="col-12">
                <?php
                    $sql = "SELECT * FROM course";
                    $res = db::getInstance()->query($sql)->getResults();
                ?>
                
                <style>
                    .accordion-button,
                    .accordion-button:focus,
                    .accordion-button:not(.collapsed) {
                        background-color:#87CEFA;
                        box-shadow:none;
                        margin:2px 0px;
                        color:black;
                        padding: 0.75rem 1.25rem;
                    }
                </style>

                <div class="accordion" id="accordionExample">
                    <?php $i = 0; foreach($res as $key => $rec): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $i; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $i; ?>">
                                <?php echo $rec->course_name; ?>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $i; ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="p-3" style="background-color:white">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No #</th>
                                                    <th>Unit Name</th>
                                                    <th>Approved By</th>
                                                    <th>Admin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql = "SELECT u.unit_id, u.unit_name, u.unit_approved_by, s.user_first_name, s.user_last_name FROM unit AS u LEFT JOIN users AS s ON u.unit_approved_by = s.user_id WHERE u.course_id = ? AND u.unit_status = '1'";
                                                    $p=0;
                                                    $unit_res = db::getInstance()->query($sql,$params=array($rec->course_id))->getResults();
                                                    foreach($unit_res as $key => $e): 
                                                ?>
                                                    <tr>
                                                        <td><?php echo ++$p; ?></td>
                                                        <td><?php echo $e->unit_name; ?></td>
                                                        <td><?php echo $e->user_first_name.' '.$e->user_last_name; ?></td>
                                                        <td>
                                                            <a href="view.php?course=<?php echo $rec->course_id; ?>&unit=<?php echo $e->unit_id; ?>" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                                            <a href="javascript:void(0);" onclick="DeleteUnit(<?php echo $e->unit_id; ?>);" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                                            <a href="javascript:void(0);" onclick="ApproveVoid(<?php echo $e->unit_id; ?>);" class="btn btn-outline-danger btn-sm"><i class="far fa-thumbs-down"></i></a>
                                                        </td>
                                                    </tr>
                                                
                                                <?php endforeach;?> 
                                    
                                            </tbody>  
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ++$i; endforeach; ?>
                </div>
            </div>            
        </div>
    </div>
</div>
<script>
function DeleteUnit(e){
    var answer = confirm("Are you sure, you want to delete this unit? This cannot be undone.");
    if(answer){
        $.ajax({
            type: "POST",
            url:'../admin/delete_unit.php',
            data:{id:e},
            success: function(data)
            {
                location.reload();
                alert(JSON.parse(data));
            }
        });
    }
}

function ApproveVoid(e)
{
    $.ajax({
        type: "POST",
        url:'../admin/un_approve_unit.php',
        data:{id:e},
        success: function(data)
        {
            location.reload();
            alert(JSON.parse(data));
        }
    });    
}
</script>
<?php
    require_once("../assets/inc/footer.php");
?>