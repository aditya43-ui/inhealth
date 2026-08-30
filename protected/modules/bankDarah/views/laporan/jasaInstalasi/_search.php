<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

    </style>
    <fieldset class="box2">
	<legend class="rim">Berdasarkan Kunjungan</legend>
        <table width="100%" style="margin-top:10px;">
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>
                    <div class='control-label'>Tanggal Pelayanan</div>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'maxDate'=>'d',
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                            'class'=>'dtPicker2',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div> 
                </td>
                <td>
                    <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'maxDate'=>'d',
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                            'class'=>'dtPicker2',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
        <table width="100%" border="0">
            <tr>
                <td width="50%"> 
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Status Bayar</legend>
                        <?php echo '<table>
                            <tr>
                                <td>
                                    <div class="penjamin">'.
//                                    $form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"))
									$form->checkBoxList($model, 'tindakansudahbayar_id', LookupM::getItems('statusbayar'), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"))
                                    .'</div>
                                </td>
                             </tr>
                        </table>'; ?>
                    </fieldset>
                </td>
                <td>
                    <div id='searching'>
                        <fieldset class="box2">
                            <legend class="rim">Berdasarkan Jenis Penjamin </legend>
                            <?php echo '<table>
                                <tr>
                                    <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
                                    <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array('type' => 'POST',
                                            'url' => $this->createUrl('GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                            'update' => '#penjamin',  //selector to update
                                        ),
                                    )).'
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Penjamin</label>
                                    </td>
                                    <td>
                                        <div id="penjamin">
                                            <label>Data tidak ditemukan.</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>'; ?>
                        </fieldset>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class' => 'btn btn-default',
                                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
function checkAll() {
    if ($("#checkAllCaraBayar").is(":checked")) {
        $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
}   
</script>