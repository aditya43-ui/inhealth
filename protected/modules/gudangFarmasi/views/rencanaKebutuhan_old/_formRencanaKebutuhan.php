<div class="span5">
    <?php echo CHtml::hiddenField('rencanakebfarmasi_id',$modRencanaKebFarmasi->rencanakebfarmasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php if((isset($_GET['sukses']))||(isset($_GET['ubah']))){ ?>
            <?php echo $form->textFieldRow($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3 isRequired', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
    <?php } ?>
        <div class="control-group">
            <?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $modRencanaKebFarmasi->tglperencanaan = (!empty($modRencanaKebFarmasi->tglperencanaan) ? date("d/m/Y H:i:s",strtotime($modRencanaKebFarmasi->tglperencanaan)) : null);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modRencanaKebFarmasi,
                            'attribute'=>'tglperencanaan',
                            'mode'=>'datetime',
                            'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); ?>
                </div>
        </div>
</div>
<div class="span5">
</div>
<!--<div class="span5">
    <div class="control-group">
        <?php // echo $form->labelEx($modRencanaKebFarmasi,'statusrencana', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php // echo $form->dropDownList($modRencanaKebFarmasi,'statusrencana',LookupM::getItems('statusrencana'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>
</div>-->

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new GFPegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->search(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new GFPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['GFPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modRencanaKebFarmasi,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>