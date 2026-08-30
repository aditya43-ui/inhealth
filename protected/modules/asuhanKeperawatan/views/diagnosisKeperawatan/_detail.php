<?php
/**
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * digunakan untuk menampilkan detail rincian
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<table class="table noborder paddingtext2">
    <tr>
        <td style="text-align:center;" align="center"><b>PENGKAJIAN </b></td>
    </tr>
</table>

<table class="table noborder paddingtext2">
    <tr>
        <th><p>No. Pengkajian</p></th>
        <td ><p> : <?php echo isset($modPengkajian->no_pengkajian) ? $modPengkajian->no_pengkajian : "-"; ?></p></td>				
        <td>&nbsp;</td>
        <th ><p>Nama Perawat</p></th>
        <td ><p> : <?php echo isset($modPengkajian->nama_pegawai) ? $modPengkajian->nama_pegawai : "-"; ?></p></td>
    </tr>
    <tr>
        <th><p>Tanggal Pengkajian</p></th>
        <td ><p> : <?php echo isset($modPengkajian->pengkajianaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modPengkajian->pengkajianaskep_tgl) : "-"; ?></p></td>
    </tr>
</table>

<?php
//$this->renderPartial('_tabMenu', array(
//    'modPengkajian' => $modPengkajian,
//    'modAwalMedis' => $modAwalMedis,
//    ));
?>
<?php $this->renderPartial('_jsFunctions2', array('modPengkajian' => $modPengkajian)); ?>
<div>
    <!--<iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>-->
</div>