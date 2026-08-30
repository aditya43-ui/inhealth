<div class="white-container">
    <legend class="rim2">Transaksi Revisi Anggaran Pengeluaran</legend>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'revisi-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event); '), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Approval data anggaran pengeluaran berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modDetail); ?>
    <fieldset class="box">
        <legend class="rim">Data Rencana Pengeluaran</legend>
        <div>
            <div class="row">
                <div class="col-sm-4">
                    <?php echo $form->textFieldRow($model, 'rencanggaranpeng_tgl', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo $form->textFieldRow($model, 'rencanggaranpeng_no', array('class' => 'span3', 'readonly' => true)); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Unit <span class="required">*</span>', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'namaunitkerja', array('class' => 'span3', 'readonly' => true)); ?>
                            <?php echo $form->hiddenField($model, 'unitkerja_id', array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Periode Anggaran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'deskripsiperiode', array('class' => 'span3', 'readonly' => true)); ?>
                            <?php echo $form->hiddenField($model, 'konfiganggaran_id', array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Pegawai Mengetahui', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'pegawaimengetahui_nama', array('class' => 'span3', 'readonly' => true)); ?>
                            <?php echo $form->hiddenField($model, 'mengetahui_id', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Pegawai Menyetujui', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'pegawaimenyetujui_nama', array('class' => 'span3', 'readonly' => true)); ?>
                            <?php echo $form->hiddenField($model, 'menyetujui_id', array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Tanggal Approval', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'tglapprrencanggaran', array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($model, 'digitnilai', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) ?>
                </div>
            </div>

        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Anggaran Pengeluaran</b></h6>
        <table class="items table table-striped table-condensed" id="table-rencanaanggaranpengeluaran">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Program</th>
                    <th>Kode Sub Program</th>
                    <th>Kode Kegiatan</th>
                    <th>Kode Sub Kegiatan</th>
                    <th>Program Kerja</th>
                    <th>Bulan</th>
                    <th>Nilai <span id="digit"></span></th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$modDetail) > 0) {
                    foreach ($modDetail as $i => $modRencanaDetail) {
                        echo $this->renderPartial('_rowRevisi', array('format' => $format, 'modRencanaDetail' => $modRencanaDetail, 'i' => $i));
                    }
                }
                ?>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align:right;">Total Anggaran</td>
                    <td><?php echo $form->textField($model, 'total_nilairencpeng', array('class' => 'span2 integer2', 'style' => 'width:90px;', 'readonly' => true)) ?></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'Pegawai Merevisi <span class="required">*</span>', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'ygmerevisi_id', array('readonly' => true)); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawaimerevisi_nama',
                'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompletePegawaiMerevisi') . '",
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
						$("#' . Chtml::activeId($model, 'ygmerevisi_id') . '").val(ui.item.pegawai_id); 
						return false;
					}',
                ),
                'htmlOptions' => array(
                    'class' => 'pegawaimerevisi_nama',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'ygmerevisi_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMerevisi'),
            ));
            ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'verifikasiRevisi();', 'onkeypress' => 'verifikasiApprove();')); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array('class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
        ); ?>
        <?php $content = $this->renderPartial('../tips/transaksi1', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modDetail' => $modDetail)); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMerevisi',
    'options' => array(
        'title' => 'Pencarian Pegawai Merevisi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMerevisi = new AGPegawaiV('searchPegawaiMerevisi');
$modPegawaiMerevisi->unsetAttributes();
if (isset($_GET['AGPegawaiV'])) {
    $modPegawaiMerevisi->attributes = $_GET['AGPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimerevisi-grid',
    'dataProvider' => $modPegawaiMerevisi->searchPegawaiMerevisi(),
    'filter' => $modPegawaiMerevisi,
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
                                                  $(\"#' . CHtml::activeId($model, 'ygmerevisi_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimerevisi_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMerevisi\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMerevisi, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMerevisi, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMerevisi, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMerevisi, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>