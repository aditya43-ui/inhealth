<link rel="stylesheet" href="themes/neon/assets/bootstrap4/css/bootstrap.css" />
 <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald" />
 <script src="themes/neon/assets/bootstrap4/js/jquery.js"></script>
<script src="themes/neon/assets/bootstrap4/js/popper.js"></script>
<script src="themes/neon/assets/bootstrap4/js/bootstrap.js"></script>
<div class="container">
 
		<center>
			<h3>FASILITAS RUMAH SAKIT</h3>
			
		</center>
 
		<div class="bd-example">
                    
			<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
					<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
                                    <?php 
                                            $modFasilitas = FasilitasS::model()->findAll('fasilitasaktif = TRUE ORDER BY namafasilitas');
                                            $jmlfas = count($modFasilitas);
                                    ?>
                                    <?php
                                        $i = 1;
                                       if($jmlfas > 0){
                                        foreach ($modFasilitas as $key => $datafasilitas) {
                                            if (file_exists(Params::urlFasilitasGambar().$datagalery->galeryimage)){
                                                $path 			= Params::urlFasilitasGambar().$datagalery->galeryimage;
                                            }else{
                                                $path = 'images/kiosk/newekios/blur-hospital_1203-7957.jpg';
                                            }
                                    ?>
					<div class="carousel-item active">
					
                                                <img alt="" src="<?php echo $path ?>" class="d-block w-100" alt="..." />
						<div class="carousel-caption d-none d-md-block">
							<h5>Gambar Slide </h5>
							
						</div>
					</div>
                                    <?php		
                                    }
                                       }else{
                                           ?>
                                           <div class="carousel-item active">
					
                                                <img alt="" src="images/kiosk/newekios/blur-hospital_1203-7957.jpg" class="d-block w-100" alt="..." />
						<div class="carousel-caption d-none d-md-block">
							<h5>Gambar Slide </h5>
							
						</div>
					</div>
                                           <?php
                                       }
				    ?>        
				</div>
				<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
 
	</div>
