<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%">
    <tr>
        <td  align="center">
		<?php
						if (file_exists(Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit)) {
							$gambar = Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit;
						?>
						
						<?php }else{
							$gambar = Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit;
						?>
						
						<?php
						}                                                
						?> 
            <img src="<?php echo $gambar ?> " style="max-width: 70px; width:70px;"/>
        </td>
        <td>
          <br/>
                <b>Instalasi Farmasi</b><br>
                <b><?php echo $modProfilRs->nama_rumahsakit; ?></b><br> 
				
                <span style='font-size:8px'><?php echo $modProfilRs->alamatlokasi_rumahsakit ?><br>
					Tlp. <?php echo $modProfilRs->no_telp_profilrs; ?><br>
			    
                </span>
        </td>
    </tr> 
</table> 


