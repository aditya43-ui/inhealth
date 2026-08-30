<fieldset style="width: 1200px; float:left;">
    <legend>Profil Klinik</legend>
    <?php
    $ruangan_id = Yii::app()->user->ruangan_id;
    $klinik = ProfilruanganV::model()->findAll("ruangan_id='1' ORDER BY ruangan_id");
    foreach ($klinik as $modelklinik)
    {
    ?>
        <table style="width: 800px; margin-top:10px; margin-bottom:10px;" class="table table-bordered">
              <tr>
                      <td width="30%"> 
                           <?php echo CHtml::label('Poliklinik :','poliklinik',array('style'=>'font-weight:bold;',)); ?>
                      </td>
                      <td width="40%" style="font-weight:bold;">
                            <?php echo $modelklinik->ruangan_nama; ?>                 
                       </td>
                       
                       <td width="30%" rowspan="2" colspan="2">
                           <img src="<?php echo Params::urlPegawaiTumbsDirectory().'kecil_'.$model->photopegawai ?> ">
                       </td>
              </tr>
              <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label('Nama Dokter :','nama dokter'); ?>
                      </td>
                      <td width="30%">
                            <?php
                            $ruangandokter = DokterV::model()->findAll("ruangan_id='$modelklinik->ruangan_id'");
                            $tr .= '<ul>';
                            foreach ($ruangandokter as $dokter)
                            {
                                $tr .= '<li style="text-decoration:underline;">';
                                $tr .= $dokter->gelardepan.$dokter->nama_pegawai.' '.$dokter->gelarbelakang_nama;
                                $tr .= '</li>';
                            }
                            $tr .= '</ul>';
                            echo $tr;
                            ?>
                      </td>
              </tr>
              <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label('Jam Buka :','jam buka'); ?>
                      </td>
                      <td width="30%">
                          <?php echo $modelklinik->jmabuka; ?>
                      </td>
                      <td>
                          <?php echo CHtml::label('Warna Map :','warna map'); ?>
                      </td>
                      <td>
                          <?php echo $modelklinik->Map_Warna; ?>
                      </td>
              </tr>
                <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label('User :','user'); ?>
                      </td>
                      <td width="30%" colspan="3">
                            <?php
                            $loginpemakai = RuanganpegawaiM::model()->findAll("ruangan_id='$modelklinik->ruangan_id'");
                            $tl .= '<ul>';
                            foreach ($loginpemakai as $user)
                            {
                                $tl .= '<li style="text-decoration:underline;">'.$user->loginpemakai->nama_pemakai.'</li>';
                            }
                            $tl .= '</ul>';
                            echo $tl;
                            ?>
                      </td>
                </tr>
                <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label('Jenis Kelas / Kelas Pelayanan :','jenis kelas'); ?>
                      </td>
                      <td width="30%" colspan="3">
                          <?php echo $modelklinik->jeniskelas_nama.' / ' .$modelklinik->kelaspelayanan_nama ?>
                      </td>
                </tr>
        </table>
               <?php } ?>
</fieldset>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>