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
        <div class="p-card" style="background-color:white">
            <div class="row">
            <div class="col-12"><h2 style="border-bottom:1px solid #999"><i class="fab fa-windows"></i> Dashboard</h2></div>
            <div class="col-md-4 col-12 my-3 <?php if($data->type === "3") echo 'd-none'; ?> ">
                <div class="info-graph" style = "--bg-color:rgba(128,128,192,0.9);">
                    <div class="screen">
                        <?php 
                            $sql = "SELECT COUNT(*) AS ttl_user FROM users";
                            $res = db::getInstance()->query($sql)->getResults();
                        ?>
                        <p class="title"><?php echo $res[0]->ttl_user; ?><span>Total Users</span></p>
                        <a href="../users/index.php" class="more-info"  class="more-info" style="--bg-color:rgba(96,96,176,1)">More Info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 my-3 <?php if($data->type === "3") echo 'd-none'; ?> ">
                <div class="info-graph" style = "--bg-color:rgba(247,170,71,0.9);--bg-icon:'\e066'">
                    <div class="screen">
                        <?php 
                            $sql = "SELECT COUNT(*) AS ttl_course FROM course";
                            $res = db::getInstance()->query($sql)->getResults();
                        ?>
                        <p class="title"><?php echo $res[0]->ttl_course; ?><span>Total Courses</span></p>
                        <a href="../course/index.php" class="more-info" style="--bg-color:rgba(218,140,16,1)">More Info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 my-3">
                <div class="info-graph" style = "--bg-color:rgba(255,98,100,0.9);--bg-icon:'\f057'">
                    <div class="screen">
                        <?php 
                            $sql = "SELECT COUNT(*) AS ttl_units FROM unit WHERE unit_status = '1'";
                            $res = db::getInstance()->query($sql)->getResults();
                        ?>
                        <p class="title"><?php echo $res[0]->ttl_units; ?><span>Total Approved Units</span></p>
                        <a href="../units/closed_units.php" class="more-info" style="--bg-color:rgba(224,86,88,1)">More Info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 my-3">
                <div class="info-graph" style = "--bg-color:rgba(0, 177, 157, 0.9);--bg-icon:'\f07c'">
                    <div class="screen">
                        <?php 
                            $sql = "SELECT COUNT(*) AS ttl_units FROM unit WHERE unit_status = '0'";
                            $res = db::getInstance()->query($sql)->getResults();
                        ?>
                        <p class="title"><?php echo $res[0]->ttl_units; ?><span>Total Open Units</span></p>
                        <a href="../units/index.php" class="more-info" style="--bg-color:rgba(0, 141, 121, 1)">More Info</a>
                    </div>
                </div>                
            </div>
            <div class="col-md-4 col-12 my-3 <?php if($data->type === "3") echo 'd-none'; ?> ">
                <div class="info-graph" style = "--bg-color:rgba(64, 187, 234, 0.9);--bg-icon:'\f0d0'">
                    <div class="screen">
                        <?php 
                            $sql = "SELECT COUNT(*) AS 'ttl_users' FROM users WHERE user_type = 2";
                            $res = db::getInstance()->query($sql)->getResults();
                        ?>
                        <p class="title"><?php echo $res[0]->ttl_users; ?><span>Total Instructional Designers</span></p>
                        <a href="../users/index.php" class="more-info" style="--bg-color:rgba(22, 150, 198, 1)">More Info</a>
                    </div>
                </div>                
            </div>
            <div class="col-md-4 col-12 my-3 <?php if($data->type === "3") echo 'd-none'; ?> ">
                <div class="info-graph" style = "--bg-color:rgba(141, 198, 63, 0.9);--bg-icon:'\f51c'">
                    <div class="screen">
                        <?php 
                            $sql = "SELECT COUNT(*) AS 'ttl_users'  FROM users WHERE user_type = 3";
                            $res = db::getInstance()->query($sql)->getResults();
                        ?>
                        <p class="title"><?php echo $res[0]->ttl_users; ?><span>Total Subject Matter Experts</span></p>
                        <a href="../users/index.php" class="more-info" style="--bg-color:rgba(120, 169, 54, 1)">More Info</a>
                    </div>
                </div>
            </div>
        </div>        
        
        </div>
    </div>
</div>


<?php
    require_once("../assets/inc/footer.php");
?>