<?php $linkHalaman = CustomFunction::getUrlByMenuID(3586); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Pemusnahan Rekam Medis',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b> Pemusnahan Rekam Medis </b>
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
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScript('search', "
                            $('#searchCari').submit(function(){
                                $.fn.yiiGridView.update('pasien-m-grid', {
                                    data: $(this).serialize()
                                });
                                setUrutan();
                                return false;
                            });
                        ");
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . '_searchPasien', array(
                        'modPasien' => $modPasien,
                    )); ?>
                </div>
            </div>
        </div>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemusnahanrekammedis-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tabelPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Pemusnahan <b>Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary($model); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tglpemusnahanrekammedis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $model->tglpemusnahanrekammedis = MyFormatter::formatDateTimeForUser($model->tglpemusnahanrekammedis);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglpemusnahanrekammedis',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nopemusnahanrekammedis', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
                                <?php
                                $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                $model->pegawai_nama = $modPegawai->namaLengkap;
                                echo $form->textField($model, 'pegawai_nama', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::activeLabel($model, 'penanggungjawab_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'penanggungjawab_id', array('readonly' => true)); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'penanggungjawab_nama',
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
                                                    $("#' . CHtml::activeId($model, 'penanggungjawab_id') . '").val(ui.item.penanggungjawab_id); 
                                                    $("#' . CHtml::activeId($model, 'penanggungjawab_nama') . '").val(ui.item.nama_pegawai); 
                                                    return false;
                                                }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'penanggungjawab_id') . '").val(""); ',
                                        'class' => 'span3',
                                        'placeholder' => 'Pegawai Mengetahui'
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui',),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 3, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'cekInputan();', 'onclick' => 'cekInputan();')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'disabled' => true, 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'cekInputan();', 'onclick' => 'cekInputan();')
                );
            }
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
            ); ?>
            <?php
            $tips = array(
                '0' => 'cari2',
                '1' => 'simpan',
                '2' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
//========= Dialog untuk mencari data Pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
$modPegawai->instalasi_id = Yii::app()->user->getState('instalasi_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$prov = $modPegawai->search();
$prov->sort->defaultOrder = 'nama_pegawai';
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $prov,
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "href"=>"",
                    "id" => "selectPegawai",
                    "onClick" => "
                        $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                        $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->NamaLengkap\");
                        $(\"#dialogPegawai\").dialog(\"close\"); 
                        return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->NamaLengkap',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end data Pegawai dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
$modPegawai = new PegawaiV();
$modPegawai->unsetAttributes();
$modPegawai->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPegawai->attributes = $_GET['PegawaiV'];
}
$prov = $modPegawai->search();
$prov->criteria->addCondition("nama_pegawai is not null and trim(nama_pegawai) <> ''");
$prov->sort->defaultOrder = 'nama_pegawai';
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $prov,
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "href"=>"",
                    "id" => "selectPegawaiMengetahui",
                    "onClick" => "
                        $(\"#' . CHtml::activeId($model, 'penanggungjawab_id') . '\").val(\"$data->pegawai_id\");
                        $(\"#' . CHtml::activeId($model, 'penanggungjawab_nama') . '\").val(\"$data->NamaLengkap\");
                        $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                        return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->NamaLengkap',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien)); ?>