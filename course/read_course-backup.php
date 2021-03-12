<?php
    require_once('../admin/db/db.php');
    require_once('../admin/function.php');
    if($data->logStatus != "logged")
        header("Location: ../index.php");
    require_once('../assets/inc/header.php');        

    $id = 0;
    $course = 0;
    $unit = 0;
    $res = null;
    if(isset($_GET['id'])){
        $id = trim($_GET['id']);
        $course = trim($_GET["course"]);
    }

    if($id){
        $res = db::getInstance()->get('unit',array('unit_id','=',$id))->getResults();
        empty($res) ? exit(0): '';
    } else exit(0);
?>
<div class="left-bar">
    <p class="text-center"><img src="../assets/images/logo.png" alt="" width="50%"></p>
    <img src="../assets/images/upload/<?php echo($data->image); ?>" alt="" class="mx-auto d-block rounded-circle" width="50">
    
    <h6>Welcome<br/><?php echo $data->user; ?></h6>
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
<style>
    .tox-statusbar__branding{
        display:none !important;
    }
    .shade{
        background-color:#fff;
        color:black;
    }
</style>
<div class="right-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-3 shade mt-0">
                <h3 class="py-3"><?php if($res != null) echo '<span id=n-"'.$res[0]->unit_id.'" class="unit_name" contenteditable="true">'.$res[0]->unit_name.'</span>'.': <span id=t-"'.$res[0]->unit_id.'" class="unit_title" contenteditable="true">'.$res[0]->unit_title.'</span>'; ?></h4>
            </div>
            <style>
                [class^="notif"]{
                    padding:10px 10px;
                    border-radius:4px;
                    color:white;
                    -webkit-box-shadow: inset 1px 1px 4px 1px rgba(255,255,255,1);
                    -moz-box-shadow: inset 1px 1px 4px 1px rgba(255,255,255,1);
                    box-shadow: inset 1px 1px 4px 1px rgba(255,255,255,1);
                }
                .notif-approved{
                    background-color:#FF5A4B;
                    border:1px solid #3B9C9C;
                }
                .notif-inprogress{
                    background-color:#014421;
                    border:1px solid #baba06;
                }
            </style>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <!-- <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">Select Unit</a> -->
                        <a class="btn btn-outline-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">Select Unit</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php 
                                if($course != ""):
                                    $ut = db::getInstance()->get('unit',array('course_id','=',$course))->getResults();
                                    foreach($ut as $key => $utrec):
                            ?>
                            <li><a class="dropdown-item" href="read_course.php?id=<?php echo $utrec->unit_id; ?>&amp;course=<?php echo $utrec->course_id; ?>"><?php echo $utrec->unit_name.' '.$utrec->unit_title; ?></a></li>
                            <?php endforeach; endif; ?>
                        </ul>
                    </div>
                    <style>.btn-mod,.btn-mod:hover{background-color: #23A6D7;}</style>
                    <div class="col-6">
                        <?php if($res[0]->unit_status != "1"): ?>
                            <p class="text-end"><a href="../output/view.php?uid=<?php echo $id; ?>" class="btn btn-success btn-mod" target="_blank"><i class="far fa-eye"></i> View Page</a> <button type="button" class="btn btn-success notif-inprogress" data-bs-toggle="modal" data-bs-target="#info-sme"><i class="fas fa-lock-open"></i> In Progress</button></p>
                        <?php else: ?>
                            <p class="text-end"><a href="../output/view.php?uid=<?php echo $id; ?>" class="btn btn-success btn-mod" target="_blank"><i class="far fa-eye"></i> View Page</a> <button type="button" class="btn btn-danger notif-approved" onClick="info_adm();"><i class="fas fa-lock"></i> Approved</span></button></p>
                        <?php endif; ?>                
                    </div>
                </div>

                <form form action="post.php" method="post">
                    <input type="hidden" name="idno" value="<?php echo $id; ?>"/>
                    <textarea id="myTextarea" name = "contents">
                        <?php 
                            if($res != null)
                            {
                                // echo htmlspecialchars_decode($res[0]->unit_contents);
                                echo $res[0]->unit_contents;
                            }
                        ?>
                    </textarea>
                </form>
            </div>
            <div class="col-12">
               <!-- Modal -->
                <div class="modal fade" id="info-sme" tabindex="-1" aria-labelledby="info-smeLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="info-smeLabel">Please Confirm</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to digitally sign-off on this page and call it complete and approved?</p>
                                <h4 class="my-4 text-center"><?php echo $data->user; ?></h4>
                                
                                <style>
                                    .agreement-stripe{
                                        width:100%;
                                        padding:15px 0;
                                        margin:0;
                                        background-color:rgb(96,8,8);
                                        color:white;
                                    }
                                </style>
                                <div class="agreement-stripe">
                                    <div class="text-center">
                                        <input type="checkbox" class="form-check-input" id="chk_agreement">
                                        <label class="form-check-label" for="chk_agreement">I hereby state this information is complete and approved.</label>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="bn-agree" disabled>Agree</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="info-adm" tabindex="-1" aria-labelledby="info-admLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:rgb(96,8,8); color:white;">
                                <h5 class="modal-title" id="info-admLabel"><i class="fas fa-user-check"></i> Please Confirm</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                <p>Are you sure you want to rollback this page so that it becomes &ldquo;In Progress&rdquo; again?</p>
                                <h4 class="my-4 text-center"><?php echo $data->user; ?></h4>
                                
                                <style>
                                    .agreement-stripe{
                                        width:100%;
                                        padding:15px 0;
                                        margin:0;
                                        background-color:rgb(96,8,8);
                                        color:white;
                                    }
                                    .btn-close {background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;}
                                </style>
                                <div class="agreement-stripe">
                                    <div class="text-center">
                                        <input type="checkbox" class="form-check-input" id="chk_agreement-2">
                                        <label class="form-check-label" for="chk_agreement-2">I hereby state this information is incomplete.</label>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="bn-agree-2" disabled>Agree</button>
                            </div>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $.ajax({
            type: "POST",
            url:'status.php',
            dataType: 'json',
            data:{id:<?php echo $id; ?>,course:<?php echo $course; ?>},
            success: function(response){
                tinymce.activeEditor.setMode(response.message != "0" ? 'readonly' : 'design');
            },
            error: function(){
                alert("something went wrong")
            }
        });
    });

    function info_adm(){
        var x = <?php echo $data->type; ?>;
        if(x != '1')
        {
            alert("Only Administrator can roll-back a unit.");
            return;
        }
        $('#info-adm').modal('show');
    }
    
    $('#bn-agree').on('click',function(){
        $.ajax({
            type: "POST",
            url:'../admin/approve_unit.php',
            dataType: 'json',
            data:{id:<?php echo $id; ?>},
            success: function(response){
                $('#info-sme').modal("hide");
                location.reload();
            },
            error: function(){

            }
        });
    });
    $('#chk_agreement').on('click',function(){
        if($('#chk_agreement').prop('checked'))
            $('#bn-agree').prop('disabled', false);
        else $('#bn-agree').prop('disabled', true);
        
    })

    $('#chk_agreement-2').on('click',function(){
        if($('#chk_agreement-2').prop('checked'))
            $('#bn-agree-2').prop('disabled', false);
        else $('#bn-agree-2').prop('disabled', true);
        
    })
    $('#bn-agree-2').on('click',function(){
        $.ajax({
            type: "POST",
            url:'../admin/rollback_unit.php',
            dataType: 'json',
            data:{id:<?php echo $id; ?>},
            success: function(response){
                $('#info-adm').modal("hide");
                location.reload();
            },
            error: function(){

            }
        });
    });
    
$('[class^="unit_"]').unbind().focusout(function(){
    var text = $(this).text();
    var id = $(this).attr('id').split('-');

    $.ajax({
        type:  "POST",
        url: 'uname_update.php',
        data: {id:id[1],val:text,type:id[0]},
        success: function(data)
        {
           
        }
    });
});
</script>
<script>
    $('.js-toexpand').click(function(){
        $(this).toggleClass('ico');
        $(this).next('.js-expand_more').slideToggle('slow');
    });
</script>
<?php
    require_once("../assets/inc/footer.php");
?>