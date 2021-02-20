<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Document</title> -->
    <title><!--TITLE--></title>

        <script src="../admin/src/js/jquery-3.5.1.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> 
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="../assets/css/wmwysiwygeditor.css"> -->
        <script src="https://cdn.tiny.cloud/1/3gn2yb4f3qxldzkrs2lordbzzfsk0qbqngyfnjopb43ayop6/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="../assets/css/custom.css">    
        <link rel="stylesheet" href="../admin/src/css/custom.css">    
    <script>
    tinymce.init({
        selector: '#myTextarea',
        
        height: 450,
        plugins: [
                'save advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code wordcount'
            ],
        toolbar: 'save | undo redo | formatselect | bold italic underline backcolor forecolor | alignleft aligncenter | image | media ' +
        'alignright alignjustify | bullist numlist outdent | removeformat code customInsertButton customCss imageFrame',   
        setup: function (editor) {
            editor.ui.registry.addButton('customInsertButton', {
                text: '<image src="../admin/src/images/n2d.png" style="height: 30px;width: 30px;padding: 3px 0px 0px 0px;"/ >',
                tooltip: 'Note',
                onAction: function (_) {
                    editor.insertContent('<p class="n2d">Note</p>&nbsp;');
                }
            });
            editor.ui.registry.addMenuButton('customCss', {
                text: 'CSS',
                fetch: function (callback) {
                    var items = [
                        {
                            type: 'menuitem',
                            text: 'Image Frame',
                            onAction: function (_) {
                                editor.insertContent('<div class="container-75"><img src="../../images/1611746648.jpg" alt="AltText here" class="img-fluid"><div class="image-caption"><p><strong>Title: </strong>Communication</p><p><strong>Source: </strong>Change Source text</p><p><strong>Description: </strong>Description Here</p></div></div>&nbsp;');
                            }
                        },
                        {
                            type: 'menuitem',
                            text: 'Video',
                            onAction: function (_) {
                                editor.insertContent('<div class="video-container"><iframe width="800" height="450" src="https://www.youtube.com/embed/m8THoxuhQ6g" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><div class="image-caption"><p class="info-icon"><strong>Caption: </strong>Medical Terminology, Shortcuts for Pronunciation</p><p class="small-text"><strong>Source: </strong><a href="https://www.youtube.com/watch?v=m8THoxuhQ6g">YouTube</a></p></div><div class="text-center my-3"><a class="js-toexpand" onclick="return false" href="#a">Video Transcript</a><div class="js-expand_more text-left"><p>Transcript Text Here</p></div></div></div>&nbsp;');
                            }
                        },
                        {
                            type: 'menuitem',
                            text: 'DYK',
                            onAction: function (_) {
                                editor.insertContent('<div class="green-highlight-g"><h2 class="dyk"><span>Did You Know?</span></h2><img title="Work Station" style="float: left; margin-right: 25px;" alt="Did You Know" src="../images/did_you_know.png"><div class="row custom-bubble d-flex align-items-center"><p>Add Text here</p></div></div>&nbsp;');
                            }
                        },
                        {
                            type: 'menuitem',
                            text: 'Accordion',
                            onAction: function (_) {
                                ns = prompt('How many accordion do you want?','5');
                                x='<div class="accordion accordion-flush" id="c-accord">';
                                for(i = 0; i < ns; ++i){
                                    x+='<div class="accordion-item"><h2 class="accordion-header" id="flush-heading-'+i+'"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-'+i+'" aria-expanded="false" aria-controls="flush-collapse-'+i+'">Accordion Item #'+i+'</button></h2><div id="flush-collapse-'+i+'" class="accordion-collapse collapse" aria-labelledby="flush-heading-'+i+'" data-bs-parent="#c-accord"><div class="accordion-body">Placeholder content for this accordion,</div></div></div>&nbsp;';
                                }
                                editor.insertContent(x+'</div>');
                            }
                        },
                        {
                            type: 'menuitem',
                            text: 'Long Description',
                            onAction: function (_) {
                                editor.insertContent('<div class="text-center my-3"><a class="js-toexpand" onclick="return false" href="#">Long Description</a><div class="js-expand_more text-left"><p>Insert Text Here</p></div></div>&nbsp;');
                            }
                        },
                        {
                            type: 'nestedmenuitem',
                            text: 'Bubbles',
                            getSubmenuItems: function () {
                                return [
                                    {
                                        type: 'menuitem',
                                        text: 'Left Bubble Male',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="row custom-bubble d-flex align-items-center"><div class="character"><div class="av-image"><img src="../images/av-male.jpg" alt="Male Avatar"></div> <button type="button" class="btn av-btn-speak"  style="--bg-color: #529113; --txt-color:#ffffff">Click to Speak</button></div><div class="sp-bubble d-none"><div class="bbl-main" data-person="0" style="--bg-color: #529113; --txt-color:#ffffff"><p>Insert Bubble Text Here</p></div></div></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Left Bubble Female',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="row custom-bubble d-flex align-items-center"><div class="character"><div class="av-image"><img src="../images/av-female.jpg" alt="Female Avatar"></div> <button type="button" class="btn av-btn-speak"  style="--bg-color: #529113; --txt-color:#ffffff">Click to Speak</button></div><div class="sp-bubble d-none"><div class="bbl-main" data-person="1" style="--bg-color: #529113; --txt-color:#ffffff"><p>Insert Bubble Text Here</p></div></div></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Right Bubble Male',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="row custom-bubble d-flex align-items-center justify-content-end"><div class="sp-bubble d-none"><div class="bbl-main-r" data-person="0" style="--bg-color: #529113; --txt-color:#ffffff"><p>Insert bubble text Here</p></div></div><div class="character"><div class="av-image"><img src="../images/av-male.jpg" alt="Male Avatar"></div> <button type="button" class="btn av-btn-speak"  style="--bg-color: #529113; --txt-color:#ffffff">Click to Speak</button></div></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Right Bubble Female',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="row custom-bubble d-flex align-items-center justify-content-end"><div class="sp-bubble d-none"><div class="bbl-main-r" data-person="1" style="--bg-color: #529113; --txt-color:#ffffff"><p>Insert bubble text Here</p></div></div><div class="character"><div class="av-image"><img src="../images/av-female.jpg" alt="Female Avatar"></div> <button type="button" class="btn av-btn-speak"  style="--bg-color: #529113; --txt-color:#ffffff">Click to Speak</button></div></div>&nbsp;');
                                        }
                                    },
                                ];
                            }
                        },
                        {
                            type: 'nestedmenuitem',
                            text: 'n2d',
                            getSubmenuItems: function () {
                                return [
                                    {
                                        type: 'menuitem',
                                        text: 'Redo Image',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">Redo Image</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Redo Graph/Chart',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">Redo Graph/Chart</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Insert Video',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">Insert Video</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Insert Quiz',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">Insert Quiz</p>&nbsp;');
                                        }
                                    },
                                    
                                    {
                                        type: 'menuitem',
                                        text: 'Start Tabbed Content',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">Start Tabbed Content</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'End Tabbed Content',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">End Tabbed Content</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Start Accordion Content',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">Start Accordion Content</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'End Accordion Content',
                                        onAction: function (_) {
                                            editor.insertContent('<p class="n2d">End Accordion Content</p>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'nestedmenuitem',
                                        text: 'H5P',
                                        getSubmenuItems: function () {
                                            return [
                                                {
                                                    type: 'menuitem',
                                                    text: 'Drag the Words',
                                                    onAction: function (_) {
                                                        editor.insertContent('<p class="n2d">Drag the Words (H5P)</p>&nbsp;');
                                                    }
                                                },
                                                {
                                                    type: 'menuitem',
                                                    text: 'Drag the Image',
                                                    onAction: function (_) {
                                                        editor.insertContent('<p class="n2d">Drag the Image (H5P)</p>&nbsp;');
                                                    }
                                                },
                                                {
                                                    type: 'menuitem',
                                                    text: 'Fill in the Blank',
                                                    onAction: function (_) {
                                                        editor.insertContent('<p class="n2d">Fill in the Blank (H5P)</p>&nbsp;');
                                                    }
                                                },
                                                {
                                                    type: 'menuitem',
                                                    text: 'Insert Multiple Choice',
                                                    onAction: function (_) {
                                                        editor.insertContent('<p class="n2d">Insert Multiple Choice (H5P)</p>&nbsp;');
                                                    }
                                                },
                                                {
                                                    type: 'menuitem',
                                                    text: 'Insert True or False',
                                                    onAction: function (_) {
                                                        editor.insertContent('<p class="n2d">Insert True or False (H5P)</p>&nbsp;');
                                                    }
                                                },
                                            ];
                                        }
                                    },
                                ];
                            }
                        },
                        {
                            type: 'nestedmenuitem',
                            text: 'Table',
                            getSubmenuItems: function () {
                                return [
                                    {
                                        type: 'menuitem',
                                        text: 'Green Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="green-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Blue Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="blue-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Orange Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="orange-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Red Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="red-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Yellow Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="yellow-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'White Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="white-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Lightgrey Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="lightgrey-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Grey Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="grey-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Purple Table',
                                        onAction: function (_) {
                                            editor.insertContent('<table class="purple-table"><caption>Caption Here</caption><thead><tr><th>Column Heading</th><th>Column Heading</th></tr></thead><tbody><tr><td>Cell Content Here</td><td>Cell Content Here</td></tr></tbody></table>&nbsp;');
                                        }
                                    },
                                ];
                            }
                        },
                        {
                            type: 'nestedmenuitem',
                            text: 'Highlight',
                            getSubmenuItems: function () {
                                return [
                                    {
                                        type: 'menuitem',
                                        text: 'Green Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="green-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Grey Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="grey-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'White Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="white-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Red Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="red-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Orange Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="orange-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Yellow Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="yellow-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Black Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="black-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Blue Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="blue-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Purple Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="purple-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: 'Lightgreen Highlight',
                                        onAction: function (_) {
                                            editor.insertContent('<div class="lightgreen-highlight"><h3>Caption Here</h3><p>Contents Here</p></div>&nbsp;');
                                        }
                                    },
                                ];
                            }
                        },
                    ];
                    callback(items);
                }
            });
        },

        images_upload_url: '../assets/inc/upload.php',
        
        // override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '../assets/inc/upload.php');
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        content_css : "../admin/src/css/custom.css",
    });
</script>
<script>
    tinymce.ScriptLoader.load('../admin/src/js/test.js');
    </script>
</head>
<body>