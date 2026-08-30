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
    // 'focus' => '#HasilpemeriksaantindakanT_0hasilpemeriksaantindakan',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'enctype' => 'multipart/form-data'),
));

$sudah_input = false;
foreach ($modHasilPemeriksaan as $item) {
    if (!empty($item->hasilpemeriksaanrm) || !empty($item->keteranganhasilrm) || !empty($item->evaluasi)) {
        $sudah_input = true;
    }
}

$sudah_input = $sudah_input && $this->module->id == 'mcu';

if ($sudah_input) {
    Yii::app()->user->setFlash('warning', 'Hasil fisioterapi sudah diinput.');
}

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Hasil Pemeriksaan
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div <?php echo $this->module->id == "mcu" ? "hidden" : "" ?>>
            <?php
            $this->renderPartial('_formDataPasien', array('modPasienPenunjang' => $modPasienPenunjang));
            ?>
        </div>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel Riwayat Hasil Pemeriksaan
                </div>
            </div>
            <div class="panel-body">
                <?= $this->renderPartial('_tableRiwayatHasilPemeriksan', ['modRiwayat' => $modRiwayat]); ?>
            </div>
        </div>


        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel Hasil Pemeriksaan
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

                        <tr id="jadwal_0">
                           <?php 
                                
                            
                                $nama_tindakan = '<br>';
                                if(!empty($modHasilPemeriksaan)) {
                                    $nama_tindakan = $modHasilPemeriksaan->daftartindakan->daftartindakan_nama ?? '';
                                }
                           ?>
                            <td style="font-size:11pt">
                                
                                <?php
                                    echo Yii::app()->user->getState('ruangan_nama');
                                ?>
                            </td>
                            <td>
                                <?php
                                echo CHtml::hiddenField('HasilpemeriksaantindakanT[hasilpemeriksaantindakan_id]', $modHasilPemeriksaan->hasilpemeriksaantindakan_id);
                                if(empty($modHasilPemeriksaan->tglpemeriksaantindakan)) {
                                    $modHasilPemeriksaan->tglpemeriksaantindakan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
                                }
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modHasilPemeriksaan,
                                    'attribute'=>'tglpemeriksaantindakan',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        // 'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3', 'readonly' => true),
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                //                    echo CHtml::textArea('hasilpemeriksaanrm[keteranganhasilrm][]',$hasilpemeriksaan->keteranganhasilrm).'</br></br>';  
                                $this->widget('ext.redactorjs.Redactor', array('model' => $modHasilPemeriksaan, 'attribute' => 'hasilpemeriksaantindakan', 'toolbar' => 'mini', 'height' => '200px'));
                                ?>
                            </td>
                            <td>
                                <?php
                                //                    echo CHtml::textArea('hasilpemeriksaanrm[peralatandigunakan][]',$hasilpemeriksaan->peralatandigunakan).'</br></br>'; 
                                $this->widget('ext.redactorjs.Redactor', array('model' => $modHasilPemeriksaan, 'attribute' => 'kesimpulantindakan', 'toolbar' => 'mini', 'height' => '200px'));
                                ?>
                            </td>
                            <?php 
                            $nameInputFile = 'HasilpemeriksaantindakanT[dokfiletindakan_filepath]'; 
                            $nameInputName = 'HasilpemeriksaantindakanT[dokfiletindakan_nama]'; 
                            ?>
                            <td colspan="4">
                                <?php echo CHtml::link('<i class="fas fa-upload"></i> Upload', 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'btn btn-success')) . '&nbsp;' . CHtml::link("<u></u>", 'javascript:;', array('onclick' => 'fileLoad(this);', 'class' => 'labelbrowse')); ?>
                                <div class="upload" style="display: none;">
                                    <!-- <input type="file" name="<?= $nameInputFile ?>" onchange="cekFile(this)"> -->
                                    <?= CHtml::activeFileField($modHasilPemeriksaan, 'dokfiletindakan_filepath', ['onchange' => 'cekFile(this)']) ?>
                                </div>
                                <div class="nama_dokumen" style="display: none;">
                                    <label for="">Nama Dokumen</label>
                                    <input type="text" name="<?= $nameInputName ?>" class="input_nama_dokumen lebar3">
                                    <button type="button" onclick="removeFile(this)"><i class="fas fa-times"></i></button>
                                    <?php //echo CHtml::link("<i class='" . MyIcon::getIcons('simpan') . "'></i> Simpan File", 'javascript:;', array('onclick' => 'simpanGambar(this);', 'class' => 'btn btn-danger')); ?>
                                </div>
                                <div style="margin-top: 20px;">
                                    <?php if(!empty($modHasilPemeriksaan->dokfiletindakan_filepath)) :  ?>
                                        <img src="<?= Yii::app()->request->baseUrl . '/data/images/hasilPemeriksaanTindakan/'. $modHasilPemeriksaan->dokfiletindakan_filepath ?>" alt="" srcset="" width="200" height="200">

                                        <br>
                                        Nama Dokumen : <b><?= $modHasilPemeriksaan->dokfiletindakan_nama ?? '' ?></b>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>

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