<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakamar-ruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#SAKamarRuanganM_kelaspelayanan_id',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array(
            'class' => 'inputRequire span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih Kelas Pelayanan --'
        ));
        ?>

        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', $instalasiTujuans, array(
                    'class' => 'span2 inputRequire', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                    )
                ));
                ?>
                <?php echo $form->dropDownList($model, 'ruangan_id', $ruanganTujuans, array('class' => 'span2 inputRequire', 'empty' => '-- Pilih Ruangan --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <?php
        // echo $form->dropDownListRow($model,'ruangan_id',  CHtml::listData($model->getRuanganKamarItems(), 'ruangan_id', 'ruangan_nama'),
        //										array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
        //										'empty'=>'-- Pilih Ruangan --')); 
        ?>
        <div class="control-group">
            <div class="control-label">
                <?php echo $form->labelEx($model, 'keterangan_kamar'); ?>
            </div>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'keterangan_kamar', CHtml::listData($model->KeteranganKamarItems, 'lookup_value', 'lookup_name'), array(
                    'empty' => '-- Pilih Keterangan Kamar --',
                    'class' => 'span4',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ));
                ?>
            </div>
        </div>
        <?php 
            if ($this->module->id != 'hemodialisa'){
                echo $form->textFieldRow($model, 'kamarruangan_nokamar', array('placeholder' => 'Nama Kamar', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event);")); 
            }
        ?>
        <?php echo $form->textFieldRow($model, 'kamarruangan_nokamar', array('placeholder' => 'Nama Kamar', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'kamarruangan_jmlbed', array('placeholder' => 'Jumlah Bed', 'class' => 'span2 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'onkeyup' => 'noBed(this)')); ?>
        <?php echo CHtml::hiddenField('jumlahBedSebelumnya'); ?>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo $form->labelEx($model, 'kamarruangan_image', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'kamarruangan_image', array('hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modRiwayatRuanganR, 'tglpenetapanruangan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modRiwayatRuanganR,
                    'attribute' => 'tglpenetapanruangan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'yearRange' => "-60:+0",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($modRiwayatRuanganR, 'tglpenetapanruangan'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modRiwayatRuanganR, 'nopenetapanruangan', array('placeholder' => 'No. Penetapan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($modRiwayatRuanganR, 'tentangpenetapan', array('placeholder' => 'Tentang Penetapan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Kamar Ruangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tbl-kamar" class="table table-bordered table-striped datatable">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'kamarruangan_nobed', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'kamarruangan_nobed[]', array('class' => 'span3 kamarruangan_nobed', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->checkBox($model,'is_bedbayangan[0]',array('uncheckValue'=>null, 'class'=>'is_bedbayangan')); ?> <label>Bed Bayangan</label>
                        </div>
                    </div>

                </td>
                <?php if ($this->module->id == 'hemodialisa'){   
                    echo '<td>';         
                    echo '<div class="control-group">';
                        echo '<label class="control-label">Lantai<span class="required">*</span></label>';
                        echo '<div class="controls">';
                        echo $form->dropDownList($model, 'kamarruangan_nokamar[]', LookupM::getItems('lantai_ruangan_hd'), array( 'class' => 'span4 required',  'onkeypress' => "return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --'));
                        echo '</div>';
                    echo '</div>';
                    echo '</td>';                    
                } ?>
                <td></td>
            </tr>
        </table>
    </div>
</div>


<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kamarRuanganM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan '.($this->module->id == 'hemodialisa')?'Tempat Tidur (Bed)':'Kamar Ruangan', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="entypo-minus-circled"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT

function noBed(obj)
{
    var jmlSekarang = obj.value;
    var jmlSebelumnya = $('#jumlahBedSebelumnya').val();
    var JumlahRowSekarang =$('#tbl-kamar tr').length;
    var idx = 0;
   
   if(jmlSekarang!='')
    {
       if(jmlSekarang<jmlSebelumnya)
          {
            myAlert('Harap Gunakan Tombol Hapus untuk Menghapus');
            $('#SAKamarRuanganM_kamarruangan_jmlbed').val(jmlSebelumnya);
          }
       else
          {
            $('#jumlahBedSebelumnya').val(obj.value);
            for(i=1; i<=jmlSekarang-JumlahRowSekarang; i++)
               {
                    var tr = $('#tbl-kamar tr:first').html();
                    $('#tbl-kamar tr:last').after('<tr>'+tr+'</tr>');
                    $('#tbl-kamar tr:last td:last').append('$buttonMinus');
               }

            $('#tbl-kamar tr').each(function() {
                console.log($(this).find('.kamarruangan_nobed'));
                $(this).find('.kamarruangan_nobed').attr('name', 'SAKamarRuanganM[kamarruangan_nobed][' + idx + ']');
                $(this).find('.is_bedbayangan').attr('name', 'SAKamarRuanganM[is_bedbayangan][' + idx + ']');
                idx++;
            });
          }
      }
    
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else 
    {
        $(obj).parent().parent().remove();
        var jmlBedSebelumnya=$('#SAKamarRuanganM_kamarruangan_jmlbed').val();
        jmlBedSekarang=jmlBedSebelumnya-1;
        $('#SAKamarRuanganM_kamarruangan_jmlbed').val(jmlBedSekarang);
        $('#jumlahBedSebelumnya').val(jmlBedSekarang);

    }
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>