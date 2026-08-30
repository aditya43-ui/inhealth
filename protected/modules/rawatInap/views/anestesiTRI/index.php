<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienanastesi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class'=>'form-iframe','onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
?>

<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<?php

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');

?>

<?php echo $form->errorSummary($model); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Permintaan Anastesi</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-12">
            <table class="items table table-striped table-condensed" id="tblInputAnamnesa">
                <thead>
                    <tr>
                        <th>Tanggal Permintaan</th>
                        <th>Dokter Perujuk</th>
                        <th>Jenis Anestesi</th>
                        <th>Catatan</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($modRiwayat)):?>
                    <?php foreach ($modRiwayat as $i => $dt) { ?>
                    <?php if (!empty($dt->jenisanastesi_id)) { ?>
                    <tr>
                        <td><?php echo MyFormatter::formatDateTimeForUser($dt->tgl_kirimpasien); ?></td>
                            <?php $pegawai = PegawaiM::model()->findByPk($dt->pegawai_id) ?>
                        <td><?php echo  $pegawai->nama_pegawai; ?></td>
                        <td><?php echo !empty($dt->jenisanastesi_id) ? $dt->jenisanastesi->jenisanastesi_nama : "-"; ?></td>   
                        <td><?php echo $dt->catatandokterpengirim; ?></td>   
                        <td style="text-align: center;">
                            <a onclick="hapusAnestesi('<?php echo $dt->pasienkirimkeunitlain_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Anestesi" style="text-align: center;"><i class="icon-form-silang"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php else:?>
                        <tr>
                            <td colspan="5">
                                <label>Data tidak ditemukan</label>
                            </td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Permintaan Anestesi</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                <?php echo CHtml::label('Tanggal Permintaan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modUnitLain,
                            'attribute' => 'tgl_kirimpasien',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false, 'class' => 'span3 required',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                <?php echo CHtml::label('Dokter Perujuk <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= $form->dropDownList($modUnitLain, 'pegawai_id', CHtml::listData(DokterV::model()->findAllByAttributes(array(
								'ruangan_id'=>Yii::app()->user->getState('ruangan_id')
							)), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly' => false)); ?>
                    </div>
                </div>
                <div class="control-group">
                <?php echo CHtml::label('Jenis Anestesi <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?= $form->dropDownList($modUnitLain, 'jenisanastesi_id', CHtml::listData(JenisanastesiM::model()->findAllByAttributes(array(
								'jenisanastesi_aktif'=>true
							)), 'jenisanastesi_id', 'jenisanastesi_nama'), array('empty' => '-- Pilih --', 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly' => false)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
            <div class="control-group">
            <?php echo CHtml::label('Catatan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modUnitLain, 'catatandokterpengirim', array('class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                        <?php echo $form->error($modUnitLain, 'catatandokterpengirim'); ?>
                    </div>
                </div>
            </div>
      </div>
    </div>
</div>

<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
              '',  array('class' => 'btn btn-default', 'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function hapusAnestesi(id, obj) {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus Anestesi ini?', 'Perhatian!', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRiwayatAnestesi'); ?>',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses) {
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    
</script>