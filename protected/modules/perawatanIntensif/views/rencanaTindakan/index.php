<?php
$this->breadcrumbs = array(
    'Rencana Tindakan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Rencana Tindakan
        </div>
    </div>
    <div class="panel-body">
        <?php
        //RND-13407	
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Rencana Tindakan berhasil disimpan!");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'rencanatindakan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>
        <div class="panel panel-success" id="form-infopasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setInfoPasienReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pasien')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi, 'modInfoPasien' => $modInfoPasien)); ?>
            </div>
        </div>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'table-riwayattindakan',
            'content' => array(
                'content-riwayattindakan' => array(
                    'header' => '<b>Riwayat Rencana Tindakan</b>',
                    'isi' => $this->renderPartial('_tableRiwayatTindakan', array(
                        'format' => $format,
                        'modRiwayatTindakans' => $modRiwayatTindakans,
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>
        <div class="panel panel-success" id="form-infopasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Rencana Tindakan <b>Ruangan : <?php echo Yii::app()->user->getState('ruangan_nama'); ?></b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <p class="help-block"><?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                        ?></p>
                <?php
                echo CHtml::hiddenField('jenistarif_id', '', array());
                echo CHtml::hiddenField('jenistarif_nama', '', array());
                ?>
                <table class="items table table-striped table-bordered table-condensed" id="tblrencanatindakan">
                    <thead>
                        <tr>
                            <th>Kategori Rencana Tindakan</th>
                            <th>Tanggal Rencana</th>
                            <th>Rencana Tindakan <span color='red'>*</span>
                            </th>
                            <th>Tarif Satuan</th>
                            <th>Jumlah</th>
                            <th>Satuan<br>Tindakan</th>
                            <th>Cyto </th>
                            <th>Jumlah Tarif</th>
                            <th>Dokter</th>
                            <th>Keterangan Tindakan</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <?php
                    $trTindakan = $this->renderPartial('_rowTindakanPasien', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans), true);
                    echo $trTindakan;
                    ?>
                </table>
                <div class='row'>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('<b>Total Nominal Tarif : </b>', 'tglperencanaan', array('class' => 'control-label')) ?>
                            <div class='controls'>
                                <?php echo CHtml::textField("totalTarif", 0, array('readonly' => true, 'class' => 'inputFormTabel integer')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modRencanaTindakan, 'tglperencanaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $modRencanaTindakan->tglperencanaan = isset($modRencanaTindakan->tglperencanaan) ? MyFormatter::formatDateTimeForUser($modRencanaTindakan->tglperencanaan) : date('d M Y H:i:s'); ?>
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modRencanaTindakan,
                                    'attribute' => 'tglperencanaan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class="control-group">
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modRencanaTindakan, 'ygmerencanakan_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modRencanaTindakan, 'ygmerencanakan_id', array()); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'nama_pegawai',
                                    'source' => 'js: function(request, response) {
                                                                                   $.ajax({
                                                                                           url: "' . $this->createUrl('AutocompleteDokterPerencana') . '",
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
                                        'minLength' => 2,
                                        'select' => 'js:function( event, ui ) {
                                                                           $(this).val( ui.item.label);
                                                                                return false;
                                                                        }',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogDokterPerencana'),
                                    'htmlOptions' => array('placeholder' => 'Yang Merencanakan', "rel" => "tooltip", "title" => "Pencarian Data Dokter Perencana", 'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $form->errorSummary($modRencanaTindakan); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disableSave = false;
            $disableSave = (!empty($_GET['pendaftaran_id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'id' => 'btn_submit', 'type' => 'submit', 'disabled' => $disableSave)
            ); ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $content = $this->renderPartial('tips/tipsRencanaTindakan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
<?php $this->renderPartial('_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
<?php $this->renderPartial('_jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi, 'modInfoPasien' => $modInfoPasien, 'modTindakan' => $modTindakan)); ?>
<?php
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarTindakanPaket',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));
echo '<div id="tableDaftarTindakanPaket"></div>';
$this->renderPartial('_daftarTindakanPaket');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
?>
<?php
//========= Dialog buat daftar dokter  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));
echo '<div id="tableDaftarDokter"></div>';
$this->renderPartial('_daftarDokter');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar dokter =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokterPerencana',
    'options' => array(
        'title' => 'Daftar Dokter Perencana',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));
$modDokter = new PIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
if (isset($_GET['PIDokterV'])) {
    $modDokter->attributes = $_GET['PIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawai",
					"onClick"=>"$(\"#' . CHtml::activeId($modRencanaTindakan, 'ygmerencanakan_id') . '\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
							$(\"#dialogDokterPerencana\").dialog(\"close\");
							return false;"
					))'
        ),
        array(
            'header' => 'Nama Dokter Resep',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
            'name' => 'nama_pegawai',
        ),
        'jeniskelamin',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>