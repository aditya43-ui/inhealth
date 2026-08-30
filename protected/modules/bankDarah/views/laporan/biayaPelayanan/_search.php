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
            <td width="60%">
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Kelas Pelayanan </legend>
                    <div style='margin-left: 0;'>
                        <?php echo CHtml::checkBox('checkAllKelas', true, array('onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) . " Pilih Semua";
                        ?>
                    </div>
                    <?php echo'<table>
                                                <tr>
                                                    <td>
                                                        <div id="kelasPelayanan">' .
                    $form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
                                                        </div>
                                                    </td>
                                                 </tr>
                                                 </table>';
                    ?>
                </fieldset>
            </td>
            <td>
                <div id='searching'>
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Jenis Penjamin </legend>
                        <?php
                        echo '<table>
                                                    <tr>
                                                        <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Cara&nbsp;Bayar</label></td>
                                                        <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array('type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                'update' => '#penjamin', //selector to update
                            ),
                        )) . '
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
                                                 </table>';
                        ?>
                    </fieldset>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>

<script>
    function checkAll() {
        if ($("#checkAllKelas").is(":checked")) {
            $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }

        if ($("#checkAllCaraBayar").is(":checked")) {
            $('#penjamin input[name*="penjamin_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#penjamin input[name*="penjamin_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }
    }
</script>

<?php
//$urlGetPenjamin = Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().''));
//Yii::app()->clientScript->registerScript('ajax','
//    $("#'.CHtml::activeId($model, 'carabayar_id').'").change(function(){
//        id = $(this).val();
//        $.post("'.$urlGetPenjamin.'", {id:id},function(data){
//            
//        });
//    });
//',CClientScript::POS_READY); 
?>

<?php
//Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
