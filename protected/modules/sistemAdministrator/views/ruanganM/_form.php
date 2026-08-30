<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#instalasi_id',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),

));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList(
                    'instalasi_id',
                    '',
                    CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'empty' => '-- Pilih --', 'onchange' => 'getRiwayatRuangan(this)'
                    )
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6" hidden>
        <?php echo $form->textField($modRiwayatRuangan, 'tglpenetapanruangan', array('style' => 'width: 124px;', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $modRiwayatRuangan->getAttributeLabel('tglpenetapanruangan'))); ?>
    </div>
    <div class="col-md-6" hidden>
        <?php echo $form->textField($modRiwayatRuangan, 'nopenetapanruangan', array('style' => 'width: 124px;', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $modRiwayatRuangan->getAttributeLabel('nopenetapanruangan'))); ?>
    </div>
    <div class="col-md-6" hidden>
        <?php echo $form->textField($modRiwayatRuangan, 'tentangpenetapan', array('style' => 'width: 124px;', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $modRiwayatRuangan->getAttributeLabel('tentangpenetapan'))); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Ruangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tbl-ruangan" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model, '[1]ruangan_nama', array('class' => 'inputRequire span3', 'style' => 'width: 124px;', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('ruangan_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model, '[1]ruangan_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('ruangan_namalainnya'))); ?>
                </td>
                <td>
                    <?php // echo $form->textField($model,'[1]ruangan_lokasi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_lokasi'))); 
                    ?>
                    <?php echo $form->dropDownList(
                        $model,
                        '[1]ruangan_lokasi',
                        CHtml::listData($model->LokasiItems, 'lookup_value', 'lookup_name'),
                        array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih Lokasi --',
                            'class' => 'span2'
                        )
                    ); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, '[1]ruangan_singkatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('ruangan_singkatan'))); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, '[1]kode_bpjs', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('kode_bpjs'))); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, '[1]ruangan_jenispelayanan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('ruangan_jenispelayanan'))); ?>
                </td>
                <td>
                    <?php echo $form->textField($model, '[1]ruangan_fasilitas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('ruangan_fasilitas'))); ?>
                    <?php echo Chtml::activeFileField($model, '[1]ruangan_image', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'placeholder' => $model->getAttributeLabel('ruangan_image'))); ?>
                </td>

                <td>
                    <?php echo CHtml::button('+', array('class' => 'btn btn-primary', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);', 'id' => 'row1-plus')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'formSubmit(this,event)', 'onclick' => 'formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Ruangan', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$urlGetRiwayatRuangan = $this->createUrl('getRiwayatRuangan');
$tglpenetapanruangan = CHtml::activeId($modRiwayatRuangan, 'tglpenetapanruangan');
$nopenetapanruangan = CHtml::activeId($modRiwayatRuangan, 'nopenetapanruangan');
$tentangpenetapan = CHtml::activeId($modRiwayatRuangan, 'tentangpenetapan');

$js = <<< JSCRIPT

function getRiwayatRuangan(obj)
{
   $.post("${urlGetRiwayatRuangan}",{instalasi_id: obj.value},
        function(data){
        $('#${tglpenetapanruangan}').val(data.tglpenetapanruangan);
        $('#${nopenetapanruangan}').val(data.nopenetapanruangan);
        $('#${tentangpenetapan}').val(data.tentangpenetapan);
        
        },"json");
                   
                
}

function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('SARuanganM','ruangan_nama');
			renameInput('SARuanganM','ruangan_namalainnya');
			renameInput('SARuanganM','ruangan_lokasi');
		}
	});
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama) {
        $(nama).parents('tr').find('input[name$="[ruangan_namalainnya]"]').val(nama.value.toUpperCase());
    }

    function addRow(obj) {
        var row = '<?php echo CJSON::encode($this->renderPartial('_row', array('model' => $model), true)); ?>'
        $('#tbl-ruangan').append(row);
        renameInputRow($("#tbl-ruangan"));
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find(".nomor").html(row + 1);
            $(this).find(".biayapenelitian_tahun").val(row + 1);
            $(this).attr('data-row', row);
            $(this).find("#no_urut").val(row);
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }
</script>