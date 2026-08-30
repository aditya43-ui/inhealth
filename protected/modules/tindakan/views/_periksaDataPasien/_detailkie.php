<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>

<table width="100%" >
      <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien;?></td>
        <td></td>
          <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->no_pendaftaran;?></td>
    </tr>
    <tr>
        <td> No. RM</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    
</table>

<br>
<div class="dokter">
    <?php
    $modKies = KiepasienT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
        foreach ($modKies as $kie) {

            //echo "<span style='text-align:center;'><b>KIE </b></span>";
            $kieDet = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kie->kiepasien_id));
            // $modDetails = KiepasiendetT::model()->findAllByAttributes(array('kiepasien_id' => $kiepasien_id));
            $modListKie = ListkieM::model()->findAll("jeniskie = 'Dokter'");
            // foreach ($kieDet as $kd) {
            //     $arr = [];

            //     echo $kd['jeniskie'] . "<br>";
            // }
            $result = array();
            foreach ($modListKie as $l) {
                $result[$l['jeniskie']]['jeniskie'] = $l['jeniskie'];
                $result[$l['jeniskie']]['listkie_nama'] = $l['listkie_nama'];
                $result[$l['jeniskie']]['detail'][] = array(
                    'jeniskie' => $l['jeniskie'],
                    'listkie_id' => $l['listkie_id'],
                    'listkie_nama' => $l['listkie_nama'],
                    // 'ada' => 0,

                );
            }
            foreach($result as $k => $v){
                echo "<b>KIE </b><b>".$k."&nbsp </b><br>";

                    foreach($v['detail'] as $det) { 
                        foreach($kieDet as $k => $d){ 
                        echo "<ul>";
                                // "<li>".$det['listkie_nama']."</li>".
                                if($d->listkie_id == $det['listkie_id']){
                                    echo "<li>".$det['listkie_nama']."</li>";
                                }
                        echo    "</ul>";
                        }
                    }
            }
            echo "<br>Dibuat Oleh :". $kie['pegawai']->namaLengkap ."<br><br>";
        }
    ?>
    <?php
        if(!empty($modKie->kiepasien_id)){ ?>
            <div class="printDokter">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printDokter(\'PRINT\')'))."&nbsp"; ?>
            </div>
    <?php
        }else{
    ?>
        <div class="printDokter">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'Alert()'))."&nbsp"; ?>
        </div>
    <?php
        }
    ?>
    
</div>
<hr>

<div class="farmasi">
<table width="100%" >
      <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien;?></td>
        
        <td>Pemberi Informasi</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pegawai->getNamaLengkap(); ?></td>
    </tr>
    <tr>
        <td> No Resep</td>
        <td>:</td>
        <td><?php echo !empty($modPendaftaran->penjualanresep_id) ? $modPendaftaran->penjualanresep->noresep : ''; ?></td>
        <td>Penerima Informasi</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
    </tr>
    
</table>
<br>

<div class="kiepenyerahan">
    <b>KIE Penyerahan Obat Farmasi</b>
    
</div>
<br>
<?php
    $modFarmasi = PenjualanresepT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    
        
            if(!empty($modFarmasi)){
                $myArray = array();
                foreach ($modFarmasi as $key => $farmasi) {
                    $myArray = $farmasi['kiepenyerahan'];
                }

                $myArray = json_decode($myArray);
            // echo count($myArray);
                if(count($myArray) > 0){
                    for ($i=0; $i < count($myArray) ; $i++) { 
                        if($myArray[$i] != 'Pilih Semua'){
                            // echo '<span class="fa fa-check-square-o"></span>';
                            echo "<ul>
                                <li><span>".$myArray[$i]."</span></label><br/></li></ul>";
                        }
                            
                    }
                }
                    
            }
        
    ?>
    <div class="printFarmasi">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printFarmasi(\'PRINT\')'))."&nbsp"; ?>
    </div>
</div>


<div class="print">
    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; ?>
</div>

<?php 
        $kiepasien_id = null;
        if(!empty($modKie) ){
            $kiepasien_id = $modKie->kiepasien_id;
        } 
        // $kiepasien_id = $modKie->kiepasien_id;
        $id = $modPendaftaran->pendaftaran_id;
                             
        $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printDetailKieDokter&pendaftaran_id='.$id.'&kiepasien_id='.$kiepasien_id );
        // echo CJSON::encode($urlPrint);
        $farmasi = PenjualanresepT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
        // echo CJSON::encode($modKie);die;
        
	?>			

<script>
    function printDokter(){
        window.open('<?php echo Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printDetailKieDokter&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&kiepasien_id='.$kiepasien_id ) ?>', 'printwin', 'left=100,top=100,width=640,height=640')
    }

    function printFarmasi(){
        window.open('<?php echo Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printDetailKieFarmasi&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&kiepasien_id='.$kiepasien_id ) ?>', 'printwin', 'left=100,top=100,width=640,height=640')
    }

    function Alert(){
        alert('Data masih Kosong !')
    }

    
</script>
