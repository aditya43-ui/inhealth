<div class="white-container">
    <?php
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
    $no_urut = 1;
    $class='';
    if(isset($_GET['frame']) ){
        $class="table table-striped";
    }
    ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('no_pendaftaran') ?></td><td>: <?php echo $modKunjungan->no_pendaftaran ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td><td>: <?php echo $modKunjungan->no_rekam_medik ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td><td>: <?php echo $modKunjungan->tgl_pendaftaran ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td><td>: <?php echo $modKunjungan->namadepan." ".$modKunjungan->nama_pasien ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td><td>: <?php echo $modKunjungan->no_masukpenunjang ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') ?></td><td>: <?php echo $modKunjungan->tanggal_lahir ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td><td>: <?php echo $modKunjungan->tglmasukpenunjang ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td><td>: <?php echo $modKunjungan->jeniskelamin ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('ruangan_nama') ?></td><td>: <?php echo $modKunjungan->ruangan_nama ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td><td>: <?php echo $modKunjungan->alamat_pasien ?></td>
        </tr>
        <tr>
            <td><?php echo $modHasilPemeriksaan->getAttributeLabel('nohasilperiksalab') ?></td><td>: <?php echo $modHasilPemeriksaan->nohasilperiksalab; ?></td>
        </tr>
        <tr>
            <td><?php echo $modHasilPemeriksaan->getAttributeLabel('tglhasilpemeriksaanlab') ?></td><td>: <?php echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab); ?></td>
        </tr>
    </table>
    <table width="100%" border="1" class='<?php echo $class; ?>'>
        <thead>
            <th>NO.</th>
            <th width="30%">DETAIL PEMERIKSAAN</th>
            <th>HASIL PEMERIKSAAN</th>
            <th>NILAI RUJUKAN</th>
            <th>SATUAN</th>
            <th>METODE</th>
			<th>KETERANGAN</th>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetailHasilPemeriksaans) > 0){
                foreach($modDetailHasilPemeriksaans AS $i => $modDetail){
                    $trpemeriksaan = false;
                    if($i == 0){
                        echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
                    }else if(($i) < count((array)$modDetailHasilPemeriksaans)){
                        if($modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id != $modDetailHasilPemeriksaans[$i-1]->pemeriksaanlab_id){
                            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
                            $no_urut--;
                        }
                    }
            ?>   
                <tr>
                    <td>
                        <?php echo $no_urut; ?>
                    </td>
                    <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
                    <td><?php echo $modDetail->hasilpemeriksaan; ?></td>
                    <!--Karena <sup> jadi tidak superscript >> <td><?php // echo htmlentities($modDetail->NilaiRujukan, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></td>-->
                    <td><?php echo $modDetail->NilaiRujukan; ?></td>
                    <td><?php echo $modDetail->HasilPemeriksaanSatuan; ?></td>
                    <td><?php echo $modDetail->HasilPemeriksaanMetode; ?></td>
					<td><?php echo $modDetail->hasil_laboratorium; ?></td>
                </tr>
            <?php 
                    $no_urut++;
                }
            }
            ?>
        </tbody>
    </table>
    <table style="width: 100%; border: none;">
        <tr>
            <td><br>
                <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :<br>
                <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:left;border-color: black;'>                
                <?php echo $modHasilPemeriksaan->catatanlabklinik; ?>
                </div>
                </div>
            </td>
        </tr>
        <tr>
            <td><br>
                <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :<br>
                <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:left;border-color: black;'>                
                <?php echo $modHasilPemeriksaan->kesimpulan; ?>
                </div>
                </div><br>
            </td>
        </tr>
    </table>

    <?php
    if(isset($_GET['frame']) && $_GET['frame'] == 1){    
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printHasil();'));     
    }else{
    ?> 
    <table style="width: 100%; border: none;">
        <tr>
            
            <td><?php echo Yii::app()->user->getState('kabupaten_nama') ?>, <?php echo date('d/m/Y') ?></td>
        </tr>
		<br>
        <tr>
            <td> <br>Dokter Penanggung Jawab,</td> <td>  </td>
            <td> <br>Analis Bank Darah,</td>
            
        </tr>
        <tr height="200px;">
            <td style="text-decoration: underline;"><?php echo "<br>".$modKunjungan->gelardepan." ".$modKunjungan->nama_pegawai." ".$modKunjungan->gelarbelakang_nama; ?></td> <td>  </td>
            <td style="text-decoration: underline;"><?php echo Yii::app()->user->getState("nama_pegawai"); ?></td>
           
        </tr> 
    </table>
    <?php } ?>
</div>
<script>
/**
 * print hasil pemeriksaan 
 */
function printHasil()
{
    var pasienmasukpenunjang_id = <?php echo $_GET['pasienmasukpenunjang_id']; ?>;
    if(pasienmasukpenunjang_id != ""){
        <?php if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){ ?>
                    window.open('<?php echo $this->createUrl('/bankDarah/pencatatanHasilPemeriksaan/print'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=768,height=640');
        <?php }else if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){ ?>
                    window.open('<?php echo $this->createUrl('/bankDarah/pencatatanHasilPemeriksaan/printPA'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=0,width=1024,height=640');
        <?php } ?>
    }else{
        myAlert("Silakan pilih data kunjungan pasien!");
    }
}    
</script>

