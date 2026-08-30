<style>
    .input-append>*,
    tr td .add-on {
        float: left !important;
        margin: 0 !important;
    }
</style>

<?php
$criteria = new CDbCriteria;
if (!empty($ruangan_id)) {
    $criteria->addCondition("ruangan_id = " . $ruangan_id);
}
$criteria->compare('LOWER(hari)', strtolower($hariCari));

$modJadwalBukaPoli =  PPJadwalBukaPoliM::model()->findAll($criteria);
if (count((array)$modJadwalBukaPoli) > 0) {
    foreach ($modJadwalBukaPoli as $i => $tampilData) { ?>
        <div id="jadwal_<?php echo $tampilData->jadwalbukapoli_id; ?>">
            Jam Buka : <br>
            <?php echo CHtml::link($tampilData->jmabuka . ' <i class="icon-form-ubah" style="float: right;"></i>', 'javascript:void(0)', array('onclick' => 'ubahWaktu(' . $tampilData->jadwalbukapoli_id . ',\'' . $tampilData->jammulai . '\',\'' . $tampilData->jamtutup . '\')', 'rel' => "tooltip", 'data-original-title' => "Klik untuk Mengubah Jam Buka")) ?>

        </div>
        <div id="ubahjadwal_<?php echo $tampilData->jadwalbukapoli_id; ?>" class="hide">
            Jam Buka :
            <?php
            $this->widget('MyDateTimePicker', array(
                'name' => 'jammulai_' . $tampilData->jadwalbukapoli_id,
                'value' => $tampilData->jammulai,
                'mode' => 'time',
                'options' => array(
                    'onSelect' => 'js:function(){}',
                ),
                'htmlOptions' => array(
                    'readonly' => true, 'class' => 'jam dtPicker1 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?> s.d
            <?php
            $this->widget('MyDateTimePicker', array(
                'name' => 'jamtutup_' . $tampilData->jadwalbukapoli_id,
                'value' => $tampilData->jamtutup,
                'mode' => 'time',
                'options' => array(
                    'onSelect' => 'js:function(){}',
                ),
                'htmlOptions' => array(
                    'readonly' => true, 'class' => 'jam dtPicker1 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
            <div style="margin: 10px 0;">
            <?php echo CHtml::link('<i class="entypo-check"></i> Simpan', 'javascript:void(0)', array('onclick' => 'prosesUbah(' . $tampilData->jadwalbukapoli_id . ')', 'class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link('<i class="entypo-cancel"></i> Batal', 'javascript:void(0)', array('onclick' => 'batalUbah(' . $tampilData->jadwalbukapoli_id . ',\'' . $tampilData->jammulai . '\',\'' . $tampilData->jamtutup . '\')', 'class' => 'btn btn-default')); ?>
        </div>
        </div>

<?php echo "Max Antrian : " . $tampilData['maxantiranpoli'] . "<br><br>";
    }
} else {
    echo "-";
}

?>

<script type="text/javascript">
    function ubahWaktu(idJadwal) {
        $('#jadwal_' + idJadwal).addClass('hide');
        $('#ubahjadwal_' + idJadwal).removeClass('hide');
    }

    function batalUbah(idJadwal, jamMulai, jamTutup) {
        $('#ubahjadwal_' + idJadwal).addClass('hide');
        $('#jadwal_' + idJadwal).removeClass('hide');
    }

    function prosesUbah(idJadwal) {
        var jamMulai = $('#jammulai_' + idJadwal).val();
        var jamTutup = $('#jamtutup_' + idJadwal).val();
        $.post('<?php echo $this->createUrl('ubahJamBukaPoli') ?>', {
            idJadwal: idJadwal,
            jamMulai: jamMulai,
            jamTutup: jamTutup
        }, function(data) {
            if (data.status == 'OK')
                $.fn.yiiGridView.update('pencarianjadwal-grid');
            else
                myAlert('Gagal merubah Jadwal');
        }, 'json');
    }
</script>