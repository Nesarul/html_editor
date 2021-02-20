<?php
    require_once('../admin/function.php');
    require_once('../admin/db/db.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
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
            <div class="p-3" style="background-color:white">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>No #</th>
                                    <th>Unit Name</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT u.unit_id, u.unit_name,u.course_id, c.course_name FROM unit AS u LEFT OUTER JOIN course AS c ON c.course_id = u.course_id WHERE unit_status = '1' AND unit_sme = ? ORDER BY c.course_name asc";
                                    $p=0;
                                    $unit_res = db::getInstance()->query($sql,$params=array($data->user_id))->getResults();
                                    foreach($unit_res as $key => $e): 
                                ?>
                                    <tr>
                                        <td><?php echo ++$p; ?></td>
                                        <td><?php echo $e->unit_name; ?></td>
                                        <td><?php echo $e->course_name; ?> </td>
                                        <td>Waiting Approve</td>
                                        <td>
                                            <a href="view.php?course=<?php echo $e->course_id; ?>&unit=<?php echo $e->unit_id; ?>" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
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
</div>

<?php
    require_once("../assets/inc/footer.php");
?>