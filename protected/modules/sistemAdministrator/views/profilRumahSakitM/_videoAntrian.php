<?php

$res = scandir(Params::pathVideoAntrian());

//var_dump($res); die;

$res_dat = array();
foreach ($res as $item) {
    if (in_array($item, array('.', '..', 'logo.gif'))) {
        continue;
    }
    
    $res_dat[] = $item;
}



?>

<div class="control-group">
    <label class="control-label">Upload Video</label>
    <div class="controls">
        <?php echo CHtml::fileField('upload_video_antrian', null, array(
            'id'=>'upload_video_antrian',
        )); ?>
        <?php echo CHtml::htmlButton('Upload', array('class'=>'btn btn-success', 'id'=>'btn_upload_video_antrian', 'onclick'=>'uploadFile();')); ?>
        <p></p>
        <div class="progress" style="display:none ;" >
            <div id="file-progress-bar" class="progress-bar" ></div>
        </div>
    </div>
</div>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>File</th>
            <th width="70">Hapus</th>
        </tr>
    </thead>
    <tbody class="tab_video_antrian">
        <?php foreach ($res_dat as $item): ?>
        <tr>
            <td class="nama_upload_antrian" data-nama="<?php echo $item; ?>"><?php echo $item; ?></td>
            <td><?php echo CHtml::button('x', array('class'=>'btn btn-danger','onclick'=>'hapusFileUpload(this);')); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script>
    
    function uploadFile() {
        if ($("#upload_video_antrian").val() == "") {
            myAlert("Belum memilih file video yang akan di-upload");
            return false;
        }
        $(".progress").show();
        
        var file_data = $("#upload_video_antrian").prop("files")[0];
        var form_data = new FormData();
        
        if (typeof file_data != 'undefined');
        console.log(file_data);
        
        form_data.append('file', file_data);
        
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            url: '<?php echo $this->createUrl('uploadVideoAntrian'); ?>', // <-- point to server-side PHP script 
            dataType: 'json',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            
            beforeSend: function(){
                $("#file-progress-bar").width('0%');
            },
 
            success: function(data){
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $(".progress").hide();
                    $(".tab_video_antrian").html(data.html);
                    $("#upload_video_antrian").val("");
                } else {
                    myAlert(data.msg);
                }
            }
         });
    }
    
    function hapusFileUpload(obj) {
    
        var nama = $(obj).parents("tr").find(".nama_upload_antrian").data("nama");
    
        myConfirm("Anda yakin untuk menghapus file video ini ? File yang dihapus tidak akan bisa kembalikan kembali.", "Perhatian", function(d) {
            if (d) {
                $.post('<?php echo $this->createUrl('hapusVideoAntrian'); ?>', {nama: nama}, function(data) {
                    if (data.ok == 1) {
                        $(obj).parents("tr").remove();
                        myAlert(data.msg);
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
</script>