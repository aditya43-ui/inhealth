<style>
    .table thead tr th{
        vertical-align:middle;
    }
	
	.table {
		box-shadow:none;
		border-collapse: collapse;
		border: 1px solid black;
	}
	
	.table th, .table td {
		border: 1px solid black;
	}
	
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>10)); ?>
<table style="width: 100%; border: none;">
	<tr>
		<td nowrap><?php echo CHtml::encode($modPesan->getAttributeLabel('jenispesanmenu')); ?></td>
		<td>:</td>
		<td width="100%"><?php echo CHtml::encode($modPesan->jenispesanmenu); ?></td>
		<td><?php echo CHtml::encode($modPesan->getAttributeLabel('ruangan_id')); ?></td>
		<td>:</td>
		<td><?php echo CHtml::encode($modPesan->ruangan->ruangan_nama); ?></td>
	</tr>
	<tr>
		<td><?php echo CHtml::encode($modPesan->getAttributeLabel('nopesanmenu')); ?></td>
		<td>:</td>
		<td nowrap><?php echo CHtml::encode($modPesan->nopesanmenu); ?></td>
		<td nowrap><?php echo CHtml::encode($modPesan->getAttributeLabel('tglpesanmenu')); ?></td>
		<td>:</td>
		<td nowrap><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPesan->tglpesanmenu)); ?></td>
	</tr> 
</table>

<?php if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) { ?>
    <table id="tableObatAlkes" class="table table-condensed">
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
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><p style='margin: 0; text-align: center;'>Menu Diet</p></th>
    <th rowspan="2">Jumlah</th>
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
        foreach ($modDetailPesan AS $tampilData):
            echo "<tr>
            <td>" . $no . "</td>
            <td>" . $modPesan->ruangan->instalasi->instalasi_nama . "</td>  
            <td>" . $modPesan->ruangan->ruangan_nama . "</td>
            <td>" . $tampilData->pendaftaran->no_pendaftaran . "</td>   
            <td>" . $tampilData->pasien->no_rekam_medik . "</td>   
            <td>" . $tampilData->pasien->namadepan.$tampilData->pasien->nama_pasien . "</td>   
            <td>" . $tampilData->pendaftaran->umur . "</td>   
            <td>" . $tampilData->pasien->jeniskelamin . "</td>";

            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = PesanmenudetailT::model()->with('menudiet')->findByAttributes(array('pendaftaran_id' => $tampilData->pendaftaran_id, 'pasienadmisi_id' => $tampilData->pasienadmisi_id, 'pesanmenudiet_id' => $tampilData->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id, 'menudiet_id'=>$tampilData->menudiet_id));
                if (empty($detail->menudiet_id)) {
                    echo "<td><p style='margin: 0; text-align: center;'>-</p></td>";
                } else {
                    echo "<td>" . $detail->menudiet->menudiet_nama . "</td>";
                }
            };

            echo "<td style='text-align: right !important;' nowrap>" . $tampilData->jml_pesan_porsi." ".$tampilData->satuanjml_urt . "</td>
            ".
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
                <th rowspan="2">Nama Pendamping</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><p style='margin: 0; text-align: center;'>Menu Diet</p></th>
                <th rowspan="2">Jumlah</th>
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
        foreach ($modDetailPesan AS $tampilData):
            echo "<tr>
            <td>" . $no . "</td>
            <td>" . $modPesan->ruangan->instalasi->instalasi_nama . "</td>  
            <td>" . $modPesan->ruangan->ruangan_nama . "</td>";
            if (!empty($tampilData->pegawai->nama_pegawai)) {
                echo "<td>" . $tampilData->pegawai->nama_pegawai . "</td>   
            <td>" . $tampilData->pegawai->jeniskelamin . "</td>";
            } else {
                echo "<td>Tamu " . $no . "</td>   
            <td><p style='margin: 0; text-align: center;'>-</p></td>";
            }
            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = PesanmenupegawaiT::model()->with('menudiet')->findByAttributes(array('pegawai_id' => $tampilData->pegawai_id, 'pesanmenudiet_id' => $tampilData->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id, 'menudiet_id'=>$tampilData->menudiet_id));
                if (empty($detail->menudiet_id)) {
                    echo "<td><p style='margin: 0; text-align: center;'>-</p></td>";
                } else {
                    echo "<td>" . $detail->menudiet->menudiet_nama . "</td>";
                }
            };

            echo "<td nowrap>" . $tampilData->jml_pesan_porsi ." ".$tampilData->satuanjml_urt. "</td>
          </tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>
<?php } ?>

<?php
if (!isset($_GET['caraprint'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    // echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraprint){
        var pesanmenudiet_id = '<?php echo $modPesan->pesanmenudiet_id; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id='+pesanmenudiet_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div hidden>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php //echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kecamatan_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pemesan</div>
                        <div style="margin-top:60px;"><?php echo $modPesan->nama_pemesan; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php  } ?>