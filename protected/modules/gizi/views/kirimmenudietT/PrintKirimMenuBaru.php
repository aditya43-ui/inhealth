<style>
    .table {
        box-shadow: none;
        border: 1px solid black;
    }
    .table th, .table td {
        border: 1px solid black;
    }
</style>

<?php   
if($caraPrint=='EXCEL')
{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
	header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulLaporan));
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> '', 'colspan'=>10)); 

?>

<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modKirim->getAttributeLabel('jenispesanmenu')); ?>:</b>
            <?php echo CHtml::encode($modKirim->jenispesanmenu); ?>
            <br>
            <b><?php echo CHtml::encode($modKirim->getAttributeLabel('nokirimmenu')); ?>:</b>
            <?php echo CHtml::encode($modKirim->nokirimmenu); ?>
            <br>
            <b><?php echo CHtml::encode($modKirim->getAttributeLabel('tglkirimmenu')); ?>:</b>
            <?php echo CHtml::encode($modKirim->tglkirimmenu); ?>
            <br>

        </td>
        <td hidden>
<!--<b><?php //echo CHtml::encode($modKirim->getAttributeLabel('ruangan_id')); ?>:</b>
            <?php //echo CHtml::encode($modKirim->ruangan->ruangan_nama); ?>
            <br>-->
            <!--<b><?php // echo CHtml::encode($modKirim->getAttributeLabel('create_time')); ?>:</b>-->
            <?php // echo CHtml::encode($modKirim->create_time); ?>
            <!--<br>-->
        </td>
    </tr>   
</table>
<style>
    .table thead tr th{
        vertical-align:middle;
    }
</style>
<?php if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) { ?>
    <table id="tableObatAlkes" class="table">
        <thead>
        <tr>
            <th rowspan="2">No.Urut</th>
            <th rowspan="2">Instalasi</th>
            <th rowspan="2">Ruangan</th>
            <th rowspan="2">No. Pendaftaran</th>
            <th rowspan="2">No. Rekam Medik</th>
            <th rowspan="2">Nama Pasien</th>
            <th rowspan="2">Umur</th>
            <th rowspan="2">Jenis Kelamin</th>
            <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><p style="margin: 0; text-align: center;">Menu Diet</p></th>
            <th rowspan="2">Jumlah</th>
            <th rowspan="2">Satuan/URT</th>
        </tr>
    <tr>
        <?php
        foreach (JeniswaktuM::getJenisWaktu() as $row) {
            echo '<th>' . $row->jeniswaktu_nama . '</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($modDetailKirim AS $tampilData):
            echo "<tr>
            <td>" . $no . "</td>
            <td>" . $tampilData->ruangan->instalasi->instalasi_nama . "</td>  
            <td>" . $tampilData->ruangan->ruangan_nama . "</td>
            <td>" . $tampilData->pendaftaran->no_pendaftaran . "</td>   
            <td>" . $tampilData->pasien->no_rekam_medik . "</td>   
            <td>" . $tampilData->pasien->nama_pasien . "</td>   
            <td>" . $tampilData->pendaftaran->umur . "</td>   
            <td>" . $tampilData->pasien->jeniskelamin . "</td>";

            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = KirimmenupasienT::model()->with('menudiet')->findAllByAttributes(array('pendaftaran_id' => $tampilData->pendaftaran_id, 'pasienadmisi_id' => $tampilData->pasienadmisi_id, 'kirimmenudiet_id' => $tampilData->kirimmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id,'jml_kirim'=>$tampilData->jml_kirim,'satuanjml_urt'=>$tampilData->satuanjml_urt));
				
                if (count((array)$detail)>0) {
					$li = '';
					if (count((array)$detail)>1){
						$li .= "<ul>";
					}
					foreach($detail as $det){
						if (count((array)$detail)>1){
							$li .= "<li>".$det->menudiet->menudiet_nama."</li>";
						}else{
							$li .= $det->menudiet->menudiet_nama;
						}
					}
					if (count((array)$detail)>1){
						$li .= "</ul>";
					}
					echo "<td>".$li."</td>";
                } else {
                    echo "<td></td>";
                }
            };

            echo "<td style='text-align: right !important'>" . $tampilData->jml_kirim . "</td>
            <td>" . $tampilData->satuanjml_urt . "</td>";
            "
          </tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>

<?php } else { ?>
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th rowspan="2">No.Urut</th>
                <th rowspan="2">Instalasi</th>
                <th rowspan="2">Ruangan</th>
                <th rowspan="2">Nama Pegawai/Tamu</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><p style="margin: 0; text-align: center;">Menu Diet</p></th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Satuan/URT</th>
            </tr>
            <tr>
                <?php
                foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    echo '<th>' . $row->jeniswaktu_nama . '</th>';
                }
                ?>
            </tr>
        </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($modDetailKirim AS $tampilData):
            echo "<tr>
            <td>" . $no . "</td>
            <td>" . $tampilData->ruangan->instalasi->instalasi_nama . "</td>  
            <td>" . $tampilData->ruangan->ruangan_nama . "</td>";
            if (!empty($tampilData->pegawai->nama_pegawai)) {
                echo "<td>" . $tampilData->pegawai->nama_pegawai . "</td>   
            <td>" . $tampilData->pegawai->jeniskelamin . "</td>";
            } else {
                echo "<td>Tamu " . $no . "</td>   
            <td><p style='margin: 0; text-align: center;'>-</p></td>";
            }
            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = KirimmenupegawaiT::model()->with('menudiet')->findByAttributes(array('pegawai_id' => $tampilData->pegawai_id, 'kirimmenudiet_id' => $tampilData->kirimmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id,'menudiet_id'=>$tampilData->menudiet_id));
                if (empty($detail->menudiet_id)) {
                    echo "<td><p style='margin: 0; text-align: center;'>-</p></td>";
                } else {
                    echo "<td>" . $detail->menudiet->menudiet_nama . "</td>";
                }
            };

            echo "<td>" . $tampilData->jml_kirim . "</td>
            <td>" . $tampilData->satuanjml_urt . "</td>";
            "
          </tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>
<?php } ?>
<table width='100%'>
	<tr>
		<td width="50%"></td>
		<td align="center" width="50%"><?php echo Yii::app()->user->getState('kecamatan_nama').", ".$format->formatDateTimeId(date('Y-m-d H:i:s')); ?></td>
	</tr>
	<tr>
		<td align="center" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="center" width="50%">Petugas</td>
	</tr>
	<tr height='100px'>
		<td align="center" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="center" width="50%"><?php echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
	</tr>
</table>