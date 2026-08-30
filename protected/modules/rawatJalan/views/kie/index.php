<?php
$this->breadcrumbs=array(
	'Rujukan Keluar',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<legend class="rim2">Rujukan Keluar Pasien</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kiepasien-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onsubmit'=>'return requiredCheck(this);'),
        // 'focus'=>'#'.CHtml::activeId($model,'lembarobservasipasien_id'),
)); ?>
<div style="overflow-x: auto;max-width: 100%">
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'form-riwayat',
        'content'=>array(
            'content-detailpasien'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat observasi')).'<b> Tabel Riwayat</b>',
                'isi'=>$this->renderPartial($this->path_view.'_list',array(
                        // 'form'=>$form,
                        'modRiwayatKie'=>$modRiwayatKie,
                        // 'modPendaftaran'=>$modPendaftaran
                        ),true),
                'active'=>true,
                ),   
            ),
    )); ?>
</div>
<div class="row-fluid">
</div>   
 <table class="items">
    <div class="row-fluid">
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>    
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
            <?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
            <div class="control-group">             <?php echo $form->labelEx($model,'tgl_kie', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgl_kie',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                // 'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('readonly'=>true),
                        )); 
                    ?>
                </div>
            </div>

                <div class="control-group">
                    <?php echo CHtml::label('Dokter', 'pegawai_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                            $cekPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
                            
                            $model->pegawai_id = $cekPegawai->pegawai_id;
                            $model->pegawai_nama = $cekPegawai->namaLengkap;
                            echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true));
                            echo $form->textField($model, 'pegawai_nama', array('readonly' => true,'class' => 'span3'));
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Bagian list kie -->
        <div class="dokter">
            <?php
                echo $this->renderPartial($this->path_view.'_rowListKie',array('form'=>$form,'modListKie' => $modListKie, 'modKieDet'=>$modKieDet),true);
            ?>
        </div>
        
    </div>   
</table>           
<div class="form-actions">

<?php
$simpan = false;
      if(!$model->isNewRecord){
        echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
        array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 
                'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true)); 
        echo "&nbsp";
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="fa fa-refresh"></i>')), 
                $this->createUrl('kie/index', array(
                    'pendaftaran_id'=>$model->pendaftaran_id,
                    // 'frame'=>$frame,
                )),
                array('class' => 'btn btn-danger', 'disabled' => false, 'type' => 'button')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; 

                // echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";                 
            }else{
                
                echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
                array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>(!$model->isNewRecord)? 'btn btn-primary' : 'btn btn-primary submit','disabled'=>(!$model->isNewRecord || $simpan=='false')? true : false, 'type'=>'submit', 
                        'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
                echo "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";                 
            }
?>

    <?php 
        $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
        $kiepasien_id = isset($_GET['kiepasien_id']) ? $_GET['kiepasien_id'] : null;
        $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
        // exit($lembarobservasipasien_id);
		$this->widget('UserTips',array('type'=>'admin','content'=>$content));                       
        $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&pendaftaran_id='.$pendaftaran_id.'&kiepasien_id='.$kiepasien_id );
        CJSON::encode($urlPrint);

        // var_dump($urlPrint);die;
		$urlPrintRujukan=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printRujukan&id='.$modPendaftaran->pendaftaran_id);
	?>			
</div>
<?php $this->endWidget(); ?>


    <?php 
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa Untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"


function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
Yii::app()->clientScript->registerScript('js',$js,CClientScript::POS_READY);
?>   
    
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailrujukan',
    'options'=>array(
        'title'=>'Detail Rujukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailRujukan">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
   
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogAddDiagnosaSementara',
    'options'=>array(
        'title'=>'Diagnosa Sementara',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

   // $this->renderPartial($this->path_view.'_diagnosaSementara',array('model'=>$model));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogAddMasterRujukanKeluar',
    'options'=>array(
        'title'=>'Tambah Rujukan Keluar',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'resizable'=>false,
        'position'=>'top',
    ),
));

echo '<iframe src="" name="frameAddRujukanKeluar" width="100%" height="400px">
</iframe>';
    //$this->renderPartial($this->path_view.'_diagnosaSementara',array('modRujukanKeluar'=>$modRujukanKeluar));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
function viewDetailRujukan(lembarobservasipasien_id)
{
    $.post('<?php echo $this->createUrl('ajaxDetailRujukanKeluar') ?>', {lembarobservasipasien_id: lembarobservasipasien_id}, function(data){
        $('#contentDetailRujukan').html(data.result);
    }, 'json');
    $('#dialogDetailrujukan').dialog('open');
}

function print(){
        window.open('<?php echo Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&kiepasien_id='.$model->kiepasien_id ) ?>', 'printwin', 'left=100,top=100,width=640,height=640')
    }
function hapusRujukan(obj, lembarobservasipasien_id)
{
    var tabel = obj;
    myConfirm('Apakah anda akan menghapus rujukan keluar ini?', 'Perhatian!', function(r)
    {
        if(r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hapusRujukKeluar'); ?>',
                data: {lembarobservasipasien_id:lembarobservasipasien_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses == 1){
                        var delete_row = $(tabel).parents('tr');
                        delete_row.detach();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });

        }
    });
}

$(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
});
</script>