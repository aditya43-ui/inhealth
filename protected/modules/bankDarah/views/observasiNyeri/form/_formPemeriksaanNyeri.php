<?php
/**
* - digunakan untuk menginput data asesmen nyeri
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*/
?>
<div class="row-fluid">
    <div class="control-group">
        <?php echo $form->labelEx($model,'frekuensinyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'frekuensinyeri', LookupM::getItemsUrutan('frekuensinyeri'),array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model,'lamanyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
        <div class="controls">
            <?php echo $form->textField($model,'lamanyeri',array('empty' => '-- Pilih --','class'=>'span1')); ?>
        </div>
        <div class="controls">
            <?php echo $form->dropDownList($model,'satuanlamanyeri',LookupM::getItemsUrutan('satuanlamanyeri'),array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model,'is_nyerimenjalar',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
        <div class="controls">                   
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $form->radioButton($model,'is_nyerimenjalar',array('uncheckValue'=>null,'onclick'=>'cekNyeriMenjalar();','id'=>'menjalarNo','value'=>0,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Tidak</label>  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $form->radioButton($model,'is_nyerimenjalar',array('uncheckValue'=>null,'onclick'=>'cekNyeriMenjalar();','id'=>'menjalarYes','value'=>1,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>  <label>Ya</label>   
        </div>                
        <div class="controls">
            <?php echo $form->textField($model,'nyerimenjalarke',array('empty' => '-- Pilih --', 'disabled'=>true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model,'kualitasnyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'kualitasnyeri',LookupM::getItemsUrutan('kualitasnyeri'),array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pemicu_memperberat', array('class' => 'control-label', 'style' => 'width:30%;text-align:left;')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pemicu_memperberat', array('empty' => '-- Pilih --')); ?>
        </div>

    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'pemicu_meringankan', array('class' => 'control-label', 'style' => 'width:30%;text-align:left;')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pemicu_meringankan', array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
</div>
             
<?php 
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTransporter',
    'options'=>array(
        'title'=>'Pencarian Petugas Penyadap',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai -> unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipelaksana-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'petugas_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'petugas_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogTransporter\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>