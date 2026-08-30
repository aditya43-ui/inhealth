<style>
th {
    background-color: #ececec;
}

.input-append .hasDatepicker {
    border-radius: 5px;
}

.btn-info {
    background-color: #76A2BE;
    border-color: #76A2BE;
}

.btn-info:hover {
    background-color: #678DA6;
    border-color: #678DA6;
}

</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'buatjadwal-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#lamaterapi',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        )); 

$tgl_jadwal = '';
$nama_petugas = '';
$tgl_pemeriksaan = date('Y-m-d H:i:s');
if(!empty($kirim->tgl_jadwalpemeriksaan)) {
    $tgl_jadwal = MyFormatter::formatDateTimeForUser($kirim->tgl_jadwalpemeriksaan);
}

if(!empty($kirim->petugas)) {
    $nama_petugas = $kirim->petugas->nama_pegawai;
}  

if(!empty($kirim->tgl_kirimpasien)) {
    $tgl_pemeriksaan = MyFormatter::formatDateTimeForUser($kirim->tgl_kirimpasien);
}
?>
<?= Chtml::hiddenField('pasienkirimkeunitlain_id', $kirim->pasienkirimkeunitlain_id ?? '') ?>
<table style="width: 100%;" class="table table-bordered">
    <tr>
        <th style="width: 7%;">No.</th> 
        <th style="width: 35%;">Jenis Pemeriksaan</th>
        <th style="width: 30%;">Tanggal Jadwal Pemeriksaan</th>
        <th>Petugas</th>
    </tr>

    <tr>
        <td>1</td>
        <td><?= $kirim->ruangan->ruangan_nama ?></td>
        <td><?= $tgl_jadwal ?></td>
        <td><?= $nama_petugas ?></td>
    </tr>
</table>
<br>
<div class="row row-fluid">
    <div class="col-sm-8">
        <table style="width: 100%;">
            <tr>
                <td nowrap>Tanggal Pemeriksaan&emsp;</td>
                <td>
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'tgl_kirimpasien',
                        'value' => $tgl_pemeriksaan,
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'disabled' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'tgl_kirimpasien', 'class' => 'span4'
                        ),
                    ));
                ?>
                </td>
            </tr>
            <tr>
                <td nowrap>Tanggal Jadwal Pemeriksaan&emsp;</td>
                <td>
           
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'tglrencanapemeriksaan',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'tglrencanapemeriksaan', 'class' => 'span4'
                        ),
                    ));
                ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4" style="vertical-align: bottom; margin-top: 20px;">
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(
                Yii::t('mds', 'Simpan Jadwal', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-info submit', 'title' => 'Simpan', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
            );
        ?>
</div>
    </div>
</div>






<?php $this->endWidget(); ?>

<script>

$('.add-on').addClass('hide');


</script>