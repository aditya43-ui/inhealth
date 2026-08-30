<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sagolongan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lemaribankjaringan_nama'),
        ));
?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Tanggal</label>
            <div class="controls">
                 <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_monitoring',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>   
            </div>            
        </div>
        
        <div class="control-group">
            <label class="control-label">Test Result</label>
            <div class="controls">
                <?= $form->textField($model,'test_result',['class'=>'numbers-only']) ?> <label>mg/l CaCO3</label>
            </div>
        </div>
    </div>      
    <div class="col-sm-6">               
        <div class="control-group">
            <label class="control-label">Pegawai</label>
            <div class="controls">
                <?php
                    echo $form->hiddenField($model,'pegawai_id',['class'=>'pegawai_id']);
                    $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                                                $.ajax({
                                                url: "' . $this->createUrl('/ActionAutoComplete/dropPetugasRuangan') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                                $(this).val(ui.item.namaLengkap);
                                                return false;
                                            }',
                        'select' => 'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'pegawai_id').'").val(ui.item.pegawai_id);
                                                $("#'.CHtml::activeId($model, 'nama_pegawai').'").val(ui.item.namaLengkap);
                                                return false;
                                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama petugas',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawai_id').'").val("");'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugas'),
                ));
                ?>
            </div>
        </div>
        
        <?= $form->dropDownListRow($model,'status', LookupM::getItemsUrutan('status_monitoring_hd'),['empty'=>'-- Pilih --']) ?>
    </div>
    <div class="clear"></div>
    <hr/>
    <div class="col-sm-12">
        <div class="control-group">
            <label class="control-label"><i class="entypo-info"></i></label>
            <div class="controls">
                <?= $this->renderPartial($this->path_view.'_instruksi') ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php echo $this->renderPartial($this->path_view . '_buttonPengaturan', ['model' => $model], true); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial($this->path_tips . 'detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariDokter = new PegawairuanganV('searchDokterDPJP');
$modCariDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modCariDokter->attributes = $_GET['PegawairuanganV'];
    $modCariDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modCariDokter->jabatan_nama = isset($_GET['PegawairuanganV']['jabatan_nama'])?$_GET['PegawairuanganV']['jabatan_nama']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dpjp-v-grid',
    'dataProvider' => $modCariDokter->searchDialogPegRuangan(),
    'filter' => $modCariDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectDPJP",
                                        "onClick" => "
                                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val($data->pegawai_id);
                                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");                                            
                                            $(\"#dialogPetugas\").dialog(\"close\");
                                        "))',
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeHiddenField($modCariDokter, 'ruangan_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariDokter, 'nama_pegawai', array()),
            'htmlOptions' => array('style' => 'text-align:left;'),
        ),
        'jabatan_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>