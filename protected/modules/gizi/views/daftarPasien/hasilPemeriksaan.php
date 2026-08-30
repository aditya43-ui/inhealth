<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pppendaftaran-mp-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'type' => 'horizontal',
    'focus' => '#isPasienLama',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
//
?>
<?php $this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial('/_ringkasDataPasien', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
?>

<?php
$i = 0;
foreach ($modDetailHasilPemeriksaanLab as $dataDetailpemeriksaaanLab) :
    $jenis = $dataDetailpemeriksaaanLab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
    $kelDetail = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->kelompokdet;
    $periksa[$jenis][$kelDetail][$i]['detailhasilpemeriksaanlab_id'] = $dataDetailpemeriksaaanLab['detailhasilpemeriksaanlab_id'];
    $periksa[$jenis][$kelDetail][$i]['hasilpemeriksaan'] = $dataDetailpemeriksaaanLab['hasilpemeriksaan'];
    $periksa[$jenis][$kelDetail][$i]['nilairujukan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_nama;
    $periksa[$jenis][$kelDetail][$i]['hasilpemeriksaan_satuan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_satuan;
    $periksa[$jenis][$kelDetail][$i]['hasilpemeriksaan_metode'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_metode;
    $periksa[$jenis][$kelDetail][$i]['nilairujukan_keterangan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
    $periksa[$jenis][$kelDetail][$i]['namapemeriksaandet'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->namapemeriksaandet;
    $i++;
endforeach;
?>

<?php
foreach ($periksa as $jenis => $kelompok) {
    echo '<table class="table table-bordered table-condensed">
        <thead>  
        <tr>
            <th class="span2"><h4>' . strtoupper($jenis) . '</h4></th>
            <th>Detail Pemeriksaan</th>
            <th>Hasil Pemeriksaan</th>
            <th>Nilai Rujukan</th>
            <th>Satuan</th>
            <th>Metode</th>
            <th>Keterangan</th>
        </tr>
        </thead> 
        <tbody>';
    foreach ($kelompok as $kelDetail => $details) {
        $colspan = (count((array)$details) > 1) ? (count((array)$details) + 1) : 0;
        if ($colspan > 0) {
            echo '<tr><td rowspan="' . $colspan . '"><i>' . $kelDetail . '</i></td></tr>';
            foreach ($details as $j => $detail) {
                echo '<tr>';
                echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('LBDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('class' => 'span2', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td><i>' . $kelDetail . '</i></td>';
            foreach ($details as $j => $detail) {
                echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('LBDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('class' => 'span2', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                echo '<td>' . CHtml::textField('LBNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</tbody></table>';
}
?>


<table>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Dokter Penanggung Jawab', 'Dokter Penanggung Jawab', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::dropDownList('GZPasienMasukPenunjangT[pegawai_id', $modPasienMasukPenunjang->pegawai_id, CHtml::listData(DokterV::model()->findAll(), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'style' => 'width:160px;'));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::hiddenField('LBHasilPemeriksaanLabT[hasilpemeriksaanlab_id]', $modHasilpemeriksaanLab->hasilpemeriksaanlab_id, array('class' => 'span1', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo CHtml::label('Tgl. Pengambilan Hasil', 'Tanggal Pengambilan Hasil', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'LBHasilPemeriksaanLabT[tglpengambilanhasil]',
                        'mode' => 'datetime',
                        'value' => $modHasilpemeriksaanLab->tglpengambilanhasil,
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",

                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",

                        ),
                    )); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Catatan Laboratorium', 'Catatan Laboratorium', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textArea('LBHasilPemeriksaanLabT[catatanlabklinik]', $modHasilpemeriksaanLab->catatanlabklinik, array()); ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<table width="50%" id="tblFormHasilPemeriksaanRad" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Jenis/Detail Pemeriksaan</th>
            <th>Makroskopis</th>
            <th>Mikroskopis</th>
            <th>Saran</th>
            <th>Catatan</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <?php foreach ($modHasilPemeriksaanPA as $i => $hasil) : ?>
        <tr>
            <td>
                <?php echo GZPemeriksaanLabM::model()->findByPK($hasil->pemeriksaanlab_id)->pemeriksaanlab_nama; ?> : <br>
                <b>
                    <?php $idJenisPemeriksaan = GZPemeriksaanLabM::model()->findByPK($hasil->pemeriksaanlab_id)->jenispemeriksaanlab_id;
                    echo LBJenisPemeriksaanLabM::model()->findByPk($idJenisPemeriksaan)->jenispemeriksaanlab_nama; ?></b> <br>
                <?php echo CHtml::activeHiddenField($hasil, "[$i]hasilpemeriksaanpa_id", array('readonly' => true)); ?>
                <?php echo '<b>No. Sediaan : ' . $hasil->nosediaanpa . '</b><br>' . $hasil->tglperiksapa; ?>
            </td>
            <td><?php echo CHtml::activeTextArea($hasil, "[$i]makroskopis", array('class' => 'span2')); ?></td>
            <td><?php echo CHtml::activeTextArea($hasil, "[$i]mikroskopis", array('class' => 'span2')); ?></td>
            <td><?php echo CHtml::activeTextArea($hasil, "[$i]saranpa", array('class' => 'span2')); ?></td>
            <td><?php echo CHtml::activeTextArea($hasil, "[$i]catatanpa", array('class' => 'span2')); ?></td>
            <td><?php echo CHtml::button('Referensi', array('onclick' => 'return false;', 'class' => 'btn btn-info', 'disabled' => false)); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<div class='form-actions'>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)',
            'id' => 'btn_simpan',
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'onclick' => "printPemeriksaan(" . $modHasilpemeriksaanLab->pendaftaran_id . ",
                    " . $modHasilpemeriksaanLab->pasienmasukpenunjang_id . "," . $modHasilpemeriksaanLab->pasien_id . ");return false")
    ); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$urlPrintPemeriksaan = Yii::app()->createUrl('/print/PemeriksaanLab', array());
$jscript = <<< JS
function printPemeriksaan(pendaftaran_id,pasienmasukpenunjang_id,pasien_id)
{
            window.open('${urlPrintPemeriksaan}&pendaftaran_id='+pendaftaran_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id+'&pasien_id='+pasien_id,'printwin','left=100,top=100,width=800,height=590, scrollbars=1');
}

JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>