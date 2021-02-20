<?php
    require_once('../admin/function.php');
    require_once('../admin/db/db.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    if($data->type === "3")
        header("Location: ./indexs.php");
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
            <div class="col-12 my-3"><h2 style="color:rgba(0, 141, 121, 1)"><i class="fas fa-folder-open"></i> In Progress <span style="font-size:40%">(Group By Course)</span></h2><hr></div>
            <div class="col-12">
                <?php
                    $sql = "SELECT * FROM course";
                    $res = db::getInstance()->query($sql)->getResults();
                ?>
                
                <style>
                    .accordion-button,
                    .accordion-button:focus,
                    .accordion-button:not(.collapsed) {
                        background-color:rgba(0, 141, 121, 1);
                        box-shadow:none;
                        margin:2px 0px;
                        color:white;
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
                                                    $sql = "SELECT unit_id, unit_name FROM unit WHERE unit_status = '0' AND course_id = ?";
                                                    $p=0;
                                                    $unit_res = db::getInstance()->query($sql,$params=array($rec->course_id))->getResults();
                                                    foreach($unit_res as $key => $e): 
                                                ?>
                                                    <tr>
                                                        <td><?php echo ++$p; ?></td>
                                                        <td><?php echo $e->unit_name; ?></td>
                                                        <td>Waiting Approval</td>
                                                        <td>
                                                            <a href="view.php?course=<?php echo $rec->course_id; ?>&unit=<?php echo $e->unit_id; ?>" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                                            <?php if($data->type != "3"): ?>
                                                                <a href="javascript:void(0);" onclick="DeleteUnit(<?php echo $e->unit_id; ?>);" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                                                <a href="javascript:void(0);" onclick="UpdateUnit(<?php echo $e->unit_id; ?>);" class="btn btn-outline-primary btn-sm"><i class="far fa-check-circle"></i></a>
                                                            <?php endif; ?>
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
    function UpdateUnit(e){
        $.ajax({
            type: "POST",
            url:'../admin/approve_unit.php',
            data:{id:e},
            success: function(data)
            {
                location.reload();
                alert(JSON.parse(data));
            }
        });
    }
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
</script>
<?php
    require_once("../assets/inc/footer.php");
?>