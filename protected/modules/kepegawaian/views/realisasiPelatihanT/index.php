<?php $linkHalaman = CustomFunction::getUrlByMenuID(1307); ?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
?>
<style type="text/css">
     .td_date input {
        float: left !important;
    }
</style>
<div class="row">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'realisasipelatihan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
        'focus' => '#' . CHtml::activeId($model, 'tglrencanadiklat'),
    )); ?>
    <?php
    $this->breadcrumbs = array(
        'Transaksi Realisasi Pelatihan',
    );
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data Realisasi Pelatihan berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Realisasi Pelatihan</b>
                    <span class="pull-right">
                        <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                        </a>
                    </span>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Rencana Pelatihan</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php /*
                                <div class="control-group">
                                    <?php echo $form->labelEx($model,'tglrencanadiklat', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php 
                                        $this->widget('MyDateTimePicker', array(
                                        'model'=>$model,
                                        'attribute'=>'tglrencanadiklat',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true,
                                            'class'=>'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                        ?>
                                    </div>
                                </div>
                                 * 
                                 */ ?>
                                    <?php echo $form->textFieldRow($model, 'tglrencanadiklat', array('readonly' => true, 'class' => 'control-label span4')) ?>
                                    <?php echo $form->hiddenField($modRealisasi, 'rencanadiklat_id', array('readonly' => true, 'class' => 'control-label')) ?>
                                    <?php echo $form->textFieldRow($modRealisasi, 'namapelatihan', array('placeholder' => 'Pelatihan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php echo $form->textFieldRow($modRealisasi, 'tempat', array('placeholder' => 'Tempat Pelatihan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php echo $form->textAreaRow($modRealisasi, 'alamat', array('placeholder' => 'Alamat Pelatihan', 'class' => 'span4 autogrow', 'maxlength' => 500)); ?>
                                    <?php echo $form->textAreaRow($modRealisasi, 'keterangan_diklat', array('placeholder' => 'Keterangan Realisasi', 'class' => 'span4 autogrow', 'maxlength' => 500)); ?>
                                </div>
                                <div class="col-sm-6">
                                    <div class="control-group">
                                        <?php echo $form->labelEx($model, 'norencanadiklat', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php
                                            $this->widget('MyJuiAutoComplete', array(
                                                'model' => $model,
                                                'attribute' => 'norencanadiklat',
                                                'source' => 'js: function(request, response) {
                                                $.ajax({
                                                     url: "' . $this->createUrl('AutocompleteNoRencanaDiklat') . '",
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
                                                    $("#' . Chtml::activeId($model, 'norencanadiklat') . '").val(ui.item.norencanadiklat);
                                                    $("#' . Chtml::activeId($modRealisasi, 'rencanadiklat_id') . '").val(ui.item.rencanadiklat_id);
                                                    $("#' . Chtml::activeId($modRealisasi, 'pemateri') . '").val(ui.item.pemateri);
                                                    $("#' . Chtml::activeId($modRealisasi, 'namapelatihan') . '").val(ui.item.namadiklat);
                                                    $("#' . Chtml::activeId($modRealisasi, 'tempat') . '").val(ui.item.tempat_diklat);
                                                    $("#' . Chtml::activeId($modRealisasi, 'alamat') . '").val(ui.item.alamat_diklat);
                                                    $("#' . Chtml::activeId($model, 'tglrencanadiklat') . '").val(ui.item.tglrencanadiklat);
                                                    $("#' . Chtml::activeId($modRealisasi, 'jam_mulai') . '").val(ui.item.jam_mulai);
                                                    $("#' . Chtml::activeId($modRealisasi, 'jam_akhir') . '").val(ui.item.jam_akhir);
                                                    $("#' . Chtml::activeId($modRealisasi, 'jenisdiklat_nama') . '").val(ui.item.jenisdiklat_nama);
                                                    $("#' . Chtml::activeId($modRealisasi, 'jenisdiklat_id') . '").val(ui.item.jenisdiklat_id);
                                                    $("#' . Chtml::activeId($modRealisasi, 'realisasi_tglawal') . '").val(ui.item.rencanadiklat_periode);
                                                    $("#' . Chtml::activeId($modRealisasi, 'realisasi_tglakhir') . '").val(ui.item.rencanadiklat_sampaidgn);
                                                    $("#' . Chtml::activeId($modRealisasi, 'pemberitugas_id') . '").val(ui.item.pemberitugas_id);
                                                    $("#' . Chtml::activeId($modRealisasi, 'mengetahui_id') . '").val(ui.item.mengetahui_id);
                                                    $("#' . Chtml::activeId($modRealisasi, 'menyetujui_id') . '").val(ui.item.menyetujui_id);
                                                    $("#' . Chtml::activeId($modBiaya, 'biayapelatihan_id') . '").val(ui.item.biayapelatihan_id);
                                                    $("#' . Chtml::activeId($modBiaya, 'internal_biayakonsumsi') . '").val(ui.item.internal_biayakonsumsi);
                                                    $("#' . Chtml::activeId($modBiaya, 'internal_biayaalatperaga') . '").val(ui.item.internal_biayaalatperaga);
                                                    $("#' . Chtml::activeId($modBiaya, 'internal_biayalainlain') . '").val(ui.item.internal_biayalainlain);
                                                    $("#' . Chtml::activeId($modBiaya, 'internal_biayapemateri') . '").val(ui.item.internal_biayapemateri);
                                                    $("#' . Chtml::activeId($modBiaya, 'internal_keteranganlainlain') . '").val(ui.item.internal_keteranganlainlain);
                                                    setRowRencana(ui.item.rencanadiklat_id);
                                                    return false;
                                                }',
                                                ),
                                                'htmlOptions' => array(
                                                    'class' => 'norencanadiklat span4',
                                                    'placeholder' => 'No. Rencana',
                                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'norencanadiklat') . '").val(""); '
                                                ),
                                                'tombolDialog' => array('idDialog' => 'dialogRencanaDiklat'),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <?php echo $form->textFieldRow($modRealisasi, 'pemateri', array('placeholder' => 'Pemateri', 'class' => 'span4 pemateri', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php echo $form->textFieldRow($modRealisasi, 'penyelenggara', array('placeholder' => 'Penyelenggara', 'class' => 'span4 penyelenggara', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Tgl <span class='required'>*</span>", '', array('class' => 'control-label required')) ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modRealisasi, 'realisasi_tglawal', array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                        <div class="controls">
                                            <label>s/d</label>
                                        </div>
                                        <div class="controls">
                                            <?php echo $form->textField($modRealisasi, 'realisasi_tglakhir', array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Jam <span class='required'>*</span>", '', array('class' => 'control-label required')) ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modRealisasi, 'jam_mulai', array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                        <div class="controls">
                                            <label>s/d</label>
                                        </div>
                                        <div class="controls">
                                            <?php echo $form->textField($modRealisasi, 'jam_akhir', array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Durasi", '', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php
                                            $this->widget('MyDateTimePicker', array(
                                                'model' => $modRealisasi,
                                                'attribute' => 'durasijam_awal',
                                                'mode' => 'time',
                                                'options' => array(),
                                                'htmlOptions' => array('readonly' => true, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:70px;'),
                                            ));
                                            ?>

                                        </div>
                                        <div class="controls">
                                            <label>s/d</label>
                                        </div>
                                        <div class="controls">
                                            <?php
                                            $this->widget('MyDateTimePicker', array(
                                                'model' => $modRealisasi,
                                                'attribute' => 'durasijam_akhir',
                                                'mode' => 'time',
                                                'options' => array(),
                                                'htmlOptions' => array('readonly' => true, 'class' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:70px;'),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <?php echo $form->hiddenField($modRealisasi, 'jenisdiklat_id', array('readonly' => true, 'class' => 'control-label')) ?>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Jenis Diklat", 'jenisdiklat_id', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php echo $form->textField($modRealisasi, 'jenisdiklat_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Dokumentasi Kegiatan", '', array('class' => 'control-label')); ?>
                                        <div class="controls">
                                            <?php echo $form->fileField($modRealisasi, 'dokumentasikegiatan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                        </div>
                                    </div>
                                    <div id="internal_pelatihan" style="display:none;">
                                        <?php echo $form->hiddenField($modBiaya, 'biayapelatihan_id'); ?>
                                        <?php echo $form->textFieldRow($modBiaya, 'internal_biayapemateri', array('class' => 'integer2')); ?>
                                        <?php echo $form->textFieldRow($modBiaya, 'internal_biayakonsumsi', array('class' => 'integer2')); ?>
                                        <?php echo $form->textFieldRow($modBiaya, 'internal_biayaalatperaga', array('class' => 'integer2')); ?>
                                        <?php echo $form->textFieldRow($modBiaya, 'internal_biayalainlain', array('class' => 'integer2', 'onblur' => 'mandatoryLainLain(this);')); ?>
                                        <?php echo $form->textAreaRow($modBiaya, 'internal_keteranganlainlain', array('class' => 'autogrow', 'cols' => 6, 'rows' => 5)); ?>
                                    </div>
                                    <?php echo $form->hiddenField($model, 'jmlRow', array('class' => 'span2', 'style' => 'width:90px;', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Realisasi Pelatihan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div>
                            <table class="items table table-bordered table-striped table-condensed" id="table-realisasipelatihan">
                                <!--<thead>
                                        <tr>
                                            <th></th>
                                            <th>No.</th>
                                            <th>No. Induk Pegawai</th>
                                            <th>Nama Pegawai</th>                                                                                        
                                        </tr>
                                    </thead>-->
                                <thead>
                                    <tr>
                                        <th rowspan="2"></th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">No.</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">No. Induk Pegawai</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Nama Pegawai</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Jabatan</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Sertifikat</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Masa Berlaku Sertifikat</th>
                                        <th colspan="6" style="vertical-align: middle;text-align:center;" class="internal_pelatihan_anti">Biaya</th>
                                        <th rowspan="2" class="internal_pelatihan_anti">Subtotal</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Pelatihan</th>
                                        <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Transportasi</th>
                                        <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Penginapan</th>
                                        <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Perjalanan Dinas</th>
                                        <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Lain - Lain</th>
                                        <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Keterangan Biaya Lain - Lain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot class="internal_pelatihan_anti">
                                    <tr>
                                        <th colspan="7" style="text-align: right;">Total</th>
                                        <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayapelatihan', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                                        <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayatransportasi', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                                        <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayapenginapan', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                                        <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayaperjalanan', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                                        <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayalainlain', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                                        <th>&nbsp;</th>
                                        <th><?php echo CHtml::textField('totalBiaya', 0, array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php /*
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Form Realisasi Pelatihan
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo $this->renderPartial('form/_formRealisasi',array('modRealisasi'=>$modRealisasi,'form'=>$form),true); ?>
                        </div>
                    </div>
                </div>
				 * 
				 */ ?>
                <div class="form-actions">
                    <?php
                    if (isset($_GET['realisasi_id'])) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                        );
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'verifikasiRealisasiPelatihan();', 'onkeypress' => 'verifikasiRealisasiPelatihan();')
                        );
                    }
                    ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
                        )
                    );
                    ?>
                    <?php
                    echo (!isset($_GET['realisasi_id']) ?
                        CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)) :
                        CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'print(\'PRINT\')')));
                    $urlPrint = $this->createUrl('print', array('id' => isset($_GET['realisasi_id']) ? $_GET['realisasi_id'] : null));
                    $js = <<< JSCRIPT
        function print(caraPrint){
            window.open("${urlPrint}"+"&caraPrint="+caraPrint,"",'location=_new, width=1200px');
        }
JSCRIPT;
                    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                    ?>
                    <?php $content = $this->renderPartial('../tips/transaksi_rencanapelatihan', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<!--/div-->
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'model' => $model,
        'attribute' => 'rencanadiklat_periode',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>
<?php
//========= Dialog buat cari data No Rencana Diklat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRencanaDiklat',
    'options' => array(
        'title' => 'Pencarian Rencana Pelatihan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));
$modRencanaDiklat = new KPRencanadiklatT('searchRencanaDiklat');
$modRencanaDiklat->unsetAttributes();
$modRencanaDiklat->status_rencana = Params::STATUS_RENCANA_DIKLAT_RENCANA;
if (isset($_GET['KPRencanadiklatT'])) {
    $modRencanaDiklat->attributes = $_GET['KPRencanadiklatT'];
    //$modRencanaDiklat->nomorindukpegawai = $_GET['KPRencanadiklatT']['nomorindukpegawai'];
    //$modRencanaDiklat->nama_pegawai = $_GET['KPRencanadiklatT']['nama_pegawai'];
}
$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
    'id' => 'rencanadiklat-grid',
    'dataProvider' => $modRencanaDiklat->searchRencanaDiklat(),
    'filter' => $modRencanaDiklat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'mergeColumns' => 'norencanadiklat',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectRencanaDiklat",
                                    "onClick" => "
                                                $(\"#' . CHtml::activeId($model, 'norencanadiklat') . '\").val(\"$data->norencanadiklat\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'rencanadiklat_id') . '\").val(\"$data->rencanadiklat_id\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'pemateri') . '\").val(\"$data->pemateri\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'penyelenggara') . '\").val(\"$data->penyelenggara\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'namapelatihan') . '\").val(\"$data->namadiklat\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'tempat') . '\").val(\"$data->tempat_diklat\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'alamat') . '\").val(\"$data->alamat_diklat\");
                                                $(\"#' . CHtml::activeId($model, 'tglrencanadiklat') . '\").val(\"".MyFormatter::formatDateTimeForUser($data->tglrencanadiklat)."\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'jam_mulai') . '\").val(\"$data->jam_mulai\");
                                                $(\"#' . CHtml::activeId($modRealisasi, 'jam_akhir') . '\").val(\"$data->jam_akhir\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'jenisdiklat_id') . '\").val(\"$data->jenisdiklat_id\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'jenisdiklat_nama') . '\").val(\"$data->DataJenisDiklat\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'realisasi_tglawal') . '\").val(\"$data->DataTglAwal\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'realisasi_tglakhir') . '\").val(\"$data->DataTglAkhir\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'pemberitugas_id') . '\").val(\"$data->pemberitugas_id\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'mengetahui_id') . '\").val(\"$data->mengetahui_id\");    
                                                $(\"#' . CHtml::activeId($modRealisasi, 'menyetujui_id') . '\").val(\"$data->menyetujui_id\");    
                                                $(\"#' . CHtml::activeId($modBiaya, 'biayapelatihan_id') . '\").val(\"$data->DataBiayaPelatihanId\");    
                                                $(\"#' . CHtml::activeId($modBiaya, 'internal_biayapemateri') . '\").val(\"$data->DataBiayaPemateri\");    
                                                $(\"#' . CHtml::activeId($modBiaya, 'internal_biayakonsumsi') . '\").val(\"$data->DataBiayaKonsumsi\");    
                                                $(\"#' . CHtml::activeId($modBiaya, 'internal_biayaalatperaga') . '\").val(\"$data->DataBiayaAlatPeraga\");    
                                                $(\"#' . CHtml::activeId($modBiaya, 'internal_biayalainlain') . '\").val(\"$data->DataBiayaLainLain\");    
                                                $(\"#' . CHtml::activeId($modBiaya, 'internal_keteranganlainlain') . '\").val(\"$data->DataKeteranganLainLain\");    
                                                setRowRencana(\"$data->rencanadiklat_id\");
                                                $(\"#dialogRencanaDiklat\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'No. Rencana Diklat',
            'name' => 'norencanadiklat',
            'value' => '$data->norencanadiklat',
        ),
        array(
            'name' => 'jenisdiklat_id',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->jenisdiklat_id)) return "-";
                $modJenis = JenisdiklatM::model()->findByPk($data->jenisdiklat_id);
                return $modJenis->jenisdiklat_nama;
            },
            'filter' => CHtml::activeDropDownList(
                $modRencanaDiklat,
                'jenisdiklat_id',
                CHtml::listData(JenisdiklatM::model()->findAll('jenisdiklat_aktif = true'), 'jenisdiklat_id', 'jenisdiklat_nama'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Nama Pelatihan',
            'name' => 'namadiklat',
            'value' => '$data->namadiklat',
        ),
        array(
            'header' => 'Tempat Pelatihan',
            'name' => 'tempat_diklat',
            'value' => '$data->tempat_diklat',
        ),
        array(
            'header' => 'Alamat Pelatihan',
            'name' => 'alamat_diklat',
            'value' => '$data->alamat_diklat',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '     $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });
            $(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });}',
));
$this->endWidget();
//========= end No Rencana Diklat dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div id="tablePencarianPegawai"></div>';
$this->renderPartial('_dialogPegawai');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Pegawai dialog =============================
?>
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'model' => $modPegawaiDiklat,
        'attribute' => 'tglditetapkandiklat',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>
<script type="text/javascript">
    function setRowRencana(rencanadiklat_id) {
        if ($("#KPRealisasidiklatT_jenisdiklat_id").val() == <?php echo Params::JENIS_DIKLAT_EKSTERNAL ?>) {
            $(".pemateri").prop("disabled", true).parents(".control-group").hide();
            $(".penyelenggara").prop("disabled", false).parents(".control-group").show();
        } else if ($("#KPRealisasidiklatT_jenisdiklat_id").val() == <?php echo Params::JENIS_DIKLAT_INTERNAL ?>) {
            $(".pemateri").prop("disabled", false).parents(".control-group").show();
            $(".penyelenggara").prop("disabled", true).parents(".control-group").hide();
        }
        setRow();
        $('#table-realisasipelatihan').addClass('animation-loading');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadFormRencanaPelatihan'); ?>',
            //data: {norencanadiklat:norencanadiklat},
            data: {
                rencanadiklat_id: rencanadiklat_id
            },
            dataType: "json",
            success: function(data) {
                $('#table-realisasipelatihan > tbody').append(data.form);
                hitungTotal();
                renameInput($('#table-realisasipelatihan'));
                $('#table-realisasipelatihan > tbody').find('input[name$="[masaberlakusertifikat]"]').datetimepicker(
                    jQuery.extend(
                        {
                            showMonthAfterYear:false
                        }, 
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat':'dd M yy',
                            'minDate':'d',
                            'timeText':'Waktu',
                            'hourText':'Jam',
                            'minuteText':'Menit',
                            'secondText':'Detik',
                            'showSecond':true,
                            'timeOnlyTitle':'Pilih Waktu',
                            'timeFormat':'hh:mm:ss',
                            'changeYear':true,
                            'changeMonth':true,
                            'showAnim':'fold',
                            'yearRange':'-80y:+20y'
                        }
                    )
                );
                $('#table-realisasipelatihan > tbody').find('input[name$="[masaberlakusertifikat]"]').each(function() {
                    var obj = $(this);
                    $(this).parent().find(".add-on").click(function() {
                        $(obj).focus();
                    });
                });

                setTampilanBiayaTipePelatihan();
                $('#table-realisasipelatihan').removeClass('animation-loading');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTampilanBiayaTipePelatihan() {
        var jenis = $("#KPRealisasidiklatT_jenisdiklat_id").val();
        if (jenis == <?php echo Params::JENIS_DIKLAT_INTERNAL; ?>) {
            $(".internal_pelatihan_anti").hide();
        } else if (jenis == <?php echo Params::JENIS_DIKLAT_EKSTERNAL; ?>) {
            $(".internal_pelatihan_anti").show();
        }
    }

    function setRow() {
        $('#table-realisasipelatihan tbody').each(function() {
            $('#table-realisasipelatihan tbody > tr').detach();
        });
    }

    function verifikasiRealisasiPelatihan() {
        $("#table-realisasipelatihan").addClass("animation-loading");
        if (requiredCheck($("realisasipelatihan-form"))) {
            if (validasiDetail()) {
                $('#realisasipelatihan-form').submit();
            } else {
                formatNumberSemua();
                $("#table-realisasipelatihan").removeClass("animation-loading");
                return false;
            }
            $("#table-realisasipelatihan").removeClass("animation-loading");
            $("form").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            $("form").find('.integer').each(function() {
                $(this).val(formatInteger($(this).val()));
            });
        }
        return false;
    }

    function validasiDetail() {
        if (validasiNomorKeputusanDiklat() && validasiTanggalDitetapkan() && validasiDetailPemimpin() && validasiDetailKeterangan()) {
            return true;
        } else {
            return false;
        }
    }

    function validasiNomorKeputusanDiklat() {
        var detailnomorkeputusandiklat = document.getElementsByClassName("nomorkeputusandiklat");
        var jml = detailnomorkeputusandiklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailnomorkeputusandiklat[i].value === '') {
                myAlert('Silakan lengkapi semua Nomor Keputusan Diklat!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiTanggalDitetapkan() {
        var detailtglditetapkandiklat = document.getElementsByClassName("tglditetapkandiklat");
        var jml = detailtglditetapkandiklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailtglditetapkandiklat[i].value === '') {
                myAlert('Silakan lengkapi semua Tanggal Penetapan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailPemimpin() {
        var detailpejabatygmemdiklat = document.getElementsByClassName("pejabatygmemdiklat");
        var jml = detailpejabatygmemdiklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailpejabatygmemdiklat[i].value === '') {
                myAlert('Silakan lengkapi semua Pemimpin!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailKeterangan() {
        var detailpegawaidiklat_keterangan = document.getElementsByClassName("pegawaidiklat_keterangan");
        var jml = detailpegawaidiklat_keterangan.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailpegawaidiklat_keterangan[i].value === '') {
                myAlert('Silakan lengkapi semua Keterangan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function hitungTotal() {
        unformatNumberSemua();
        var total = 0;
        var tot_biayapelatihan = 0;
        var tot_biayatransportasi = 0;
        var tot_biayapenginapan = 0;
        var tot_biayaperjalanandinas = 0;
        var tot_biayalainlain = 0;
        var grandtotal = 0;
        var row = 0;
        $('#table-realisasipelatihan tbody tr').each(function() {
            var biaya_pelatihan = parseInt($(this).find('input[name$="[biaya_pelatihan]"]').val());
            var biaya_transportasi = parseInt($(this).find('input[name$="[biaya_transportasi]"]').val());
            var biaya_penginapan = parseInt($(this).find('input[name$="[biaya_penginapan]"]').val());
            var biaya_perjalanandinas = parseInt($(this).find('input[name$="[biaya_perjalanandinas]"]').val());
            var biaya_lainlain = parseInt($(this).find('input[name$="[biaya_lainlain]"]').val());
            //total
            total = total + biaya_pelatihan + biaya_transportasi + biaya_penginapan + biaya_perjalanandinas + biaya_lainlain;
            //total biaya pelatihan
            tot_biayapelatihan = tot_biayapelatihan + biaya_pelatihan;
            //total biaya transportasi
            tot_biayatransportasi = tot_biayatransportasi + biaya_transportasi;
            //total biaya penginapan
            tot_biayapenginapan = tot_biayapenginapan + biaya_penginapan;
            // ttoal biaya perjalanan dinas
            tot_biayaperjalanandinas = tot_biayaperjalanandinas + biaya_perjalanandinas;
            //total biaya lain - lain
            tot_biayalainlain = tot_biayalainlain + biaya_lainlain;
            $(this).find('input[name$="[total]"]').val(total);
            //$(this).find('input[name$="[stok_akhirtot]"]').val(stokawal+jmlpermintaan);
            grandtotal = grandtotal + total;
            total = 0;
            row++;
        });
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapelatihan') ?>").val(tot_biayapelatihan);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayatransportasi') ?>").val(tot_biayatransportasi);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapenginapan') ?>").val(tot_biayapenginapan);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayaperjalanan') ?>").val(tot_biayaperjalanandinas);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayalainlain') ?>").val(tot_biayalainlain);
        $("#totalBiaya").val(grandtotal);
        formatNumberSemua();
    }

    function addRowPelatihan(obj) {
        <?php $modDet = new RencanadiklatdetT; ?>
        var trRencanaPelatihan = new String(<?php echo CJSON::encode($this->renderPartial('_rowRealisasiPelatihanV2', array('modPegawaiDiklat' => $modPegawaiDiklat, 'modDetail' => $modDet, 'format' => $format, 'removeButton' => true, 'a' => 0), true)); ?>);
        $("#table-realisasipelatihan > tbody > tr:last .tambahRow").attr('style', 'display:none;');
        $("#table-realisasipelatihan > tbody > tr:last .hapusRow").attr('style', 'display:true;');
        $(obj).parents('table').children('tbody').append(trRencanaPelatihan.replace());
        renameInput('#table-realisasipelatihan');
        $('#table-realisasipelatihan > tbody > tr:last').find('input[name$="[masaberlakusertifikat]"]').datetimepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'minDate':'d',
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y'
                }
            )
        );
        $('#table-realisasipelatihan > tbody > tr:last').find('input[name$="[masaberlakusertifikat]"]').each(function() {
                    var obj = $(this);
                    $(this).parent().find(".add-on").click(function() {
                        $(obj).focus();
                    });
                });

        setTampilanBiayaTipePelatihan();
    }

    function hapusPelatihan(obj) {
        myConfirm('Apakah Anda akan membatalkan rencana pelatihan ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    renameInput('#table-realisasipelatihan');
                }
            });
    }

    function renameInput(obj_table) {
        var row = 0;
        var jmlRow = $('#table-realisasipelatihan tbody tr').length;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            if (jmlRow == 0) {
                $(this).find(".tambahRow").attr('style', 'display:block;');
                $(this).find(".hapusRow").attr('style', 'display:none;');
            } else {
                if (row == (jmlRow - 1)) {
                    $(this).find(".tambahRow").attr('style', 'display:block;');
                    $(this).find(".hapusRow").attr('style', 'display:block;');
                } else {
                    $(this).find(".tambahRow").attr('style', 'display:none;');
                    $(this).find(".hapusRow").attr('style', 'display:block;');
                }
            }
            row++;
        });
        hitungTotal();
        showJenisDiklat($("#<?php echo CHtml::activeId($modRealisasi, 'jenisdiklat_id') ?>"));
    }

    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogPegawai";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setPegawaiAuto(pegawai_id) {
        dialog = "#dialogPegawai";
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $.get('<?php echo $this->createUrl('AutocompletePegawai'); ?>', {
            pegawai_id: pegawai_id
        }, function(data) {
            $(obj).val(data[0].nama_pegawai);
            $(obj).val(data[0].nomorindukpegawai);
            setPegawai(obj, data[0]);
        }, "json");
        $(dialog).dialog("close");
    }

    function setPegawai(obj, item) {
        $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(item.nama_pegawai);
        $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
        $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
        $(obj).parents('tr').find('input[name$="[jabatan_id]"]').val(item.jabatan_id);
        $(obj).parents('tr').find('input[name$="[jabatan_nama]"]').val(item.jabatan_nama);
    }
    /**
     * - digunakan untuk menampilkan field yang masuk ke jenis pelatihan eksternal atau internal
     * @param {type} obj
     * @returns {} */
    function showJenisDiklat(obj) {
        var jenis = $(obj).val();
        if (jenis == <?php echo Params::JENIS_DIKLAT_EKSTERNAL; ?>) {
            internal_pelatihan(false);
            eksternal_pelatihan(false);
            resetInternal();
        } else if (jenis == <?php echo Params::JENIS_DIKLAT_INTERNAL; ?>) {
            internal_pelatihan(true);
            eksternal_pelatihan(true);
            resetEksternal();
        }
        // resetEksternal();    
    }
    /**
     * - digunakan untuk isian jenis pelatihan internal mengembalikan untuk inputan yang berlaku untuk pelatihan internal saja dikembalikan ke semula
     * @returns {undefined} */
    function internal_pelatihan(cek) {
        if (cek == true) {
            $("#internal_pelatihan").attr("style", 'display:block;');
        } else {
            $("#internal_pelatihan").attr("style", 'display:none;');
        }
        $('#table-realisasipelatihan tbody tr').each(function() {
            $(this).find('input[name$="[biaya_pelatihan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_transportasi]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_penginapan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_perjalanandinas]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_lainlain]"]').attr('readonly', cek);
        });
    }
    /**
     * - digunakan untuk isian jenis pelatihan eksternal mengembalikan untuk inputan yang berlaku untuk pelatihan ekternal saja dikembalikan ke semula
     * @returns {} 
     * */
    function eksternal_pelatihan(cek) {
        $('#table-realisasipelatihan tbody tr').each(function() {
            $(this).find('input[name$="[biaya_pelatihan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_transportasi]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_penginapan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_perjalanandinas]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_lainlain]"]').attr('readonly', cek);
            $(this).find('input[name$="[keterangan_lainlain]"]').attr('readonly', cek);
        });
    }
    /**
     * - digunakan untuk mereset field ke nilai semua
     * @returns {undefined} */
    function resetInternal() {
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayapemateri'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayakonsumsi'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayaalatperaga'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayalainlain'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_keteranganlainlain'); ?>").val('');
    }
    /**
     * digunakan untuk mereset field ke nilai semua
     * @returns {undefined}
     */
    function resetEksternal() {
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapelatihan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayatransportasi') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapenginapan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayaperjalanan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayalainlain') ?>").val(0);
        $('#table-realisasipelatihan tbody tr').each(function() {
            $(this).find('input[name$="[biaya_pelatihan]"]').val(0);
            $(this).find('input[name$="[biaya_transportasi]"]').val(0);
            $(this).find('input[name$="[biaya_penginapan]"]').val(0);
            $(this).find('input[name$="[biaya_perjalanandinas]"]').val(0);
            $(this).find('input[name$="[biaya_lainlain]"]').val(0);
            $(this).find('input[name$="[total]"]').val(0);
            $(this).find('input[name$="[keterangan_lainlain]"]').val('');
        });
    }
    $(document).ready(function() {
        <?php if (!empty($modRealisasi->rencanadiklat_id) && $modRealisasi->isNewRecord) : ?>
            setRowRencana('<?php echo $modRealisasi->rencanadiklat_id; ?>');
        <?php endif; ?>
    });
</script>