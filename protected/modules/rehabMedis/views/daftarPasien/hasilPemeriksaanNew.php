<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => Yii::app()->request->getUrlReferrer(),
    'Rehabilitasi Medis',
);
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hasilpmeriksaan-rehabMedis-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',  'enctype' => 'multipart/form-data'),
));

$sudah_input = false;
foreach ($modHasilPemeriksaanrm as $item) {
    if (!empty($item->hasilpemeriksaanrm) || !empty($item->keteranganhasilrm) || !empty($item->evaluasi)) {
        $sudah_input = true;
    }
}

$sudah_input = $sudah_input && $this->module->id == 'mcu';

if ($sudah_input) {
    Yii::app()->user->setFlash('warning', 'Hasil fisioterapi sudah diinput.');
}
$tindakanTerapi = [];
if(!empty($modPasienPenunjang->tindakanterapi_rehab)) {
    $tindakanTerapi = explode(',', $modPasienPenunjang->tindakanterapi_rehab);
}

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Hasil Rehabilitasi Medis
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div <?php echo $this->module->id == "mcu" ? "hidden" : "" ?>>
            <?php
            $this->renderPartial($this->path_view . '_formDataPasien', array('modPasienPenunjang' => $modPasienPenunjang));
            ?>
        </div>
        <br>
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Riwayat Hasil Rehabilitasi Medis
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tableRiwayatHasilRehab', ['modRiwayat' => $modRiwayat]) ?>
            </div>
        </div>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table width="100%" id="tblFormHasilPemeriksaanRE" class="table table-bordered table-condensed">
                    <thead>
                        <tr style="font-size:11pt">
                            <!--<th>No. Urut Jadwal</th>-->
                            <th>Tindakan</th>
                            <th>Tanggal Pemeriksaan</th>
                            <th>Hasil Pemeriksaan</th>
                            <th>Kesimpulan</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($tindakanTerapi) && !isset($_GET['update'])) {
                                foreach ($tindakanTerapi as $i => $terapi) {
                                    $this->renderPartial('_rowMasukanHasilKosong', ['terapi' => $terapi, 'i' => $i, 'modHasilPemeriksaanrm' => $modHasilPemeriksaanrm]);
                                }
                            } else {
                                $this->renderPartial('_rowMasukanHasil', ['modHasilPemeriksaanrm' => $modHasilPemeriksaanrm]);
                            }
                        ?>
                    </tbody>
                        
                    
                </table>
            </div>
        </div>

        <div class='form-actions'>
            <?php
            if ($sudah_input) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'class' => 'btn btn-danger',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'disabled' => 'true',
                    )
                );
            } else {

                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger', 'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'id' => 'btn_simpan',
                    )
                );
            }
            ?>

            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Batal', array('{icon}' => '<i class="entypo-cancel"></i>')),
                $this->createUrl('index'),
                array(
                    'title' => 'Batal',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>

            <?php
            if ($caraPrint != 'PRINT') {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => 'print(\'PRINT\');'));
            }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/HasilPeriksaPrint', array("pendaftaran_id" => $modPasienPenunjang->pendaftaran_id, "pasien_id" => $modPasienPenunjang->pasien_id, "pasienmasukpenunjang_id" => $modPasienPenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
function print(caraPrint)
{
    if(caraPrint == 'PRINT'){
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=1024px');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js,  CClientScript::POS_HEAD);
?>
<script>
    function fileLoad(obj){
        
        $(obj).parents("td").find('input:file').trigger('click');
    }
    function removeFile(obj){
        $(obj).parents("td").find('input:file').val('');
        $(obj).parents('td').find('.input_nama_dokumen').val('');
        $(obj).parents('td').find('.nama_dokumen').attr('style', 'display:none;');
    }

    async function cekFile(obj) {

        var imageArr = $(obj).context;
        console.log(imageArr.files);
        var cek = $(obj).val();   

        if (cek != ''){
            var imageCount = imageArr.files.length;
            var imageToBig = false;

            for (var p = 0; p < imageArr.files.length; p++){
                var imageSize = imageArr.files[p].size;
                var imageName = imageArr.files[p].name;

                const file = imageArr.files[p];
                const val64 = await fileToBase64(file);

                if (val64 instanceof Error) {
                    console.log('Error: ', result.message);
                    return;
                }

                imageSize = imageSize / (1024 * 1024); //file size in Mb
                
                if (parseInt(imageSize) > 5){
                    myAlert("Ukuran file tidak boleh lebih dari 5mb","perhatian!");
                    $(obj).val("");                 
                    $(obj).parents(".controls").find('.labelbrowse').html('');                
                    return false;
                }else{
                    tambahGambar(imageArr.files[p], val64, obj);
                    $("#simpan_gambar").removeClass('hide');
                }
            
            }
            if(imageToBig){
                //give an alert that at least one image is to big
                window.alert("Ukuran Gambar Terlalu Besar");
                }
        }
    }
    var fileToBase64 = file => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
    function tambahGambar(value_file, val64, obj){
       $(obj).parents('td').find('.nama_gambar').html(value_file.name);
       $(obj).parents('td').find('.input_nama_dokumen').val(value_file.name);
       $(obj).parents('td').find('.nama_dokumen').attr('style', 'display:block;');
        }
    function simpanGambar(obj){
        var formData = new FormData($('#hasilpmeriksaan-rehabMedis-form')[0]);

        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('simpanGambar'); ?>',
            data: formData,           
            dataType: "json",        
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                if (data.sukses == 1){  
                    toastr.success(data.pesan,"Perhatian!");
                }else{
                    toastr.warning(data.pesan,"Perhatian!");
                }               
                $(obj).parents('td').find('.nama_dokumen').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(errorThrown);
            }
        });
        
        
    }
    
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'lihatFile',
    'options' => array(
        'title' => 'Lihat File',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1090,
        'height' => 500,
        'resizable' => true,
       
    ),
));
?>
<iframe id='iframeLihatFile' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>