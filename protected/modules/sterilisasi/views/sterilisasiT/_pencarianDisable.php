<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modPenerimaansterilisasiV, 'penerimaansterilisasi_no'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Penerimaan ', '', array('class' => 'control-label inline')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPenerimaansterilisasiV->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPenerimaansterilisasiV->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($modPenerimaansterilisasiV->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPenerimaansterilisasiV->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($modPenerimaansterilisasiV, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modPenerimaansterilisasiV, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Penerimaan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPenerimaansterilisasiV, 'penerimaansterilisasi_no', array('placeholder' => 'No Penerimaan', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group hidden">
                <?php echo $form->labelEx($modPenerimaansterilisasiV, 'Nama Peralatan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php //echo $form->hiddenField($modPenerimaansterilisasiV, 'barang_id'); 
                    ?>
                    <?php echo $form->hiddenField($modPenerimaansterilisasiV, 'pembersihan_id'); ?>
                    <?php echo $form->hiddenField($modPenerimaansterilisasiV, 'peralatansterilisasi_id'); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPenerimaansterilisasiV,
                        'attribute' => 'peralatansterilisasi_nama',
                        'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompletePeralatan') . '",
											   dataType: "json",
											   data: {
												   term: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
//								$(this).val( ui.item.label);
								$(this).val( ui.item.namaBrg);
								return false;
							}',
                            'select' => 'js:function( event, ui ) {
								$("#' . Chtml::activeId($modPenerimaansterilisasiV, 'peralatansterilisasi_id') . '").val(ui.item.peralatansterilisasi_id); 
								return false;
							}',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Nama Peralatan',
                            'class' => 'span3 barang_nama',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPenerimaansterilisasiV, 'peralatansterilisasi_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPeralatan'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modPenerimaansterilisasiV, 'instalasi_id', $instalasiTujuans, array(
                        'readonly' => true, 'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPenerimaansterilisasiV))),
                            'update' => "#" . CHtml::activeId($modPenerimaansterilisasiV, 'ruangan_id'),
                        )
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPenerimaansterilisasiV, 'ruangan_id', $ruanganTujuans, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php // echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onkeypress' => 'searchPenerimaan();', 'onclick' => 'searchPenerimaan()')); 
        ?>
        <?php
        //        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
        //            'onclick' => 'return refreshForm(this);'));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
//========= Dialog buat cari data Peralatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPeralatan',
    'options' => array(
        'title' => 'Pencarian Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
//$modPeralatan = new STBarangM('searchDialog');
$modPeralatan = new PeralatansterilisasiM('searchDialog');
$modPeralatan->unsetAttributes();
if (isset($_GET['PeralatansterilisasiM'])) {
    $modPeralatan->attributes = $_GET['PeralatansterilisasiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modPeralatan->searchDialog(),
    'filter' => $modPeralatan,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
				"href"=>"",
				"id" => "selectObat",
				"onClick" => "
							  $(\"#' . CHtml::activeId($modPenerimaansterilisasiV, 'peralatansterilisasi_id') . '\").val(\"$data->peralatansterilisasi_id\");
							  $(\"#' . CHtml::activeId($modPenerimaansterilisasiV, 'peralatansterilisasi_nama') . '\").val(\"$data->peralatansterilisasi_nama\");
							  $(\"#dialogPeralatan\").dialog(\"close\"); 
							  return false;
					"))',
        ),
        //		array(
        //			'header'=>'Tipe Peralatan',
        //			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_type'),
        //			'value'=>'$data->barang_type',
        //		),
        //		array(
        //			'header'=>'Kode Peralatan',
        //			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_kode'),
        //			'value'=>'$data->barang_kode',
        //		),
        //		array(
        //			'header'=>'Nama Barang',
        //			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_nama'),
        //			'value'=>'$data->barang_nama',
        //		),
        //		array(
        //			'header'=>'Nama Lain',
        //			'filter'=>  CHtml::activeTextField($modPeralatan, 'barang_namalainnya'),
        //			'value'=>'$data->barang_namalainnya',
        //		),
        /*array(
            'name' => 'barang_type',
            'type' => 'raw',
            'value' => '$data->barang_type'
        ),
        array(
            'name' => 'barang_kode',
            'type' => 'raw',
            'value' => '$data->barang_kode'
        ),
        array(
            'name' => 'barang_nama',
            'type' => 'raw',
            'value' => '$data->barang_nama'
        ),
        array(
            'name' => 'golongan_nama',
            'type' => 'raw',
            'value' => '$data->golongan_nama'
        ),*/
        array(
            'header' => 'Peralatan Sterilisasi',
            'name' => 'peralatansterilisasi_nama',
            'type' => 'raw',
            'value' => '$data->peralatansterilisasi_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Peralatan dialog =============================
?>
<script type="text/javascript">
    $('#STPenerimaansterilisasiV_instalasi_id').css('pointer-events', 'none');
    $('#STPenerimaansterilisasiV_ruangan_id').css('pointer-events', 'none');
</script>