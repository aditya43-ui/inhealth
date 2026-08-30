<?php
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array());
echo '<hr/>';
?>

<table class='prinout w100'>
    <tr>
        <td width="25%">No. Pendaftaran</td>
        <td width="1%">:</td>
        <td><?php echo $masukpenunjang->no_pendaftaran; ?></td>
        <td width='5%'></td>
        <td width="18%">No. DMK</td>
        <td width="1%">:</td>
        <td ><?php echo $masukpenunjang->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Tanggal Pendaftaran</td>
        <td>:</td>
        <td><?php echo substr($masukpenunjang->tgl_pendaftaran,0,-9); ?></td>
        <td></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->ruangan_nama; ?></td>
        <td></td>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td>No. Hasil Pemeriksaan</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        <td></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td>Tanggal Pemeriksaan</td>
        <td>:</td>
        <td><?php echo substr($masukpenunjang->tglmasukpenunjang,0,-9); ?></td>
        <td></td>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $masukpenunjang->carabayar_nama; ?> / <?php echo $masukpenunjang->penjamin_nama; ?></td>
    </tr>
</table>

<table class='w100 prinout grid'>
    <thead>
        <tr>
            <th>
                No.
            </th>
            <th>
                Nama Pemeriksaan
            </th>
            <th>
                Hasil Pemeriksaan
            </th>
            <th>
                Keterangan
            </th>
            <th>
                Evaluasi
            </th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <?php 
                if(count((array)$detailHasil) > 0){              
                    foreach($detailHasil as $i=>$hasil){     
                ?> 
                    <tr>
                        <td width="5%" style="vertical-align:top;">&nbsp;<?php echo ($i+1); ?>. </td>
                        <td><?php echo $hasil->tindakanrm->tindakanrm_nama;?></td>
                        <td><p style="margin: 0; text-align: center;"><?php echo $hasil->hasilpemeriksaanrm; ?></p></td>
                        <td><p style="margin: 0; text-align: center;"><?php echo $hasil->keteranganhasilrm; ?></p></td>
                        <td><p style="margin: 0; text-align: center;"><?php echo $hasil->evaluasi; ?></p></td>
                    </tr>
                <?php }} ?>
            </tr>
    </tbody>
</table>

<?php /*
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printHasil(\'PRINT\')')); 
echo " ";
// echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-remove icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
$urlPrint=  $this->createUrl($this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
function printHasil(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=1024px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD); 
 * 
 */        
?>

    