<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'jenisstokopname', array('readonly'=>true,'empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50));?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tglstokopname', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglstokopname = (!empty($model->tglstokopname) ? date("d/m/Y H:i:s",strtotime($model->tglstokopname)) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tglstokopname',
                    'mode'=>'datetime',
                    'options'=> array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3 dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            ));
                    // echo $form->textField($model,'tglstokopname',array('class'=>'span3 realtime','readonly'=>true))
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'nostokopname',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'mengetahui_id', array('class'=>'pegawai')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'mengetahui_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            if (!cekPegawaiSama(ui.item.pegawai_id)) {
                                $(this).val("");
                                return false;
                            }
                            $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'span3 namaPegawai',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'mengetahui_id').'");'),
                ));
                ?>
                <?php echo $form->error($model, 'peg_menyetujui_id'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'petugas1_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'petugas1_id', array('class'=>'pegawai')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'petugas1_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            if (!cekPegawaiSama(ui.item.pegawai_id)) {
                                $(this).val("");
                                return false;
                            }
                            $("#'.Chtml::activeId($model, 'petugas1_id') . '").val(ui.item.pegawai_id);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'span3 namaPegawai',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'petugas1_id').'");'),
                ));
                ?>
                <?php echo $form->error($model, 'petugas1_id'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'petugas2_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'petugas2_id', array('class'=>'pegawai')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'petugas2_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            if (!cekPegawaiSama(ui.item.pegawai_id)) {
                                $(this).val("");
                                return false;
                            }
                            $("#'.Chtml::activeId($model, 'petugas2_id') . '").val(ui.item.pegawai_id);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'span3 namaPegawai',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'petugas2_id').'");'),
                ));
                ?>
                <?php echo $form->error($model, 'petugas2_id'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div hidden>
          <?php
                    $this->widget('MyDateTimePicker', array(

                        'name'=>'buatpanggildatetimepicker',
                        'mode' => 'datetime',
                        'htmlOptions' => array(

                            //'size' => '10',
                           // 'style'=>'width:80%'
                            'class'=>'span3 datetimemask',
                            'htmlOptions'=>'display:none;'

                        ),
                        'options' => array(  // (#3)
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',

                        ),

                    ));
?>
        </div>
        <?php echo $form->textFieldRow($model,'totalharga',array('class'=>'span3 integer-decimal', 'readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totalnetto',array('class'=>'span3 integer-decimal', 'readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model,'keterangan_opname',array('rows'=>4, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new GFPegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['GFPegawairuanganV'])){
    $modPegawai->attributes = $_GET['GFPegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
    //'template'=>"{items}\n{pager}",
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    if (!cekPegawaiSama(".$data->pegawai_id.")) return false;
                                    $(\"#\"+parent+\"\").val(".$data->pegawai_id.");
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name'=>'jeniskelamin',
            'filter'=> CHtml::dropDownList('GFPegawaiV[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
            'value'=>'$data->jeniskelamin',
        ),

    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<?php $this->endWidget(); ?>
