<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modPenerimaanSterilisasiDetail, 'penerimaansterilisasi_no'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Penerimaan ', '', array('class' => 'control-label inline')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPenerimaanSterilisasiDetail->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPenerimaanSterilisasiDetail->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($modPenerimaanSterilisasiDetail->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPenerimaanSterilisasiDetail->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($modPenerimaanSterilisasiDetail, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modPenerimaanSterilisasiDetail, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Penerimaan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPenerimaanSterilisasiDetail, 'penerimaansterilisasi_no', array('placeholder' => 'No. Penerimaan', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => false)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modPenerimaanSterilisasiDetail, 'Nama Peralatan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modPenerimaanSterilisasiDetail, 'peralatansterilisasi_id'); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPenerimaanSterilisasiDetail,
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
								$(this).val( ui.item.label);
								return false;
							}',
                            'select' => 'js:function( event, ui ) {
								$("#' . Chtml::activeId($modPenerimaanSterilisasiDetail, 'peralatansterilisasi_id') . '").val(ui.item.peralatansterilisasi_id); 
								return false;
							}',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Nama Peralatan',
                            'class' => 'span3 barang_nama',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPenerimaanSterilisasiDetail, 'peralatansterilisasi_id') . '").val(""); '
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
                    echo $form->dropDownList($modPenerimaanSterilisasiDetail, 'instalasi_id', $instalasiTujuans, array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPenerimaanSterilisasiDetail))),
                            'update' => "#" . CHtml::activeId($modPenerimaanSterilisasiDetail, 'ruangan_id'),
                        )
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modPenerimaanSterilisasiDetail, 'ruangan_id', $ruanganTujuans, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onkeypress' => 'searchPenerimaan();', 'onclick' => 'searchPenerimaan()')
        ); ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
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
        'height' => 400,
        'resizable' => false,
    ),
));
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
							  $(\"#' . CHtml::activeId($modPenerimaanSterilisasiDetail, 'peralatansterilisasi_id') . '\").val(\"$data->peralatansterilisasi_id\");
							  $(\"#' . CHtml::activeId($modPenerimaanSterilisasiDetail, 'peralatansterilisasi_nama') . '\").val(\"$data->peralatansterilisasi_nama\");
							  $(\"#dialogPeralatan\").dialog(\"close\"); 
							  return false;
					"))',
        ),
        array(
            'header' => 'Nama Peralatan Sterilisasi',
            'filter' => CHtml::activeTextField($modPeralatan, 'peralatansterilisasi_nama'),
            'value' => '$data->peralatansterilisasi_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'filter' => CHtml::activeTextField($modPeralatan, 'peralatansterilisasi_namalain'),
            'value' => '$data->peralatansterilisasi_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Peralatan dialog =============================
?>