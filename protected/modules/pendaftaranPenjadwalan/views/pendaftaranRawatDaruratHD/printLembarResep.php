<style>
	BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
    font-family: "Arial";
    font-size: 7pt;
}
.kwitansi{
		width: 95%;
/*		border-style: double;*/
		padding: 10px;
		height: 400px; 
		margin:10px;
		margin-left: 0;
		font-family: "Times New Roman", Times, serif;
	}
.infors .myDiv {
    -ms-transform: rotate(-90deg); /* IE 9 */
    -webkit-transform: rotate(-90deg); /* Safari */
    transform: rotate(-90deg); /* Standard syntax */
	text-align: center;
	margin-top: 310px;
	margin-left: -400px;
	
} 
.infors .myDiv2 {
    -ms-transform: rotate(-90deg); /* IE 9 */
    -webkit-transform: rotate(-90deg); /* Safari */
    transform: rotate(-90deg); /* Standard syntax */
	text-align: center;
	margin-top: 150px;
	margin-left: -1170px;
	
} 
.infors .myDivisi1 {
    -ms-transform: rotate(-90deg);   
    -webkit-transform: rotate(-90deg);  
    transform: rotate(-90deg); 
	margin-top: -32px;
	margin-left: -200px;
	
} 
.infors .myDivisi2 {
    -ms-transform: rotate(-90deg);   
    -webkit-transform: rotate(-90deg);  
    transform: rotate(-90deg); 
	margin-top: 50px;
	margin-left: -50px;
	
} 

.infors .myDivisi3 {
    -ms-transform: rotate(-90deg);   
    -webkit-transform: rotate(-90deg);  
    transform: rotate(-90deg); 
	margin-top: -170px;
	margin-left: -50px;
	
} 

.myDiv>img {
	width: 50px; height: 50px;
}
.nmrs{ font-size: 12px;}
.kecil{font-size: 8px;} 
.sedang{font-size: 10px;} 
.isi{font-size: 9px;} 
.dokter{font-size: 9px;}
.r{font-size: 20px;}
.infors {
    width: 500px;
	min-height: 200px;
	position: absolute;
}
</style> 

<div class='kwitansi'> 
	<table width='100%'> 
	<tr> 
		<td> 
			<div class="infors">
	<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>	 
		
	     <div class="myDiv">
					<img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?>" width="50" height="50"> 
			
					
		</div>	
		</div>
      </td> 
	  <td>
	        <div class="infors"> 
				<div class="myDiv2">
					<div class="nmrs"><b><?php echo $modProfilRs->nama_rumahsakit;?></b></div><br>
					<div class="kecil"><?php echo $modPendaftaran->ruangan->ruangan_nama;?></div><br>
					<div class='sedang'>Type : Langganan - status : <?php echo $modPendaftaran->statuspasien; ?></div><br>
				</div>
			</div>
	  </td>
	</tr> 
	</table> 
	
	<table width='100%'>
		<tr> 
		<td> 
		 <div class="infors">	 
	     <div class="myDivisi1"> 
			 <div class='isi'>MR/REG/ANTRIAN  :<?php echo isset($modPendaftaran->antrianTs->noantrian) ? $modPasien->no_rekam_medik.'/'.$modPendaftaran->no_pendaftaran.'/'.$modPendaftaran->antrianTs->no_antrian : $modPasien->no_rekam_medik.'/'.$modPendaftaran->no_pendaftaran; ?> <br> 
		PASIEN/UMUR/GOL :<?php echo $modPasien->nama_pasien.'/'.$modPendaftaran->umur; ?>  
		ALAMAT :<?php echo $modPasien->alamat_pasien; ?> <br>
		No. SP: <br>
		PENJAMIN :<?php $modPendaftaran->penjamin->penjamin_nama; ?> <br>
		PSHN PESERTA :<?php $modPendaftaran->carabayar->carabayar_nama; ?> <br>
		ATAS NAMA : <br>
		HUBUNGAN : <br>
		TGL REGISTER : <?php echo $modPendaftaran->tgl_pendaftaran; ?>
			 </div> 
		</div>	
		</div>
      </td> 
	</tr> 
		
	</table> 
	
	<table width='100%'>
		<tr>
			<td>
		<div class="infors">	 
	     <div class="myDivisi2"> 
			 <div class='r'><B>R</B>
			 </div> 
		</div>	
		</div>
			</td>
		</tr>		
	</table> 
	
	<table width='100%'>
		<tr>
			<td>
		<div class="infors">	 
	     <div class="myDivisi3"> 
			 <div class='dokter'><?php echo $modPendaftaran->pegawai->nama_pegawai; ?>
			 </div> 
		</div>	
		</div>
			</td>
		</tr>		
	</table>
</div>
