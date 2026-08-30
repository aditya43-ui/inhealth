<div class="white-container">
    <legend class="rim2">Profil <b>Klinik</b></legend>
    <?php
    $ruangan_id = Yii::app()->user->ruangan_id;
    $klinik = ProfilruanganV::model()->findAll("ruangan_id='$ruangan_id' ORDER BY ruangan_id");
    $tr = '';
    $tl = '';
	if (count($klinik) > 0 ){
    foreach ($klinik as $modelklinik)
    {
    ?>
        <table style="width:100%;" class="table table-striped table-condensed">
              <tr>
                      <td width="30%"> 
                           <?php echo CHtml::label('Poliklinik :','poliklinik',array('style'=>'font-weight:bold;',)); ?>
                      </td>
                      <td width="40%" style="font-weight:bold;">
                            <?php echo $modelklinik->ruangan_nama; ?>                 
                       </td>
                       
                       <td width="30%" rowspan="2" colspan="2">
                           <img src="<?php echo Params::urlRuanganTumbsDirectory().'kecil_'.$modelklinik->ruangan_image ?> ">
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
                                $tr .= '<li>';
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
						<?php echo (isset($modelklinik->Map_Warna) ? $modelklinik->Map_Warna : ""); ?>
					</td>
              </tr>
                <tr>
                       <td width="20%"> 
                           <?php echo CHtml::label('User :','user'); ?>
                      </td>
                      <td width="30%" colspan="3">
                            <?php
                            $users = RuanganpegawaiM::model()->findAll("ruangan_id='$ruangan_id' ORDER BY pegawai_id");
                            $tl .= '<ul>';
                            foreach ($users as $user)
                            {
                                $loginpemakai = LoginpemakaiK::model()->findAllByAttributes(array('pegawai_id'=>$user->pegawai_id));
                                foreach($loginpemakai as $i=>$pemakai)
                                    $tl .= '<li>'.$pemakai->nama_pemakai.'</li>';
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
    <?php } 
	}else { 
	echo "Data Tidak Ditemukan";
	} ?>
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>