
<?php require_once(dirname(__FILE__) . '/index.php'); ?>
<div class="container">
<form method="post" enctype="multipart/form-data">
    <p><?=__('selected_files')?></p>
    <span id="upload-file-info"><ul><li><?=__('no_selected_files')?></li></ul></span>
    <div class="input-group file-preview">

						<span class="input-group-btn">
						<!-- file-preview-input -->
						<div class="btn btn-default file-preview-input"><span
                                class="glyphicon glyphicon-folder-open"></span> <span class="file-preview-input-title"><?=__('browse')?></span>
                            <input id="fileupload" type="file" name="files[]" multiple />
                            <script>
                                $("#fileupload").change(function() {
                                    var names = '';
                                    for (var i = 0; i < $(this).get(0).files.length; ++i) {
                                        names += '<li><i class="glyphicon glyphicon-picture" aria-hidden="true"></i>  '+($(this).get(0).files[i].name)+'</li>';
                                    }
                                    $("#upload-file-info ul").html(names);
                                });
                            </script>
                            <!-- rename it -->
                        </div>
						<button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i
                                    class="glyphicon glyphicon-upload"></i> </span><?=__('upload')?>
                        </button>
						</span></div>
</form>
<div id="dragandrophandler">

    <?= __('drag_drop_files') ?>

</div>
<div id="status1"></div>
<script>
    function sendFileToServer(formData,status)
    {
        var uploadURL ="<?=createUrl('admin','upload')?>"; //Upload URL
        var extraData ={}; //Extra Data.
        var jqXHR=$.ajax({
            xhr: function() {
                var xhrobj = $.ajaxSettings.xhr();
                if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }
                return xhrobj;
            },
            url: uploadURL,
            type: "POST",
            contentType:false,
            processData: false,
            cache: false,
            data: formData,
            success: function(data){
                status.setProgress(100);
                if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
                    replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
                    replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                        eval('var datao = ' + data);
                        if(data.error == '401') {
                            $("#status1").append("<p><?=__('file_upload_failed')?> "+data.status+"</p>");
                        } else if (datao.extraCommand != undefined) {
                            eval(datao.extraCommand);
                            $('#loader-backGround, #loader').fadeOut().remove();
                        }
                } else {
                    $('#body').append('<div class="box-message"><div class="alert alert-warning pop-up" role="alert">'+data+'</div></div>');
                    setTimeout(function(){
                        $('.alert').remove();
                    }, 5000);
                }
            }
        });

        status.setAbort(jqXHR);
    }

    var rowCount=0;
    function createStatusbar(obj)
    {
        rowCount++;
        var row="odd";
        if(rowCount %2 ==0) row ="even";
        this.statusbar = $("<div class='statusbar "+row+"'></div>");
        this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
        this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
        this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
        this.abort = $("<div class='abort'><?=__('abort')?></div>").appendTo(this.statusbar);
        obj.after(this.statusbar);

        this.setFileNameSize = function(name,size)
        {
            var sizeStr="";
            var sizeKB = size/1024;
            if(parseInt(sizeKB) > 1024)
            {
                var sizeMB = sizeKB/1024;
                sizeStr = sizeMB.toFixed(2)+" MB";
            }
            else
            {
                sizeStr = sizeKB.toFixed(2)+" KB";
            }

            this.filename.html(name);
            this.size.html(sizeStr);
        }
        this.setProgress = function(progress)
        {
            var progressBarWidth =progress*this.progressBar.width()/ 100;
            this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
            if(parseInt(progress) >= 100)
            {
                this.abort.hide();
            }
        }
        this.setAbort = function(jqxhr)
        {
            var sb = this.statusbar;
            this.abort.click(function()
            {
                jqxhr.abort();
                sb.hide();
            });
        }
    }
    function handleFileUpload(files,obj)
    {
        for (var i = 0; i < files.length; i++)
        {
            var fd = new FormData();
            fd.append('file', files[i]);

            var status = new createStatusbar(obj); //Using this we can set progress.
            status.setFileNameSize(files[i].name,files[i].size);
            sendFileToServer(fd,status);

        }
    }
    $(document).ready(function()
    {
        var obj = $("#dragandrophandler");
        var obj1 = $("#fileupload");
        $( "form" ).submit(function(e) {
            e.preventDefault();
            var files = obj1[0].files;
            handleFileUpload(files,obj);
        });
        obj.on('dragenter', function (e)
        {
            e.stopPropagation();
            e.preventDefault();
            $(this).css('border', '2px solid #0B85A1');
            $(this).css('opacity', '1');
        });
        obj.on('dragover', function (e)
        {
            e.stopPropagation();
            e.preventDefault();
        });
        obj.on('drop', function (e)
        {

            $(this).css('border', '2px dotted #0B85A1');
            e.preventDefault();
            var files = e.originalEvent.dataTransfer.files;

            //We need to send dropped files to Server
            handleFileUpload(files,obj);
        });
        $(document).on('dragenter', function (e)
        {
            e.stopPropagation();
            e.preventDefault();
        });
        $(document).on('dragover', function (e)
        {
            e.stopPropagation();
            e.preventDefault();
            obj.css('border', '2px dotted #0B85A1');
        });
        $(document).on('drop', function (e)
        {
            e.stopPropagation();
            e.preventDefault();
        });

    });
</script>
</div>