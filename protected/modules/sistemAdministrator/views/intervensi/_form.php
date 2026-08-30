<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
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

<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField("norow", "", array('readonly' => true)); ?>
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
                        'placeholder' => 'Kode / Nama Diagnosa',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Nama Intervensi', 'intervensi_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'intervensi_nama', LookupM::getItems('levelintervensikeperawatan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onblur' => 'refreshTable();')); ?>

            </div>
        </div>
    </div>
</div>

<div class="row-fluid block-tabel">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel <b>Intervensi</b></div>
        </div>
        <div class="panel-body" style="overflow-y: auto;">

            <table id="table-lookup" class="table table-striped table-bordered table-condensed">
                <thead>
                <th>Intervensi Keperawatan</th>
                <th>Status</th>
                <th colspan="2"></th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/create'), array(
            'class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);')) . "&nbsp";
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tautan SDKI-SIKI', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => ($this->hasTab == TRUE) ? 'frame' : null)), array('class' => 'btn btn-success')); ?>

        <?php
        $tips = array(
            '0' => 'autocomplete-search',
            '1' => 'tambah',
            '2' => 'kurang',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'create', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDetail' => $modDetail)); ?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
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
$modDiagnosaKep->diagnosakep_aktif = true;
if (isset($_GET['SADiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['SADiagnosakepM'];
    $modDiagnosaKep->diagnosakep_aktif = true;
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
                    'diagnosakep_aktif', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
                '0' => 'Tidak Aktif',), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogJenisIntervensi',
    'options' => array(
        'title' => 'Pencarian Intervensi Keperawatan',
        'autoOpen' => false,
        'width' => 760,
        'height' => 500,
        'resizable' => true,
    ),
        )
);
$modJenis = new JenisintervensiM('search');
$modJenis->unsetAttributes();
$modJenis->jenisintervensi_aktif = true;
if (isset($_GET['JenisintervensiM'])) {
    $modJenis->attributes = $_GET['JenisintervensiM'];
}

echo CHtml::hiddenField("noUrutRow", "", array('reasonly' => true));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogjenis-m-grid',
    'dataProvider' => $modJenis->search(),
    'filter' => $modJenis,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $load = $data->attributes;

                $res = json_encode($load);

                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "javascript:;", array("class" => "btn-small",
                            "onclick" => 'setRincian(' . $res . ');'));
            },
        ),
        array(
            'header' => 'Kode',
            'name' => 'jenisintervensi_kode',
            'value' => '$data->jenisintervensi_kode'
        ),
        array(
            'header' => 'Nama',
            'name' => 'jenisintervensi_nama',
            'value' => '$data->jenisintervensi_nama'
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'jenisintervensi_deskripsi',
            'value' => '$data->jenisintervensi_deskripsi'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>