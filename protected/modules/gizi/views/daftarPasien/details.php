<table style="width:100%;position:absolute;margin-top:0;">
    <tr>
        <td>
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultSurat'); ?>
        </td>
    </tr>
</table>
<div style="height:3cm;">
    &nbsp;
</div>
<table style="width:100%;">
    <tr>
        <td>

        </td>
    </tr>
    <tr>
        <td>
            <p style="margin: 0; text-align: center;">
            <h3>HASIL PEMERIKSAAN LABORATORIUM</h3>
            </p><br>
        </td>
    </tr>
    <tr>
        <td align="right">
            <table style="width:300px;margin-right:1cm;border:1px solid #DDDDDD;border-radius:10px !important;">
                <tr>
                    <td>Yth</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No. Lab</td>
                    <td>:</td>
                    <td><?php echo $masukpenunjang->no_masukpenunjang; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?php echo date('d M Y'); ?></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><?php echo $modHasilPeriksa->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Umur / Jenis Kelamin</td>
                    <td>:</td>
                    <td><?php echo $modHasilPeriksa->jeniskelamin; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $modHasilPeriksa->alamat_pasien ?></td>
                </tr>
                <tr>
                    <td>Dokter Perujuk</td>
                    <td>:</td>
                    <td><?php echo $pemeriksa->nama_pegawai; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table id="tableObatAlkes" class="table table-bordered table-condensed">
    <thead style="background-color:#DCEDFA">
        <tr>
            <th>No.</th>
            <th colspan="2">Pemeriksaan</th>
            <th>Hasil</th>
            <th>Nilai Rujukan</th>
            <th>Satuan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hasil as $jenisperiksa => $kelompok) : ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2"><b><?php echo strtoupper($jenisperiksa); ?></b></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php foreach ($kelompok as $kelompokDet => $details) : ?>
                <?php $colspan = count((array)$details);
                $j = 0; ?>
                <?php foreach ($details as $i => $detail) : ?>
                    <tr>
                        <td><?php echo $i + 1;
                            $j++; ?></td>
                        <?php if ($j == 1) echo "<td rowspan='$colspan'>$kelompokDet</td>"; ?>
                        <td><?php echo $detail['namapemeriksaan']; //$detail->pemeriksaanlab->pemeriksaanlab_nama; 
                            ?></td>
                        <td><?php echo $detail['hasil']; ?></td>
                        <td><?php echo $detail['nilairujukan']; ?></td>
                        <td><?php echo $detail['satuan']; ?></td>
                        <td><?php echo $detail['keterangan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:50%;">
            <table style="width:100%;">
                <tr>
                    <td style="height:2cm" valign="top">
                        Catatan Lab : <?php echo $modHasilPeriksa->catatanlabklinik; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php // echo $data->kabupaten->kabupaten_nama.', '.Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d'), 'yyyy-MM-dd'),'long',null); 
                        ?>
                        <?php echo date('Y/m/d H:i:s'); ?>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width:50%;" align="center">
            Pemeriksa
            <?php echo '<br><br><br><br><br>' . Yii::app()->user->getState('nama_pegawai'); ?>
            <?php //echo '<br><br><br><br><br>'.PendaftaranT::model()->findByPK($modHasilPeriksa->pendaftaran_id)->pegawai->nama_pegawai; 
            ?>
        </td>
    </tr>
</table>

<?php
if (!isset($caraPrint)) {
    $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print', array('pasienmasukpenunjang_id' => $masukpenunjang->pasienmasukpenunjang_id));
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
}
?>