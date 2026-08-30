<div class="row-fluid">
    <div class="col-md-6">
         <table width="100%">
     
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        </tr>
         <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->pasien->jeniskelamin; ?></td>
        </tr>
         <tr>
            <td>Umur</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->umur; ?></td>
        </tr>
          <tr>
            <td>Cara Pembayaran / Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?> / <?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        </tr>
          
   </table>
    </div>
    <div class="col-md-6">
        <table width="100%">
            <tr>
                <td>
                    Tanggal Pendaftaran
                </td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) ?></td>
            </tr>
            <tr>
                <td>No Pendaftaran</td>
                <td>:</td>
                <td>
                    <?php echo $modPendaftaran->no_pendaftaran;?>
                </td>
            </tr>
            <tr>
                <td>Kelas Pelayanan</td>
                <td>:</td>
                <td>
                    <?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;?>
                </td>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <td>
                    <?php echo $model->pegawai->namaLengkap;?>
                </td>
            </tr>
            
        </tr>
        </table>
    </div>
  
</div>
<?php
$result = array();
foreach ($modListKie as $l) {
    $result[$l['jeniskie']]['jeniskie'] = $l['jeniskie'];
    $result[$l['jeniskie']]['listkie_nama'] = $l['listkie_nama'];
    $result[$l['jeniskie']]['detail'][] = array(
        'jeniskie' => $l['jeniskie'],
        'listkie_id' => $l['listkie_id'],
        'listkie_nama' => $l['listkie_nama'],
        'ada' => 0,

    );
}
?>

<?php foreach($result as $k => $v){?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $k ?></div>
                </div>
                <div class="panel-body">
                    <?php 
                    $ceklist = false;
                    $i=0;

                    foreach($v['detail'] as $det) { ?>
                        <?php
                        $s=0;
                        foreach($modDetails as $k => $d){
                            if($d->listkie_id == $det['listkie_id']){
                                // $s=1;
                                // $det['ada']=1;

                                echo '<span class="fa fa-check-square-o"></span>';
                                echo "<span>".$det['listkie_nama']."</span></label><br/>";
                            }else{
                                // echo "<span>".$det['listkie_nama']."</span></label><br/>";

                                // $det['ada']=0;
                                // echo '<span class="fa fa-square-o"></span>';
                                // echo "<span>".$det['listkie_nama']."</span></label><br/>";

                                
                            }
                            // if($s==0){
                            //     echo "<span>".$det['listkie_nama']."</span></label><br/>";

                            // }
                            //  echo '<span class="fa fa'.($item['ceklis'] == 1 ? '-check' : '').'-square-o"></span>';
                            //     echo "<span>".$d->listkie->listkie_nama."</span></label><br/>";
                        }
                        
                        ?>

                        
                        <?php 
                            // echo '<label class="checkbox inline">'.CHtml::activeCheckBox($modKieDet,'['.$det['listkie_id'].']listkie_id', array('value'=>$det['listkie_id'],
                            // 'onclick' => "inputperiksa(this);"));
                            // echo CHtml::activeHiddenField($modKieDet,'['.$det['listkie_id'].']jeniskie',array('value'=>$det['jeniskie'],'readonly'=>true,'class'=>'span1'));

                            // echo $form->hiddenField($modKieDet,'[]listkie_id');
                            // echo $form->hiddenField($modKieDet,'[]jeniskie');
                        ?>
                    <?php  } $i++; ?>
                    <?php
                    //    echo "<pre>"; 
                       
                    //    print_r($v['detail']);exit;
                    ?>
                </div>
	        </div>
        </div>
    </div>
<?php } ?>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Farmasi</div>
            </div>
            <div class="panel-body">
            <?php //$modFarmasi = PenjualanresepT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); 
    
                // echo CJSON::encode($modFarmasi);
                // $myArray = array();
                // foreach ($modFarmasi as $key => $farmasi) {
                //     $myArray = $farmasi['kiepenyerahan'];
                // }
                // $myArray = json_decode($myArray);
                // echo count($myArray);

                // for ($i=0; $i < count($myArray) ; $i++) { 
                //     if($myArray[$i] != 'Pilih Semua'){
                //         // echo '<span class="fa fa-check-square-o"></span>';
                //         echo "<span>".$myArray[$i]."</span></label><br/>";
                //     }
                    
                // }
            
            ?>
            </div>
        </div>
    </div>
</div> -->
<?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; 

?>

<script type="text/javascript">
    function print(){
        window.open('<?php echo Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&pendaftaran_id='.$modPendaftaran->pendaftaran_id.'&kiepasien_id='.$model->kiepasien_id ) ?>', 'printwin', 'left=100,top=100,width=640,height=640')
    }
</script>