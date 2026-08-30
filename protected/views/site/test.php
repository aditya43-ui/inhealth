<?php $url = Yii::app()->createAbsoluteUrl($this->route) ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset>
    <legend class='rim2'>Import Data From Excel</legend>
<form id="test" enctype="multipart/form-data" action="<?php echo $url; ?>" method='post' class="form-horizontal">

    <div class="control-group" id="widget">
        <label for="namaObat" class="control-label">Masukan Nama Table :</label>
        <div class="controls">
            <?php $this->widget('MyJuiAutoComplete',array(
                    'name'=>'tableName',
                    'source'=>Yii::app()->createUrl('actionAutoComplete/getListTable'),
                    'options'=>array(
                            'minLength'=>'3',
                    ),
                    'htmlOptions'=>array(
                            'size'=>'65'
                    ),
		));?>
            
            <a href="" class="btn btn-info" onclick="createTemplateXcel();return false;">Create Template</a>
        </div>
    </div>
    <div class="control-group">
        <label for="namaObat" class="control-label">Import Excel (.xls, .xlsx) :</label>
        <div class="controls">
            <div class="input-append">
                <input type="file" name="upload" id="upload" onchange="uploadFile();">
            </div>
        </div>
    </div>
    
    <div id="excel"></div>
    <div class="form-actions">
        <input type="submit" class='btn btn-primary' value="Simpan"/>
    </div>
</form>
    </fieldset>
<script type='text/javascript'>
    $("#test").submit(function(){
        valueField = $("#beginValueField").val();
        lastValueField = $("#lastValueField").val();
        tableName = $("#tableName").val();
        if (tableName != ''){
            if (valueField == ''){
                myAlert('Pilih Awal Value yang akan d insert');
                return false;
            }
            else if (lastValueField == ''){
                myAlert('Pilih Akhir Value yang akan d insert');
                return false;
            }else{
                return true;
            }
        }
        else{
            
             
            return false;
        }
    });
    
    function uploadFile(){
        var formData = new FormData($('form')[0]);
        tableName = $("#tableName").val();
        formData.append('tableName',tableName);
//        var serial = $("#test").serialize();
        $.ajax({
            url: '<?php echo $url; ?>',  //server script to process data
            type: 'POST',
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // check if upload property exists
                    myXhr.upload.addEventListener('progress',function(){console.log("testing ath kk");}, false); // for handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            success: function(data){
                $("#excel").html(data);
                $("#widget").show();
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
    
    function createTemplateXcel(){
        tableName = $("#tableName").val();
        if (tableName != ''){
            window.open("<?php echo Yii::app()->createUrl('site/createTemplateXcel'); ?>&tableName="+tableName,"",'location=_new, width=900px');
        }
        else{
            myAlert("Isi Nama Table");
        }
    }
    

    
    function setValueField(obj, value){
        aktif = $("#valueField").val();
        if (aktif == value){
            $("#valueField").val("");
            $(obj).removeClass("no_rek");
        }else if (aktif == ''){
            $("#valueField").val(value);
            $(obj).addClass("no_rek");
        }
    }
</script>