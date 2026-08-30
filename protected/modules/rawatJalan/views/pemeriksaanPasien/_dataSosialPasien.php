<?php
$this->widget('bootstrap.widgets.BootAlert');
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
$kunjungan = InfokunjunganrjV::model()->findByAttributes(array(
    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
));

$modPendaftaran->dokter_pemeriksa = $modPendaftaran->dokter->namaLengkap;
$modPendaftaran->pegawai_id = $modPendaftaran->pegawai->pegawai_nama;
$modPendaftaran->nama_pj = $modPendaftaran->penanggungJawab->nama_pj ?? "";
$modPendaftaran->alamat_pj = $modPendaftaran->penanggungJawab->alamat_pj ?? "";
$modPendaftaran->hubungankeluarga = $modPendaftaran->penanggungJawab->hubungankeluarga ?? "";
$modPendaftaran->no_mobile_pasien = $modPendaftaran->pasien->no_mobile_pasien ?? "";
$modPendaftaran->antrian_nama = $modPendaftaran->antrianTs->antrian_nama ?? "";
$modPetugas = Yii::app()->user->getState('nama_pegawai');

$modPendaftaran->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama; 
$modPendaftaran->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama; 
$modPendaftaran->propinsi_nama = $modPendaftaran->pasien->propinsi->propinsi_nama; 
$modPendaftaran->kabupaten_nama = $modPendaftaran->pasien->kabupaten->kabupaten_nama; 
$modPendaftaran->kecamatan_nama = $modPendaftaran->pasien->kecamatan->kecamatan_nama; 


$jns_kunjungan = $modPendaftaran->kunjungan;

if (!empty($kunjungan)) {
    $modPendaftaran->dokter_pemeriksa =  $kunjungan->gelardepan.$kunjungan->nama_pegawai.(empty($kunjungan->gelarbelakang_nama) ? "" : (", ".$kunjungan->gelarbelakang_nama));
}

echo CHtml::hiddenField('kunjungan', $jns_kunjungan, array('readonly' => true));
echo CHtml::hiddenField('judul_sblm', '', array('readonly' => true));


?>

<?php
if (!empty($modPasien)) {
?>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td class="col-sm-1"><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
                    <br>
                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_nama', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'ruangan_id', array('readonly' => true, 'class'=>'idrm')); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'ruangan_nama', array('readonly' => true, 'class'=>'idrm')); ?></td>
              
                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                   <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>

          
                </div>
                </tr>
                <tr>
                    <td class="col-sm-1"><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly' => true)); ?></td>
                    
                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'pegawai_id', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPegawai, 'pegawai_id', array('readonly' => true, 'class'=>'idrm')); ?>
                    <?php echo CHtml::activeTextField($modPegawai, 'nama_pegawai', array('readonly' => true, 'class'=>'idrm')); ?></td>
               
                    <td class="col-sm-10"><?php echo CHtml::activeLabel($modPendaftaran, 'antrian_id', array('class' => 'control-label')); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'antrian_id', array('readonly' => true, 'class'=>'idrm')); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'antrian_nama', array('readonly' => true)); ?></td>


                </tr>      
                <br>  
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?>
                </td> 

                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'carabayar_nama', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true, 'class'=>'idrm')); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'carabayar_nama', array('readonly' => true, 'class'=>'idrm')); ?></td>

                    <td class="col-sm-10"><?php echo CHtml::activeLabel($modPendaftaran, 'Petugas Pendaftaran', array('class' => 'control-label')); ?>
                       <?php echo CHtml::activeTextField($modPendaftaran,'nama_pegawai', array('value'=>$modPetugas,'readonly' => true)); ?></td>

               </tr>
                  <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
        
                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
        
                 </tr>
                 <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPasien, 'alamat_pasien', array('readonly' => true)); ?></td>

                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'statuspasien', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeTextField($modPendaftaran, 'statuspasien', array('readonly' => true, 'class'=>'idrm')); ?></td>
                 </tr>
                 <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'propinsi_nama', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPasien, 'propinsi_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeTextField($modPasien, 'propinsi_nama', array('readonly' => true)); ?>
                    </td>
                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'Nama Penanggung Jawab', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'penanggungjawab_id', array('readonly' => true, 'class'=>'idrm')); ?>
                    <?php  echo CHtml::activeTextField($modPendaftaran, 'nama_pj', array('readonly' => true, 'class'=>'idrm')); ?></td>
                
                 
                 </tr>

                 <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'kabupaten_nama', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'kabupaten_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'kabupaten_nama', array('readonly' => true)); ?>
                    </td>

                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'Alamat Penanggung Jawab', array('class' => 'control-label')); ?>
                    <?php  echo CHtml::activeTextField($modPendaftaran, 'alamat_pj', array('readonly' => true, 'class'=>'idrm')); ?></td>
                
                </tr>
                    
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'kecamatan_nama', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'kecamatan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'kecamatan_nama', array('readonly' => true)); ?>
                    </td>

                    <td class="col-sm-4"><?php echo CHtml::activeLabel($modPendaftaran, 'Hubungan Keluarga', array('class' => 'control-label')); ?>
                    <?php  echo CHtml::activeTextField($modPendaftaran, 'hubungankeluarga', array('readonly' => true, 'class'=>'idrm')); ?></td>

              </tr>   
              <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'kelurahan_nama', array('class' => 'control-label')); ?>
                     <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelurahan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'kelurahan_nama', array('readonly' => true)); ?>
                    </td>

                    <td class="col-sm-4"><?php  echo CHtml::activeLabel($modPendaftaran, 'No Mobile Pasien', array('class' => 'control-label')); ?>
                    <?php  echo CHtml::activeTextField($modPendaftaran, 'no_mobile_pasien', array('readonly' => true, 'class'=>'idrm')); ?></td>
             
             </tr>  
                    
                </tr>
             

            </table>
        </div>
    </div>



<?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

?>

