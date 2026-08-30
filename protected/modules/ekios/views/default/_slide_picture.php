<script type="text/javascript" src="<?php //echo Yii::app()->request->baseUrl; ?>/js/jquery.infinitecarousel.js"></script>
<script>
$(function(){
  $("#fasilitas").hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $('#carousel-kiosk').infiniteCarousel({
    displayTime: 6000,
    textholderHeight : .25
  });
  
  // $('#contentKamar').find('div class="paket"').each(
  //   function(){
  //     myAlert(1)
  //   }
  // );

  
  
});

function ekios_home(){
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $('#slider').fadeIn();
}

// $('#fasilitas').hide();
function fasilitas(){
  //myAlert("Menuju Tampilan Fasilitas");
  $('#slider').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $('#fasilitas').fadeIn();
}

function asuransi(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").fadeIn();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $("#infokamar").hide();
}

function kamarperawatan(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").fadeIn();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $("#infokamar").hide();
}

function jadwaldokter(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").fadeIn();
  $("#paketpelayanan").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $("#infokamar").hide();
}

function paketpelayanan(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").fadeIn();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $("#infokamar").hide();
}

function infokamar(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").fadeIn();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
  $("#isi").hide();
  $("#kamarruangan").show();
}

function kritiksaran(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").fadeIn();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").hide();
}

function buatjanji(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").fadeIn();
  $("#bookingkamar").hide();
  $("#denah").hide();
}

function bookingkamar(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").fadeIn();
  $("#denah").hide();
}


function denah(){
  $('#slider').hide();
  $('#fasilitas').hide();
  $("#asuransi").hide();
  $("#kamarperawatan").hide();
  $("#jadwaldokter").hide();
  $("#paketpelayanan").hide();
  $("#infokamar").hide();
  $("#kritiksaran").hide();
  $("#buatjanji").hide();
  $("#bookingkamar").hide();
  $("#denah").fadeIn();
}


</script>

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/infiniteCarousel.css" type="text/css" />
<div id="carousel-kiosk" style="width:100%">
			<ul>
				<!--<li><img alt="" src="css/hijau.png" width="975" height="415" style="width: 975px;height:415px;" /><p><?php echo Yii::app()->user->getState('nama_rumahsakit'); ?></p>-->
				</li>
			<?php
				$modPicture = ProfilpictureM::model()->getPicture();
				if(!empty($modPicture)){
					foreach ($modPicture as $i => $picture){
                                                if (file_exists(Params::pathAntrianSliderGambar().$picture['profilpicture_path'])){
                                                    $path 			= Params::urlAntrianSliderGambar().$picture['profilpicture_path'];
                                                }else{
                                                    $path = 'images/kiosk/newekios/blur-hospital_1203-7957.jpg';
                                                }
						$description 	= $picture['profilpicture_desc'];
						$nama 		= $picture['profilpicture_nama'];
			?>
                                <li><div></div><img alt="" id="ukuran" src="<?php echo $path ?>" width="975" height="415" />
							<p><?php echo $nama."<br>".$description ?></p>
						</li>
			<?php			
					} // akhir dari looping foreach
				}else{
			?>
					<li><img alt="" src="css/hijau.png"  height="100%" style="width: 975px;height:415px;" /><p>Gambar belum tersedia di database</p>
					</li>
			<?php					
				} // akhir dari kondisi
			?>
                                        
			</ul>
		</div>
<style>
    
    #ukuran{
    }
    .thumb{
         display: block;
    }
</style>