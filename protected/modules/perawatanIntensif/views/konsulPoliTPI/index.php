<?php
$this->breadcrumbs=array(
	'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="block-tabel">
    <h6>Tabel <b>Konsultasi Poliklinik</b></h6>
    <?php $this->renderPartial($this->path_view.'_listKonsulPoli',array('modRiwayatKonsul'=>$modRiwayatKonsul)); ?>
</div>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($modKonsul,'catatan_dokter_konsul'),
)); ?>
<!--<legend class="rim2">Konsultasi Poliklinik</legend>-->
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary(array($modKonsul,$modelPendaftaran)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="50%">
                            <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
                            <?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>

            <div class="control-group">
                <?php echo $form->labelEx($modKonsul,'tglkonsulpoli', array('class'=>'control-label')) ?>
                <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modKonsul,
                                                'attribute'=>'tglkonsulpoli',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true),
                        )); ?>
                </div>
            </div>
			<div class="control-group">
                    <?php //echo CHtml::hiddenField('jenisPesan'); ?>
                    <?php //echo $form->dropDownListRow($model, 'jenispesanmenu', GZPesanmenudietT::jenisPesan(), array('inline' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan();', 'maxlength' => 50)); ?>
                        <label class='control-label'><?php echo CHtml::encode($modKonsul->getAttributeLabel('ruangan_id')); ?> <span class="required">*</span></label>
                        <div class="controls">
                             <?php //echo CHtml::hiddenField('instalasi_id'); ?>
                            <?php //echo CHtml::hiddenField('ruangan_id'); ?>
                            <?php
                            echo $form->dropDownList($modKonsul, 'instalasi_id', CHtml::listData($modKonsul->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                'ajax' => array('type' => 'POST',
                                    'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $modKonsul->getNamaModel() . '')),
                                    'update' => '#' . CHtml::activeId($modKonsul, 'ruangan_id') . ''),));
                            ?>
                            <?php 
//                                echo $form->dropDownList($modKonsul, 'ruangan_id', CHtml::listData($modKonsul->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange'=>'setTarif();','ajax' => array('type' => 'POST',
                                echo $form->dropDownList($modKonsul, 'ruangan_id', CHtml::listData($modKonsul->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'ajax' => array('type' => 'POST',
                                    'url' => $this->createUrl('setDropdownDokter', array('encode' => false, 'namaModel' => '' . $modKonsul->getNamaModel() . '')),
                                    'update' => '#' . CHtml::activeId($modKonsul, 'pegawai_id') . ''),)); ?>
                            <?php echo $form->error($modKonsul, 'ruangan_id'); ?>
                        </div>
                    </div>
            <?php // echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(Params::INSTALASI_ID_RJ,true), 'ruangan_id', 'ruangan_nama'),
//                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'setTarif()')); ?>
			<div class="control-group">
				<?php echo CHtml::label('Dokter Konsul','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($modKonsul,'pegawai_id', CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
							array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
        </td>
        <td width="50%">
            <?php //echo $form->dropDownListRow($modKonsul,'asalpoliklinikkonsul_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(''), 'ruangan_id', 'ruangan_nama'),
                                            //array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            
            <?php //echo $form->textAreaRow($modKonsul,'catatan_dokter_konsul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" id="tarif_poliklinik">

                </div>
            </div>
        </td>
        <div class="row">
            <div class="col-sm-6">
                <br/>
                <b>Catatan Dokter</b>
                <br/>
                <br/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group">
                    <label class="control-label">Subjective</label>
                    <div class="controls" style="width:80%;">
                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'subjective', 'toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Objective</label>
                    <div class="controls" style="width:80%;">
                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'objective', 'toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Assessment</label>
                    <div class="controls" style="width:80%;">
                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'assessment', 'toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modKonsul, 'subjective', array('placeholder' => 'Subjective', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textAreaRow($modKonsul, 'assessment', array('placeholder' => 'Assessment', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                <div class="control-group">
                    <label class="control-label">Planning</label>
                    <div class="controls" style="width:80%;">
                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modKonsul, 'attribute'=>'planning', 'toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modKonsul, 'objective', array('placeholder' => 'Objective', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textAreaRow($modKonsul, 'planning', array('placeholder' => 'Planning', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </tr>
<!--<tr>
        <td colspan="2">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th colspan="2">Karcis Tindakan</th>
                    </tr>
                </thead>
                <?php //foreach ($karcisTindakan as $i => $karcis) { ?>
                <tr>
                    <td width="15px;">
                        <?php //echo CHtml::checkBox('karcis[]', false, array()); ?>
                    </td>
                    <td>
                        <?php //echo $karcis->daftartindakan_nama; ?>
                    </td>
                </tr>
                <?php //} ?>
            </table>
        </td>
    </tr>-->
</table>
    
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
    <?php
    if(isset($_GET['idKonsulPoli'])){
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    }else{
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>'disabled')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>'disabled')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>'disabled')); 
    }
    ?>  								
    <?php 
    $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $idKonsulPoli = isset($_GET['idKonsulPoli'])?$_GET['idKonsulPoli']:null;
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id.'&idKonsulPoli='.$idKonsulPoli);
    $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printRiwayat&id='.$modPendaftaran->pendaftaran_id);
    $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idKonsulPoli)
{
    window.open("${urlPrintPermintaan}&idKonsulPoli="+idKonsulPoli+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
    </div>

<?php $this->endWidget(); ?>

    <?php 
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        window.parent.myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
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
    'id'=>'dialogDetailKonsul',
    'options'=>array(
        'title'=>'Detail Konsul',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailKonsul"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php 
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogJawabKonsul',
        'options' => array(
            'title' => 'Jawaban Konsul',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 950,
            'height' => 550,
        ),
    ));
    ?>
    <iframe name='frameJawabKonsul' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>
<script type="text/javascript">
function viewDetailKonsul(idKonsulAntarPoli)
{
    $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {idKonsulAntarPoli: idKonsulAntarPoli}, function(data){
        $('#contentDetailKonsul').html(data.result);
    }, 'json');
    $('#dialogDetailKonsul').dialog('open');
}

function batalKonsul(idKonsulAntarPoli,pendaftaran_id)
{
    window.parent.myConfirm("Apakah Anda akan membatalkan konsul ini?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {idKonsulAntarPoli: idKonsulAntarPoli, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListKonsul').html(data.result);
            }, 'json');
        }
    });
}

function setTarif(){
    var ruangan_id = $('#<?php echo CHtml::activeId($modKonsul,'ruangan_id'); ?>').val();
    var penjamin_id = '<?php echo $modPendaftaran->penjamin_id; ?>';
    var kelaspelayanan_id = '<?php echo $modPendaftaran->kelaspelayanan_id; ?>';
//    $.post('<?php // echo $this->createUrl('ajaxSetTarif') ?>', {ruangan_id:ruangan_id,penjamin_id:penjamin_id,kelaspelayanan_id:kelaspelayanan_id}, function(data){
//        $('#tarif_poliklinik').html(data.result);
//    }, 'json');
}

$(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        simpanNotifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RJ ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        simpanNotifikasi(params);
    <?php
        }
    ?>
});
</script>