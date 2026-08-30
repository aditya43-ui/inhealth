<style>
    .border{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php  //echo $this->renderPartial('_headerPrint'); ?>
<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>10)); ?>
<table class='table'  style = "width:100%;box-shadow:none;margin: 0;padding: 0;">
    <tr>
        <td>
            <b><?php echo CHtml::encode($modKirim->getAttributeLabel('jenispesanmenu')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modKirim->jenispesanmenu); ?>
        </td>           
        <td>&nbsp;</td>
        <td><b>Petugas Pengirim</b></td>
        <td>: <?php echo $modKirim->pengirim->pegawai->namaLengkap; ?></td>
    </tr>
    <tr>
        <td>
         <b><?php echo CHtml::encode($modKirim->getAttributeLabel('nokirimmenu')); ?></b>                      
        </td>
        <td>
             : <?php echo CHtml::encode($modKirim->nokirimmenu); ?>
        </td>
    </tr>   
    <tr>
        <td>
         <b><?php echo CHtml::encode($modKirim->getAttributeLabel('tglkirimmenu')); ?></b>                  
        </td>
        <td>
             : <?php echo CHtml::encode($modKirim->tglkirimmenu); ?>           
        </td>
    </tr>   
</table>
<?php if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) { ?>
    <table id="tableObatAlkes" class="table"  style = "box-shadow:none;">
        <thead>
        <tr>
            <th class ="border" rowspan="2">No.Urut</th>
            <th class ="border" rowspan="2">Instalasi/<br>Ruangan</th>
            <!--<th class ="border" rowspan="2">Ruangan</th>-->
            <th class ="border" rowspan="2">No. Pendaftaran/<br>No. Rekam Medik</th>
            <!--<th class ="border" rowspan="2">No. Rekam Medik</th>-->
            <th class ="border" rowspan="2">Nama Pasien</th>
            <!--<th class ="border" rowspan="2">Umur</th>
            <th class ="border" rowspan="2">Jenis Kelamin</th>-->
            <th class ="border" colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><p style="margin: 0; text-align: center;">Menu Diet</p></th>
            <th class ="border" rowspan="2">Jumlah</th>
            <!--<th class ="border" rowspan="2">Satuan/URT</th>-->
        </tr>
    <tr>
        <?php
        foreach (JeniswaktuM::getJenisWaktu() as $row) {
            echo '<th class ="border">' . $row->jeniswaktu_nama . '</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
		 $criteria = new CDbCriteria();
		$criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id, kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
		$criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id,kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
		$criteria->compare('kirimmenudiet_id', $_GET['id']);
		$modDetailKirim = KirimmenupasienT::model()->findAll($criteria);
        foreach ($modDetailKirim AS $tampilData):
            echo "<tr>
            <td class ='border'>" . $no . "</td>
            <td class ='border'>" . $tampilData->ruangan->instalasi->instalasi_nama." / <br>".$tampilData->ruangan->ruangan_nama."</td>              
            <td class ='border'>" . $tampilData->pendaftaran->no_pendaftaran ."/<br>". $tampilData->pasien->no_rekam_medik ."</td>               
            <td class ='border'>" . $tampilData->pasien->nama_pasien . "</td>";   
            

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
					echo "<td class ='border'>".$li."</td>";
                } else {
                    echo "<td class ='border'></td>";
                }
            };

            echo "<td class ='border' style = 'text-align:right;'>" . $tampilData->jml_kirim ." ". $tampilData->satuanjml_urt."</td></tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>

<?php } else { 
    
    $header_nama = "Pegawai/Tamu";
    $pesan = PesanmenudietT::model()->findByPk($modKirim->pesanmenudiet_id);
    $is_pendamping = false;
    $nama_pasien_pendamping = null;
    
    if (!empty($pesan) && !empty($pesan->pendaftaran_id) && $modKirim->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
        $header_nama = "Pasien";
        $pasien = $pesan->pendaftaran->pasien;
        $is_pendamping = true;
        $nama_pasien_pendamping = $pasien->namadepan.$pasien->nama_pasien;
    }
    
    ?>
    <table id="tableObatAlkes" class="table"  style = "box-shadow:none;">
        <thead>
            <tr>
                <th  class ='border' rowspan="2">No.Urut</th>
                <th  class ='border' rowspan="2">Instalasi/<br>Ruangan</th>
                <!--<th rowspan="2" class ='border'>Ruangan</th>-->
                <th rowspan="2" class ='border'><?php echo $header_nama ?></th>
                <!--<th rowspan="2" class ='border'>Jenis Kelamin</th>-->
                <th  class ='border' colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><p style="margin: 0; text-align: center;">Menu Diet</p></th>
                <th rowspan="2" class ='border'>Jumlah</th>
                <!--<th rowspan="2" class ='border'>Satuan/URT</th>-->
            </tr>
            <tr>
                <?php
                foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    echo '<th  class ="border">' . $row->jeniswaktu_nama . '</th>';
                }
                ?>
            </tr>
        </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($modDetailKirim AS $tampilData):
            echo "<tr>
            <td class ='border'>" . $no . "</td>
            <td class ='border'>" . $tampilData->ruangan->instalasi->instalasi_nama ." / <br>".$tampilData->ruangan->ruangan_nama ."</td>";
            if (!empty($tampilData->pegawai->nama_pegawai)) {
                echo "<td class ='border'>" . ($is_pendamping ? $nama_pasien_pendamping : $tampilData->pegawai->nama_pegawai) . "</td>   ";           
            } else {
                echo "<td class ='border'>Tamu " . $no . "</td>   
            ";
            }
            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = KirimmenupegawaiT::model()->with('menudiet')->findByAttributes(array('pegawai_id' => $tampilData->pegawai_id, 'kirimmenudiet_id' => $tampilData->kirimmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id,'menudiet_id'=>$tampilData->menudiet_id));
                if (empty($detail->menudiet_id)) {
                    echo "<td class ='border'><p style='margin: 0; text-align: center;'>-</p></td>";
                } else {
                    echo "<td class ='border'>" . $detail->menudiet->menudiet_nama . "</td>";
                }
            };

            echo "<td class ='border' style='text-align:right;'>" . $tampilData->jml_kirim ." ".$tampilData->satuanjml_urt. "</td>";
            "</tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>
<?php } ?>

<?php

    
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        kirimmenudiet_id = '<?php echo !empty($modKirim->kirimmenudiet_id) ? $modKirim->kirimmenudiet_id : ''; ?>';
        window.open('<?php echo $this->createUrl('DetailKirimMenuDiet'); ?>&id='+kirimmenudiet_id+'&caraPrint='+caraPrint+'&frame=false','printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
    
    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" style="text-align:center;">
                        <?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br>
                        <div>Petugas Pengirim</div>
                       
                        <div style="margin-top:60px;"><?php echo isset($modKirim->pengirim->pegawai->namaLengkap) ? $modKirim->pengirim->pegawai->namaLengkap : "" ?></div>
                        <hr style = "padding: 0;margin: 0;border:1px solid #555;">
                        <div>
                            <?php echo isset($modKirim->pengirim->pegawai->nomorindukpegawai) ? 'NIP. '.$modKirim->pengirim->pegawai->nomorindukpegawai : "" ?>                            
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php

if (isset($_GET['frame'])){
    
    if ($_GET['frame'] === '1'){        
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    }
}
?>