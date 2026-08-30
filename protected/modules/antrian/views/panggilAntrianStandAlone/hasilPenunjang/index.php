<style>
    #no_antrian, #antrian_blm_dipanggil, #antrian_tdk_datang, #jumlah_antrian, #kode_antrian{
        height: 120px;
        width: 140px;
        font-size: 70px;
        font-weight: bold;
    }
    #btn_prev, #btn_panggil, #btn_batal, #btn_next {
        height: 35px;
        width: 70px;
    }
    #time{
        font-size: 20px;
        font-weight: bold;
    }
    .badge_jmlPanggil {
        height: 22px;
        width: 50px;
        position: relative;
        top: -13px;
        left: -10px;
        font-size: 16px;
    }
</style>
<div class="panel panel-primary panel-gradient panggil_antrian">
    <div class="panel-heading">
        <div class="panel-title"><b>Pemanggilan Antrian Hasil Penunjang</b></div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::activeHiddenField($modAntrian, 'antrian_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modAntrian, 'jml_panggil', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modAntrian, 'noantrian', array('readonly' => true)); ?>
        <table class="table-condensed" width="100%">
            <tr>
                <td style="text-align: center;"><?php echo CHtml::label('Lokasi Antrian', 'Lokasi Antrian', array('class' => '')); ?></td>
                <td style="text-align: center;"><?php echo CHtml::label('Loket Antrian', 'noantrian', array('class' => '')); ?></td>
                <td style="text-align: center;"><?php echo CHtml::label('Antrian', 'Antrian', array('class' => '')); ?></td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <?php echo CHtml::dropDownList('lokasi_karcisantrian', $modAntrian->lokasi_karcisantrian, CHtml::listData($modAntrian->getLokasiKarcisAntrian(), 'lokasi_karcisantrian_id', 'lokasi_karcisantrian_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setDropdownModelAntrian();')) ?>
                </td>
                <td style="text-align: center;">
                    <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id, array(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setFormAntrian("reset");')) ?>
                </td>
                <td style="text-align: center;">                    
                    <?php echo CHtml::dropDownList('modelantrian_id', '', array(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' =>'setFormAntrian("reset");')) ?>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: center;">
                    <button type="button" class="bs-example" id="kode_antrian" disabled>XX</button>
                    <button type="button" class="bs-example" id="no_antrian" disabled>XX</button>
                    <a href="#" onclick="return false;" class="badge badge-info pull-right-md badge_jmlPanggil" style="display: none" rel="tooltip" data-original-title="Jumlah panggil yg telah dilakukan"></a>
                </td>
                <td style="text-align: center;"></td>
            </tr>
        </table>
        <table class="table-condensed" width="100%">
            <tr>
                <td style="text-align:center">
                    <div>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-backward icon-white"></i>')), array('title' => 'Klik untuk tampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("prev");', 'id' => 'btn_prev')); ?>
                    </div>
                </td>
                <td style="text-align:center">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'panggilAntrian("panggil");', 'id' => 'btn_panggil')); ?>
                    <br>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-remove"></i>')), array('title' => 'Klik jika pasien tidak datang', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-yellow', 'onclick' => 'batalPanggil();', 'id' => 'btn_batal')); ?>
                </td>
                <td style="text-align:center">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-forward icon-white"></i>')), array('title' => 'Klik untuk tampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("next");', 'id' => 'btn_next')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Informasi Nomor Antrian</b></div>
    </div>
    <div class="panel-body">
        <table class="table-condensed" width="100%">
            <tr>
                <td style="text-align: center;"><?php echo CHtml::label('Jumlah Antrian Belum di Panggil', '', array('class' => '')); ?></td>
                <td style="text-align: center;"><?php echo CHtml::label('Jumlah Antrian Tidak Datang', '', array('class' => '')); ?></td>
                <td style="text-align: center;"><?php echo CHtml::label('Jumlah Antrian', '', array('class' => '')); ?></td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <button type="button" class="bs-example" id="antrian_blm_dipanggil" disabled>0</button>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="bs-example" id="antrian_tdk_datang" disabled>0</button>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="bs-example" id="jumlah_antrian" disabled>0</button>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="time"></div>
<?php echo $this->renderPartial('_jsFunctionsAntrian',array('modAntrian'=>$modAntrian)); ?>

<script>
function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  // add a zero in front of numbers<10
  m = checkTime(m);
  s = checkTime(s);
  date = '<?=date('D, d M Y')?>';
  document.getElementById('time').innerHTML = date +" "+ h + ":" + m + ":" + s;
  t = setTimeout(function() {
    startTime()
  }, 500);
}
startTime();
</script>