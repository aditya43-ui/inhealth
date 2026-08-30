<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'dekontaminasi-info-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'dekontaminasi_no'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pembersihan', 'tgl_pembersihan', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php // echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); 
            ?>
            <?php echo CHtml::label('Pegawai Pembersihan', 'Pegawai Pembersihan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'petugaspemb_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'petugaspemb_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
							$("#' . Chtml::activeId($model, 'petugaspemb_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Petugas Pembersih',
                        'class' => 'span4',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiPembersih'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Pegawai Pembersih =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiPembersih',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));
$modPegawaiMengetahui = new PegawairuanganV();
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'petugaspemb_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#petugaspemb_nama\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiPembersih\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'jabatan_id'),
            'value' => '$data->getNamaJabatan($data->jabatan_id)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Pembersih dialog =============================
?>