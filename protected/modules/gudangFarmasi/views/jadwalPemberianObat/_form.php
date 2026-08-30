<style>
    .ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-draggable{
        z-index: 1000 !important;
    }
</style>
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
    <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Sub Jenis Obat', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'subjenis_id', array('class'=>'subjenis_id'));
                $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'subjenis_nama',
                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                                url: "' . $this->createUrl('/actionAutoComplete/listSubJenisOa') . '",
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
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                $(this).val( "");
                                                return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                    setSubjenis(ui.item);
                                    return false;
                                }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogSubJenis','jsFunction'=>'$("#dialogSubJenis").dialog("open");refreshGridSubjenis();'),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik sub jenis obat', 'class' => 'span3 subjenis_nama', 'rel' => 'tooltip', 'title' => 'Ketik nama subjenis untuk mencari data sub jenis obat',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === ""){$(".subjenis_id").val("");loadJadwal()} '
                        ),
                ));
                ?>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Signa OA', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'signa_oa',
                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                                url: "' . $this->createUrl('/actionAutoComplete/listSubJenisOa') . '",
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
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                $(this).val( "");
                                                return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                    setSigna(ui.item);
                                    return false;
                                }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogSigna','jsFunction'=>'refreshGridSigna();$("#dialogSigna").dialog("open");'),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik signa oa', 'class' => 'span3 signaoa', 'rel' => 'tooltip', 'title' => 'Ketik signa oa',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'loadJadwal()'
                        ),
                ));
                ?>
            </div>
        </div>		
    </div>
    
    <div class="clear"></div>
    
    <table class="table table-bordered table-condensed table-stripped form-utama" id="table-list-jadwal" del="jadwal">
        <thead>
            <tr>
                <th>No.</th>
                <th>Jadwal</th>
                <th>Urutan</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="form-body">
            
        </tbody>
    </table>
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
<?php $this->endWidget(); 

echo $this->renderPartial($this->path_view.'_dialog',[], true);
echo $this->renderPartial($this->path_view.'_jsFunctions',[], true);
?>
