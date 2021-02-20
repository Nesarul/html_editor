var entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;',
    '/': '&#x2F;',
    '`': '&#x60;',
    '=': '&#x3D;'
};

function escapeHtml (t) {
    return String(t).replace(/[&<>"'`=\/]/g, function (s) {
        return entityMap[s];
    });
}

$('#course_name').on('change', function() {
    fillUnit($(this).val());
});
$('#unit_no').on('change',function(){
    fillFile($('#course_name').val(),$(this).val());
});
$('#file_name_dropdown').on('change',function(){
    getFileData($('#file_name_dropdown').val());
});
function postVal()
{
    var parent = $('#course_name').val();
    var unitName = $('#unit_name').val();
    $.ajax({
        type: "POST",
        url:'./admin/input_unit.php',
        data:{unit:unitName,parent:parent},
        success: function(data){
            // $('#unit_name').text("done");
            $('#new_unit').modal('toggle');
            fillUnit(parent);
        }
    });
}
function createFile()
{
    var courseId = $('#course_name').val();
    var courseName = $('#course_name :selected').text();
    // alert($('#unit_no').val());
    var unitId = $('#unit_no').val();
    var unitName = $('#unit_no :selected').text();
    
    var fileName = $('#file_name').val();
    var fileTitle = $('#file_title').val();
    var fileHeader = $('#file_header').val();
    if(confirm("You want to create following file: \r\n"+courseName+"\\"+unitName+"\\"+fileName+".html"))
    {   
        $.ajax({
            type: "POST",
            url:'./admin/create_file.php',
            data:{course:courseId,unit:unitId,name:fileName,title:fileTitle,header:fileHeader,cn:courseName,un:unitName},
            success: function(data){
                var result = JSON.parse(data);
                
                $('#file_name_dropdown').empty();
                for(x = 0; x < result.length; x++)
                {
                    $('#file_name_dropdown').append("<option value="+result[x][0]+">"+result[x][1]+"</option>");
                }
                $('#new_file').modal('toggle');
                
            }
        });
    }

}

function fillFile(courseId,unitId)
{
    var pk = [];
    $.ajax({
        type: "POST",
        url: './admin/fill_file.php',
        data:{course:courseId,unit:unitId},
        success: function(data)
        {
            var result = JSON.parse(data);
            $('#file_name_dropdown').empty();
            for(x = 0; x < result.length; x++)
            {
                $('#file_name_dropdown').append("<option value="+result[x]['id_no']+">"+result[x]['file_name']+"</option>");
            }
            getFileData($('#file_name_dropdown').val());
        }
    });
}

function fillUnit(courseId)
{
    var pk = [];
    $.ajax({
        type: "POST",
        url: './admin/fill_units.php',
        data:{course:parseInt(courseId)},
        success: function(data)
        {
            var columns = ['unit_id', 'unit_name', 'course_id'];
            
            var result = JSON.parse(data).map(function(obj) {
              return columns.map(function(key) {
                return obj[key];
              });
            });
            $('#unit_no').empty();
            for(x = 0; x < result.length; x++)
            {
                $('#unit_no').append("<option value="+result[x][0]+">"+result[x][1]+"</option>");
            }
            var unitId = $('#unit_no').val();
            fillFile(courseId,unitId);
        }
    });
}

function updateContent()
{
    // var contents = escapeHtml($('.wmwysiwyg-editor').text());
    var contents = escapeHtml($('.wmwysiwyg-editor').html());
    var fileId = $('#file_name_dropdown').val();
    $.ajax({
        type: "POST",
        url: './admin/update_html.php',
        data: {fileid: fileId,cont:contents},
        success: function(data)
        {
            alert('success!');
        }
    });
}
function getFileData(id)
{
    $.ajax({
        type: "POST",
        url: './admin/get_file_data.php',
        data: {id:id},
        success: function(data)
        {
            var res = JSON.parse(data);
            var a = res[0]['file_contents'];
            x = $.parseHTML( a );
            $('.wmwysiwyg-editor').html($.text(x));
        }
    });
}
