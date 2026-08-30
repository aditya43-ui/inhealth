<style>
    
    .headers th, .headers td, .headers h4, .headers blockquote {
        color: black !important;
    }
    
    .headers blockquote {
        border-left: 0px;
    }
    
    .nama_profil {
        font-size: 20pt;
        font-weight: bold;
    }
</style>


<?php 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();
?>
<table width="<?php echo ((isset($width)) ? $width : "100%")?>" class="headers">       
	<TR>
		<TD ALIGN=CENTER VALIGN=MIDDLE class="logo_profil" width="20%">
			 <!-- <img src="<?php Params::urlProfilRSDirectory().$data->logo_rumahsakit ?>" style="float:left; max-width: 100px; width:100px;" class='image_report'/> -->
		</TD>
	</TR>
	<TR>
		
        <TD align="center">
            <div align="center" class="profil-rs">
                <span class="nama_profil"><?php echo $data->nama_rumahsakit ?></span>
                <br>
                INSTALASI DIALISIS : <?= $model->ruanganrl->ruangan_nama ?>
                <br>
                <?= $data->alamatlokasi_rumahsakit ?>
                <br>
                Kecamatan Klojen, Kota Malang, Jawa Timur 65112
                <br>
                <b>(0341) 362101 2075 (RUANG HD) / 2074 (Admin)</b>
		    </div>
           
        </TD>
    </TR>
    <TR>
        <TD HEIGHT=2 >&nbsp;</TD>
    </TR>
    <TR>
        <TD align="center">
            <font color="black"><h4><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h4></font>
        </TD>
    </TR>   
	
</table>