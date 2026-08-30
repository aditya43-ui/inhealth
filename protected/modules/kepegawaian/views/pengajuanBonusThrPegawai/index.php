<?php $linkHalaman = CustomFunction::getUrlByMenuID(3519); ?>
<?php
$this->breadcrumbs = array(
    'Pengajuan Bonus / THR Pegawai',
);
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengajuanbonusthrpeg-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengajuan THR dan Bonus Pegawai</b>
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
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengajuan THR dan Bonus Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglpengajuan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $model->tglpengajuan = MyFormatter::formatDateTimeForUser($model->tglpengajuan);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglpengajuan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label('Periode Pengajuan <span style = "color:red">*</span>', 'periodebonusthr', array('class' => 'control-label')); ?>
                            <?php //echo $form->labelEx($model, 'periodebonusthr', array('class' => 'control-label', 'label'=>'Periode <span class="ketlabel">Bonus</span>')); 
                            ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyMonthPicker', array(
                                    'model' => $model,
                                    'attribute' => 'periodebonusthr',
                                    'options' => array(
                                        'dateFormat' => Params::MONTH_FORMAT,
                                        'yearRange' => "-100y:+0y",
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => "span2 periodebonusthr",
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onchange' => 'getKeterangan();',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Transaksi <span style="color:red">*</span>', '', array('class' => 'control-label ')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'jenisgaji', LookupM::getItemsUrutan('jenisgaji'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'getLabel()')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'nopengajuan', array('class' => 'control-label inline')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nopengajuan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => TRUE)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'mengetahuirs_id', array('class' => 'control-label', 'label' => 'Mengetahui (RS)')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'mengetahuirs_id', array('readonly' => true)) ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'mengetahuirs_nama',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 4,
                                        'focus' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'mengetahuirs_nama') . '").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                                        'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'mengetahuirs_nama') . '").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($model, 'mengetahuirs_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiRs'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'mengetahui_pt', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'mengetahui_pt', array('readonly' => true)) ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'mengetahui_pt_nama',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 4,
                                        'focus' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'mengetahui_pt_nama') . '").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                                        'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'mengetahui_pt_nama') . '").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($model, 'mengetahui_pt') . '").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiPt'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'menyetujui_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'menyetujui_id', array('readonly' => true)) ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'menyetujui_nama',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 4,
                                        'focus' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'menyetujui_nama') . '").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                                        'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'menyetujui_nama') . '").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keteranganpengajuan', array('rows' => 3, 'cols' => 20, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan <span class="ketlabel">Bonus</span> Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view . '_formCariPegawai', array()); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-user"></i> Data <b>Pegawai</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div id="tablepegawaiBonus">
                            <div style="overflow: auto;">
                                <table class="table table-bordered table-condensed" id="tblbonus">
                                    <thead>
                                        <tr>
                                            <th><?php echo CHtml::checkBox('is_pilihsemua', false, array('onclick' => 'pilihSemua(this)', 'title' => 'Klik untuk pilih / tidak <br>semua Pegawai', 'rel' => 'tooltip')); ?> Pilih</th>
                                            <th>Nama Pegawai</th>
                                            <th>PPh 21</th>
                                            <th>Status Pegawai</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Jenis Gaji</th>
                                            <th>Total Bonus</th>
                                            <th>Tunjangan PPh 21 Bonus</th>
                                            <th>PPh 21 Bonus</th>
                                            <th>Keterangan Bonus</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodybonus">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tablepegawaiThr" style="display: none;">
                            <div style="overflow: auto;">
                                <table class="table table-bordered table-condensed" id="tblthr">
                                    <thead>
                                        <tr>
                                            <th><?php echo CHtml::checkBox('is_pilihsemuaThr', false, array('onclick' => 'pilihSemuaThr(this)', 'title' => 'Klik untuk pilih / tidak <br>semua Pegawai', 'rel' => 'tooltip')); ?> Pilih</th>
                                            <th>Nama Pegawai</th>
                                            <th>PPh 21</th>
                                            <th>Status Pegawai</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Jenis Gaji</th>
                                            <th>Gaji Pokok</th>
                                            <th>Tunjangan Tetap</th>
                                            <th>Total THR</th>
                                            <th>Tunjangan PPh 21 THR</th>
                                            <th>PPh 21 THR</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodythr">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanPengajuan()')
                );
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
                )
            ); ?>
            <?php
            $tips = array(
                '0' => 'waktutime',
                '1' => 'autocomplete-search',
                '2' => 'cari2',
                '3' => 'simpan',
                '4' => 'ulang',
                '5' => 'print',
                '6' => 'status_print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'create', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiRs',
    'options' => array(
        'title' => 'Pegawai Mengetahui RS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new KPRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_DIREKTUR;
if (isset($_GET['KPRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['KPRegistrasifingerprint'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                "id" => "selectPegawai",
                "href"=>"",
                "onClick" => "
                              $(\"#' . CHtml::activeId($model, 'mengetahuirs_nama') . '\").val(\"$data->nama_pegawai\");
                              $(\"#' . CHtml::activeId($model, 'mengetahuirs_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#dialogPegawaiRs\").dialog(\"close\");
                              return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));
$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiPt',
    'options' => array(
        'title' => 'Pegawai Mengetahui PT',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new KPRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_KASI_PERSONALIA;
if (isset($_GET['KPRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['KPRegistrasifingerprint'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai6-m-grid',
    'dataProvider' => $modPegawai->search(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                                  $(\"#' . CHtml::activeId($model, 'mengetahui_pt_nama') . '\").val(\"$data->nama_pegawai\");
                                  $(\"#' . CHtml::activeId($model, 'mengetahui_pt') . '\").val(\"$data->pegawai_id\");
                                  $(\"#dialogPegawaiPt\").dialog(\"close\");
                                  return false;
                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));
$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new KPRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_DIREKTUR_RS;
if (isset($_GET['KPRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['KPRegistrasifingerprint'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                                  $(\"#' . CHtml::activeId($model, 'menyetujui_nama') . '\").val(\"$data->nama_pegawai\");
                                  $(\"#' . CHtml::activeId($model, 'menyetujui_id') . '\").val(\"$data->pegawai_id\");
                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\");
                                  return false;
                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));
$this->endWidget();
?>