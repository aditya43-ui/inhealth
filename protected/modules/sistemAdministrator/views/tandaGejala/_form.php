<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bataskarakteristik-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lookup_type'),
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php echo CHtml::hiddenField('norow', 0); ?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'diagnosakep_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosakep_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutoCompleteDiagnosaKeperawatan') . '",
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
                        'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            return false;
                                    }',
                        'select' => 'js:function( event, ui ) { 
                                            $("#' . CHtml::activeId($model, 'diagnosakep_id') . '").val(ui.item.diagnosakep_id);
                                            return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Kode / Nama Diagnosa',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Tanda dan Gejala', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenistandagejala', JenistandagejalaM::getDropDownJenis(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setKelompokTandaGejala(); refreshTable();')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Tanda dan Gejala', 'kelompoktandagejaladaftar_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'kelompoktandagejaladaftar_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'tandagejala_daftar_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteKelompokTandaGejala') . '",
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
                        'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.value);
                                        return false;
                                    }',
                        'select' => 'js:function( event, ui ) { 
                                        $("#' . CHtml::activeId($model, 'kelompoktandagejaladaftar_id') . '").val(ui.item.kelompoktandagejaladaftar_id);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Tanda dan Gejala',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogKelompokTandaGejala', 'jsFunction' => 'setCeklisKelompok();'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'tandagejala_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'tandagejala_aktif', array('checked' => 'tandagejala_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
</div>
<div class="row-fluid block-tabel">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel <b>Tanda dan Gejala</b></div>
        </div>
        <div class="panel-body" style="overflow-y: auto;">
            <table id="table-kelompok" class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="text-align: center">Tanda dan Gejala <span style="color: red">*</span></th>
                        <th style="text-align: center">Status</th>
                        <th style="text-align: center">Hapus</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tanda dan Gejala', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDet' => $modDet)); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array()); ?>
<?php
//================= Dialog buat cari data Diagnosa Keperawatan =================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new SADiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['SADiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['SADiagnosakepM'];
    $modDiagnosaKep->attributes = $_GET['SADiagnosakepM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->search(),
    'filter' => $modDiagnosaKep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectDiagnosa",
                            "onClick" => "
                            $(\"#' . CHtml::activeId($model, 'diagnosakep_id') . '\").val(\'$data->diagnosakep_id\');
                            $(\"#' . CHtml::activeId($model, 'diagnosakep_nama') . '\").val(\'$data->diagnosakep_nama\');

                            $(\'#dialogDiagnosa\').dialog(\'close\');
                            refreshTable();
                            return false;"))'
        ),
        array(
            'header' => 'Kode Diagnosa',
            'name' => 'diagnosakep_kode',
            'value' => '$data->diagnosakep_kode',
        ),
        array(
            'header' => 'Diagnosa Keperawatan',
            'type' => 'raw',
            'name' => 'diagnosakep_nama',
            'value' => '$data->diagnosakep_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'diagnosakep_deskripsi',
            'value' => '$data->diagnosakep_deskripsi',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
            'filter' => CHtml::dropDownList(
                    'SADiagnosakepM[diagnosakep_aktif]', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
                '0' => 'Tidak Aktif',), array('empty' => '--Pilih--'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
/* ========= Dialog buat cari Spesimen ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKelompokTandaGejala',
    'options' => array(
        'title' => 'Daftar Tanda Gejala',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));

$modKelompokGejala = new KelompoktandagejaladaftarM('searchDialog');
if (isset($_GET['KelompoktandagejaladaftarM'])) {
    $modKelompokGejala->attributes = $_GET['KelompoktandagejaladaftarM'];
    $modKelompokGejala->tandagejala_daftar_nama = !empty($_GET['KelompoktandagejaladaftarM']['tandagejala_daftar_nama']) ? $_GET['KelompoktandagejaladaftarM']['tandagejala_daftar_nama'] : null;
//    $modKelompokGejala->jenistandagejala_id = $_GET['KelompoktandagejaladaftarM']['jenistandagejala_id'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kelompoktandagejaladaftar-m-grid',
    'dataProvider' => $modKelompokGejala->searchTandaGejala(),
    'filter' => $modKelompokGejala,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaKelompok(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'kelompoktandagejaladaftar_id' => $data["kelompoktandagejaladaftar_id"],
                            'onchange' => 'setKelompok(this);',
                            'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-green', 'onclick' => 'inputKelompok();'))
        ),
        array(
            'header' => 'Nama Tanda Gejala',
            'name' => 'tandagejala_daftar_nama',
            'value' => '$data->tandagejala_daftar_nama',
        ),
        array(
            'header' => 'Jenis Tanda Gejala',
            'name' => 'jenistandagejala_id',
            'value' => function($data) {
                $cekJenis = JenistandagejalaM::model()->findByPk($data->jenistandagejala_id);
                if(!empty($cekJenis)){
                    return $jenistandagejala_nama = $cekJenis->jenistandagejala_nama . ' - ' . $cekJenis->subjenistandagejala_nama;;
                }else{
                    return '';
                }
            },
            'filter' => CHtml::hiddenField('KelompoktandagejaladaftarM[jenistandagejala_id]', $modKelompokGejala->jenistandagejala_id, array('empty' => '--Pilih--'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                            setCeklisKelompok();
                        }',
));
$this->endWidget();
?>