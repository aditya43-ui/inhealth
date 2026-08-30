<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:90%;width:97%;
    }
</style>
<?php
$this->breadcrumbs=array(
	'Perkembangan Terintegrasi Pasien',
);
if(isset($_GET['sukses'])){
    Yii::app()->user->setFlash('success',"Data anamnesa berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'integrasi-pasien-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus' => '#nama_pegawai',
)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Revisi dan Review Rencana Keperawatan</strong></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Waktu Pemeriksaan <span class="required">*</span></label>
                <div class="controls">  
                    <?php echo CHtml::activeTextField($model, 'tgltransaksi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Profesi <span class="required">*</span></label>
                <div class="controls">  
                <?php 
                    echo $form->dropDownList($model,'profesi',LookupM::getItemsUrutan('profesi'),array('empty' => '--Pilih--','class'=>'span3 required','disabled'=>true));
                ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Pegawai <span class="required">*</span></label>
                <div class="controls">  
                    <?php echo CHtml::activeTextField($model, 'nama_pegawai', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                    <?php 
                    echo CHtml::activeHiddenField($model,'pegawai_id',array('readonly'=>true));
                    ?>
                </div>
            </div>
        </div>
        <br>
        <div id="disableDiv" >                 
        </div>
        <?php
            echo $this->renderPartial($this->path_view.'_formInput',array('model'=>$model));
        ?>        
        <div class="col-sm-12">
            <div class="control-group ">
                <label class="control-label">DPJP <span class="required">*</span></label>
                <div class="controls">  
                <?php
                echo CHtml::activeHiddenField($model,'dpjp_id',array('value' => $modPendaftaran->dokter->pegawai_id, 'readonly'=>true,'class'=>'required'));
                echo CHtml::activeTextField($modPendaftaran->dokter, 'namaLengkap', array('readonly'=>true));
                echo CHtml::activeHiddenField($model,'menyetujui',array('readonly'=>true,'class'=>''));
                ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
                if(!isset($_GET['sukses']) && empty($model->menyetujui)){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Menyetujui',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary submit', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','onclick'=>'$("#RIPerkembanganTerintegrasiPasienT_menyetujui").val("1");')).'&nbsp;';
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Menolak',array('{icon}'=>'<i class="entypo-cancel"></i>')),array('class'=>'btn btn-danger submit', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','onclick'=>'$("#RIPerkembanganTerintegrasiPasienT_menyetujui").val("0");')).'&nbsp;';
                }else{
                    if(!empty($model->menyetujui)){
                        if($model->menyetujui){
                            echo CHtml::link(Yii::t('mds','{icon} Verifikasi Disetujui',array('{icon}'=>'')),'#', array('class'=>'btn btn-success','onclick'=>'return false;'))."&nbsp";
                        }else{
                            echo CHtml::link(Yii::t('mds','{icon} Verifikasi Ditolak',array('{icon}'=>'')),'#', array('class'=>'btn btn-danger','onclick'=>'return false;'))."&nbsp";
                        }
                    }
                }
                echo CHtml::link(Yii::t('mds','{icon} Informasi Integrasi',array('{icon}'=>'<i class="entypo-add"></i>')),$this->createUrl('index',array('id'=>$modPendaftaran->pendaftaran_id)), array('class'=>'btn btn-success'))."&nbsp"; 
            ?>
        </div>
    </div>

</div>

<?php $this->endWidget(); ?>

<?php 
//========= Dialog buat cari pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Data Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>600,
        'resizable'=>false,
    ),
));

$datPerawat = new PegawaiV();
if (isset($_GET['PegawaiV'])) {
    $datPerawat->attributes = $_GET['PegawaiV'];
}
$provider = $datPerawat->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'dokter-v-grid2',
        'dataProvider'=>$provider,
        'filter'=>$datPerawat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                       "onClick" => "
                                $(\"#RIPerkembanganTerintegrasiPasienT_dpjp_id\").val(\"$data->pegawai_id\");
                                $(\"#nama_dpjp\").val(\"$data->nama_pegawai\");
                                $(\"#dialogPegawai\").dialog(\"close\");
                                $(\".submit\").attr(\"disabled\",false);
                                return false;
                        "
                    ))',
                ),
                array(
                    'name'=>'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'type'=>'raw',
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end data pegawai =============================
?>

<script>
$( document ).ready(function(){ 
    $('form').bind('click keyup select change', function(event) { 
        cekDisabled(this); 
    }); $(document).on('click keyup select change',function(){ 
        cekDisabled('form'); 
    });
    cekDisabled('form'); 
    
    <?php if(isset($_GET['sukses'])){?>
       $("input, select, textarea").attr("disabled",true);
    <?php } ?>
});
</script>