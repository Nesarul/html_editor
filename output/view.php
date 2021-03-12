<?php
    require_once('../admin/db/db.php');
    $sql = "SELECT p.page_contents,p.page_caption,p.page_name, c.c_title, c.c_css, c.c_js, c_footer, c.footer_caption 
    FROM pages AS p 
    LEFT JOIN course AS c 
    ON c.course_id = p.course_id 
    WHERE p.page_id = ?";
    $res = db::getInstance()->query($sql,array($_GET['pageID']))->getResults();
    if(null == $res)
        exit(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo($res[0]->c_js); ?>
    <title><?php echo $res[0]->page_name; ?></title>

    <!-- CSS --> 
    <?php echo($res[0]->c_css); ?>
    <script src="https://kit.fontawesome.com/6123117173.js" crossorigin="anonymous"></script>

</head>
<body>
    <?php echo($res[0]->c_title);?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php echo $res[0]->page_contents; ?>
            </div>
        </div>
    </div>

<script>
    $(function(){
        var pc = "<?php echo $res[0]->page_caption; ?>";
        var fc = "<?php echo $res[0]->footer_caption; ?>";
        $('#header-box h1').html(pc);
        $('<style>#footer>.copyright::after{content:"'+fc+'";}</style>').appendTo('head');
    });
</script>

<!-- Footer -->
<?php echo $res[0]->c_footer; ?>

<script src="./js/voice.js"></script>
<script>
$('.custom-bubble').each(function(i){
    $(this).find('.av-btn-speak').attr('id','btn-'+i+1);
    $(this).find('.sp-bubble').attr('id','bub-'+i+1);
    $(this).find('.bbl-main,.bbl-main-r').prepend('<span></span>');
});
$(document).on('click','.av-btn-speak',function(){
    var id = $(this).attr('id');
    // alert(id);
    btnClick(id);
});
</script>
</body>
</html>


