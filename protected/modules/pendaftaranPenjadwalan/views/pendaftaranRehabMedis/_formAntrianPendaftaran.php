<style>
    .jml_antrian_free {
        position: relative;
        top: -15px;
        left: -10px;
    }

    .badge_jmlPanggil {
        position: relative;
        top: -15px;
        left: -10px;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Panggil Antrian
        </div>
    </div>
    <div class="panel-body">
        <table class="table-condensed" id="panggil">
            <tr>
                <td style="text-align: left;"><?php echo CHtml::label('Lokasi Pendaftaran', 'Lokasi Pendaftaran', array('class' => '')); ?></td>
                <td style="text-align: left;"><?php echo CHtml::label('Loket Antrian', 'noantrian', array('class' => '')); ?></td>
                <td style="text-align: left;"><?php echo CHtml::label('Antrian', 'Antrian', array('class' => '')); ?></td>
                <td style="text-align: center;">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'panggilAntrian("panggil");', 'id' => 'noantrian', 'style' => 'text-align: center; font-size: 16px; font-weight: bold;')); ?>
                    <a href="#" onclick="return false;" class="badge badge-info pull-right-md badge_jmlPanggil" style="display: none" rel="tooltip" data-original-title="Jumlah panggil yang telah dilakukan"></a>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); ?>
                    <?php echo CHtml::dropDownList('lokasi_karcisantrian', '', CHtml::listData($modAntrian->getLokasiKarcisAntrian(), 'lokasi_karcisantrian_id', 'lokasi_karcisantrian_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setDropdownModelAntrian();')) ?>
                </td>
                <td>
                    <?php // echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id, array()/* CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama') */, array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setFormAntrian("reset");$("#dialog-panggilantrian").dialog("open");')) 
                    ?>
                    <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id, array()/* CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama') */, array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setFormAntrian("ulangi");setFormAntrian("reset");')) ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('modelantrian_id', '', array()/* CHtml::listData($modAntrian->getModelAntrian(), 'modelantrian_id', 'modelantrian_nama') */, array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setDropdownLoket();setFormAntrian("reset");')) ?>
                    <a href="#" onclick="return false;" class="badge badge-info pull-right-md jml_antrian_free" style="display: none" rel="tooltip" data-original-title="Sisa Antrian"></a>
                </td>
                <td style="text-align:center">
                    <!--<div style="margin-top:-40px;">-->
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-backward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("prev");')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-remove"></i>')), array('title' => 'Klik jika pasien tidak datang', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-yellow', 'onclick' => 'batalPanggil();')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-forward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("next");')); ?>
                    <!--</div>-->
                </td>

            </tr>
        </table>
    </div>
</div>