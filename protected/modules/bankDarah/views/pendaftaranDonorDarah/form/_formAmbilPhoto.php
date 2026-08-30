<?php 
    $cs=Yii::app()->clientScript;
    $cs->scriptMap=array(
            'webcam.js'=>false,			
    );
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/webcamjs/webcamjs.min.js',CClientScript::POS_HEAD); 
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Foto Pasien</div>
    </div>
    <div class="panel-body">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="text-align:left">
                        <?php echo CHtml::activeHiddenField($model, 'photopendonor', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($model, 'temp_file', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil Foto', array('{icon}' => '<i class="entypo-camera"></i>')), array('class' => 'btn btn-primary', 'onclick' => "setDialog();",
                            'id' => 'btn-addphoto', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk Ambil Foto'))
                        ?>
                    </td>
                    <td style="text-align:right">
                        <?php $url_photopasien = (!empty($model->photopendonor) ? Params::urlPendonorDirectory() . $model->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
                        <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="84px"/>                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    <?php
    $random = rand(0000000000000000, 9999999999999999);
    ?>
    /**
     * ambil gambar pada Webcam
     * @returns {Boolean}
     */
    function ambilGambar() {
        Webcam.freeze();
        $("#btn_ambil_gambar").attr("disabled", true);
        $("#btn_simpan_gambar").removeAttr("disabled");
    }
    /**
     * menyimpan / meng-upload gambar
     * @returns {undefined}
     */
    function pilihGambar() {
        $("#btn_simpan_gambar").attr("disabled", true);        
        $("#btn_ambil_gambar").removeAttr("disabled");
        Webcam.snap( function(data_uri) {
            $("#photo-preview").attr("src", data_uri);
            $("#<?php echo CHtml::activeId($model, 'photopendonor') ?>").val(data_uri)
        });        
    }
    /**
     * mengulang pengambilan gambar
     * @returns {undefined}
     */
    function ulangGambar() {
        $("#btn_ambil_gambar").removeAttr("disabled");
        $("#btn_simpan_gambar").attr("disabled", true);
        Webcam.unfreeze();        
    }
   

    function take_snapshot() {
            // take snapshot and get image data
            
    }
    /**
     * keterangan setelah berhasil ambil gambar Webcam
     * @returns {Boolean}
     */
    function suksesUpload(msg) {
        if (msg == 'OK') {
            $('#photo-preview').attr('src', '<?php echo Params::urlPendonorDirectory() . "no_photo.jpeg" ?>');
            setTimeout(function () {
                document.getElementById('upload_results').innerHTML = '';
                $("#<?php echo CHtml::activeId($model, 'photopendonor') ?>").val("<?php echo $random ?>.jpg")
                $('#photo-preview').attr('src', '<?php echo Params::urlPendonorTumbsDirectory() . "kecil_" . $random; ?>.jpg');
                $('#dialog-addphoto').dialog('close');
            }, 3000);

        } else {
            myAlert("PHP Error: " + msg);
        }
    }
    
    function detectWebcam(callback) {
        let md = navigator.mediaDevices;
        if (!md || !md.enumerateDevices) return callback(false);
        md.enumerateDevices().then(devices => {
          callback(devices.some(device => 'videoinput' === device.kind));
        })
    }
    
    function setWebcam() {                     
        detectWebcam(function(hasWebcam) {
            if (hasWebcam){
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'png',
                    jpeg_quality: 90
                });      
                Webcam.attach( '#cam-preview' );
            }else{
                return false;
            }
        });       
    }
    
    function setDialog(){
        detectWebcam(function(hasWebcam) {
            if (hasWebcam){                                
                $('#dialog-addphoto').dialog('open');
            }else{
                myAlert("Webcam tidak ditemukan");
                $('#dialog-addphoto').dialog('close');
                return false;
            }
        });      
    }
   
    $(document).ready(function () {

        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
        
        
         <?php if (!isset($_GET['sukses'])) { ?>
            
            setWebcam();
        <?php } ?>
    });
    
    
</script>

<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addphoto',
    'options'=>array(
        'title'=>'Ambil Photo',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>360,
        'minHeight'=>420,
        'resizable'=>false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-cog icon-white"></i>')),array('rel'=>'tooltip','title'=>'Konfigurasi Kamera','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'webcam.configure();','style'=>'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil',array('{icon}'=>'<i class="icon-camera icon-white"></i>')),array('id'=>'btn_ambil_gambar','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'ambilGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-download-alt icon-white"></i>')),array('id'=>'btn_simpan_gambar','disabled'=>true,'class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'pilihGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('id'=>'btn_ulang_gambar','class'=>'btn btn-mini btn-danger', 'type'=>'button', 'onclick'=>'ulangGambar();','style'=>'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>

