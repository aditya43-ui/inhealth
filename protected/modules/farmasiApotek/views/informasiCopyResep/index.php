<legend class="rim2">Informasi Copy Resep</legend>
<?php
$this->widget('bootstrap.widgets.BootAlert');

Yii::app()->clientScript->registerScript('cariPasien', "
$('#search').submit(function(){
	$.fn.yiiGridView.update('informasicopyresep-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'search',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'get',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'informasicopyresep-grid',
    'dataProvider' => $modInfoCopy->searchCopyResep(),
    //        'filter'=>$modInfo,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Penjualan/<br>Tgl. Resep',
            'type' => 'raw',
            'value' => '$data->tglpenjualan." / ".$data->tglreseptur',
        ),
        array(
            'header' => 'No. Resep',
            'type' => 'raw',
            'value' => '$data->noresep',
        ),
        array(
            'header' => 'Jenis Penjualan',
            'type' => 'raw',
            'value' => '$data->jenispenjualan',
        ),
        array(
            'header' => 'Nama Pasien/<br>Pasien Pegawai',
            'type' => 'raw',
            'value' => '"$data->nama_pasien"."<br>".$data->getNamaPegawai($data->pasienpegawai_id)',
        ),
        array(
            'header' => 'Umur/<br>Jenis Kelamin',
            'type' => 'raw',
            'value' => '"$data->umur"."<br>"."$data->jeniskelamin"',
        ),
        array(
            'header' => 'Alamat',
            'type' => 'raw',
            'value' => '$data->alamat_pasien',
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Tgl. Copy <br> Resep',
            'type' => 'raw',
            'value' => '$data->tglcopy',
        ),
        array(
            'header' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->keterangancopy',
        ),

        array(
            'header' => 'Copy Resep',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/CopyResep",array("idPenjualanResep"=>$data->penjualanresep_id,"pasien_id"=>$data->pasien_id)),
                            array("class"=>"", 
                                  "target"=>"iframeCopyResep",
                                  "onclick"=>"$(\"#dialogCopyResep\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Copy Resep ",
                            ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<fieldset>
    <legend class="rim">Pencarian</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Reseptur', 'tglawal', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modInfoCopy,
                            'attribute' => 'tgl_awal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label(' Sampai dengan', 'tgl_akhir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modInfoCopy,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Resep', 'no_resep', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modInfoCopy, 'noresep', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
    <?php $this->widget('UserTips', array()); ?>
</div>

<?php $this->endWidget(); ?>

<?php
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCopyResep',
    'options' => array(
        'title' => 'Copy Resep',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeCopyResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end Copy Resep dialog =============================
?>