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
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo Chtml::label('Diagnosa Keperawatan <span class="required">*</span>', 'diagnosakep_id', ['class' => 'col-sm-2']) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField("norow", "", array('readonly' => true)); ?>        
                <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>
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
                        'class' => 'required',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Jenis Faktor Risiko', 'faktorrisiko_nama', array('class' => 'col-sm-2')) ?>
            <div class="controls">
                <?php
                    /*
                    echo $form->dropDownList($model, 'faktorrisiko_nama', LookupM::getItems('faktorris_as'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'inputRequire',
                        'onchange' => 'refreshTable();')
                    );
                     */

                    //echo $form->textField($model, 'faktorrisiko_nama', array('class' => 'inputRequire', 'onblur' => 'refreshTable()'));
                    
                    echo $form->dropDownList($model, 'faktorrisiko_nama', $model->jenisfaktorrisiko(), [
                        'empty' => '-- Pilih --'
                        , 'onkeypress' => "return $(this).focusNextInputField(event)"
                        , 'class' => 'inputRequire'
                        , 'onchange' => 'refreshTable(); setJenisFaktor();'
                    ]);
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Faktor Risiko', 'kelompokfaktorrisikodaftar_id', array('class' => 'col-sm-2')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField("kelompokfaktorrisikodaftar_id", "", array('readonly' => true)); ?>
                <?php
                    /*
                    $this->widget('MyJuiAutoComplete', array(
                        'model'     => $model,
                        'attribute' => 'faktorrisiko_daftar_nama',
                        'source'    => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutoCompleteKelompokfaktorrisikodaftar') . '",
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
                                            $("#' . CHtml::activeId($model, 'kelompokfaktorrisikodaftar_id') . '").val(ui.item.diagnosakep_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array(
                            'placeholder'   => 'Kode / Nama Diagnosa',
                            'onkeypress'    => "return $(this).focusNextInputField(event)",

                        ),
                        'tombolDialog' => array('idDialog' => 'dialogKelompok','jsFunction' => 'cekJenis();'),
                    ));
                     */
                ?>
                <?php echo CHtml::link('<i class="entypo-search"></i>', '#', array('class'=>'btn btn-info','onclick'=>'cekJenis();')); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid block-tabel">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel <b>Faktor Risiko</b></div>
        </div>
        <div class="panel-body" style="overflow-y: auto;">

            <table id="table-lookup" class="table table-striped table-bordered table-condensed">
                <thead>
                <th>Faktor Risiko<span style="color: red">*</span></th>
                <th>Status</th>
                <th colspan="1"></th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Faktor Risiko', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDetail' => $modDetail, 'kelompok'=>$kelompok)); ?>
<div style="display: none;">
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
        if (isset($_GET['SADiagnosakepM'])) {
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
                            'diagnosakep_aktif', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
                        '0' => 'Tidak Aktif',), array('empty' => '-- Pilih --'))
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));

        $this->endWidget();

        //========= Dialog buat cari data Rekening Debit =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogDaftarRisiko',
            'options' => array(
                'title' => 'Daftar Risiko',
                'autoOpen' => false,
                'modal' => true,
                'width' => 800,
                'height' => 500,
                'resizable' => false,
            ),
        ));

        $modRisiko = new FaktorrisikoDaftarM('search');
        $modRisiko->unsetAttributes();
        if (isset($_GET['FaktorrisikoDaftarM'])) {
            $modRisiko->attributes = $_GET['FaktorrisikoDaftarM'];
        }

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'faktorrisikodaftar-m-grid',
            'dataProvider' => $modRisiko->search(),
            'filter' => $modRisiko,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => function($data) {
                        return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "#", array("class" => "btn-small",
                                    "onclick" => " setFaktorRisikodialog(" . $data->faktorrisiko_daftar_id . ", '" . $data->faktorrisiko_daftar_nama . "', this); $('#dialogDaftarRisiko').dialog('close'); "));
                    },
                ),
                array(
                    'header' => 'Nama Risiko',
                    'type' => 'raw',
                    'name' => 'faktorrisiko_daftar_nama',
                    'value' => '$data->faktorrisiko_daftar_nama',
                ),
                array(
                    'header' => 'Nama Lain Risiko',
                    'name' => 'faktorrisiko_daftar_namalain',
                    'value' => '$data->faktorrisiko_daftar_namalain',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));

        $this->endWidget();
        
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogKelompok',
            'options' => array(
                'title'     => 'Faktor Risiko',
                'autoOpen'  => false,
                'modal'     => true,
                'width'     => 800,
                'height'    => 500,
                'resizable' => false,
            ),
        ));

        $modKelompok = new SAKelompokfaktorrisikodaftarM;
        $modKelompok->unsetAttributes();
        
        if (isset($_GET['SAKelompokfaktorrisikodaftarM'])) {
            $modKelompok->attributes = $_GET['SAKelompokfaktorrisikodaftarM'];
            $modKelompok->jenisfaktorrisiko_id = isset($_GET['SAKelompokfaktorrisikodaftarM']['jenisfaktorrisiko_id']) ? $_GET['SAKelompokfaktorrisikodaftarM']['jenisfaktorrisiko_id'] : '';
            $modKelompok->faktorrisiko_daftar_nama = isset($_GET['SAKelompokfaktorrisikodaftarM']['faktorrisiko_daftar_nama']) ? $_GET['SAKelompokfaktorrisikodaftarM']['faktorrisiko_daftar_nama']: '';
            $modKelompok->faktorrisiko_daftar_namalain = isset($_GET['SAKelompokfaktorrisikodaftarM']['faktorrisiko_daftar_namalain']) ? $_GET['SAKelompokfaktorrisikodaftarM']['faktorrisiko_daftar_namalain'] : null;
        }

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'            => 'kelompokresiko-m-grid',
            'dataProvider'  => $modKelompok->searchDialog(),
            'filter'        => $modKelompok,
            'template'      => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns'       => [
                [
                    'header'    => 'Pilih Semua <br/>'.CHtml::checkBox('pilihSemua', false, [ 'class' => 'check_all_produk'
                        , 'onchange' => 'setSemuaKelompok(this);'
                    ]),
                    'type'      => 'raw',
                    'value'     => function($data) {
                        return CHtml::checkBox('check', false, [
                            'kelompokfaktorrisikodaftar_id' => $data["kelompokfaktorrisikodaftar_id"],
                            'faktorrisiko_daftar_nama' => $data['faktorrisiko_daftar_nama'],
                            'onchange'  => 'setKelompok(this);',
                            'class'     => 'pilih',
                            'id'        => 'check_'.$data["kelompokfaktorrisikodaftar_id"],
                        ]);
                    },
                    'htmlOptions'       => array('style' => 'text-align: center'),
                    'headerHtmlOptions' => array('style' => 'text-align: center'),
                    'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputKelompok();'))
                ],
                [
                    'header'    => 'Nama Resiko',
                    'name'      => 'faktorrisiko_daftar_nama',
                    'value'     => '$data->faktorrisiko_daftar_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align: middle'),
                ],
                [
                    'header'    => 'Nama Lain Resiko',
                    'name'      => 'faktorrisiko_daftar_namalain',
                    'value'     => '$data->faktorrisiko_daftar_namalain',
                    'headerHtmlOptions' => array('style' => 'vertical-align: middle'),
                    'filter' => CHtml::hiddenField('SAKelompokfaktorrisikodaftarM[jenisfaktorrisiko_id]', $modKelompok->jenisfaktorrisiko_id, array('empty' => '-- Pilih --'))
                ],
            ],
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});setCeklisDiagnosa();}',
        ));

        $this->endWidget();
    ?>
</div>