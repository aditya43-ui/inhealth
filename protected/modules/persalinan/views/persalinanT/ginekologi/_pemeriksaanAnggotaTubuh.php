<div class="row-fluid">
	<div class="col-sm-5">
		<div  style="width:412px !important; border: 1px solid black">
				<?php
				$i = 1;
				$gbrTubuh = GambartubuhM::model()->findAllByAttributes(array('isginekologi'=>true));

				foreach($gbrTubuh as $tbh){			
					if ($i == 1){
						$css = " 
							#imgtag".$tbh->gambartubuh_id."
							{
									position: relative;
									min-width: 300px;
									min-height: 300px;
									float: none;
									border: 3px solid #FFF;
									cursor: crosshair;
									text-align: center;										
							}
							#tagit".$tbh->gambartubuh_id."
							{
									position: absolute;
									top: 0;
									left: 0;
									width: 300px;
									border: 1px solid #D7C7C7;
									z-index: 10;
							}
							#tagit".$tbh->gambartubuh_id." .name
							{
									/*float: left;*/
									background-color: #FFF;
									width: 295px;
									/*height: 92px;*/
									/*padding: 5px;*/
									font-size: 10pt;
									margin:0 auto;
									margin-bottom: 0 auto;
							}
							#tagit".$tbh->gambartubuh_id." DIV.text
							{
									margin-bottom: 5px;
							}
							#tagit".$tbh->gambartubuh_id." INPUT[type=text]
							{
									margin-bottom: 5px;
							}
							#tagit".$tbh->gambartubuh_id." #tagname".$tbh->gambartubuh_id."
							{
									width: 110px;
							}";	
				?>
						<div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
							<img data-id="<?php echo $tbh->gambartubuh_id; ?>" img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;"/> 
							<div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
						</div>
				<?php
					}else{
							$css .= " 
							#imgtag".$tbh->gambartubuh_id."
							{
									position: relative;
									min-width: 300px;
									min-height: 300px;
									float: none;
									border: 3px solid #FFF;
									cursor: crosshair;
									text-align: center;										
							}
							#tagit".$tbh->gambartubuh_id."
							{
									position: absolute;
									top: 0;
									left: 0;
									width: 300px;
									border: 1px solid #D7C7C7;
									z-index: 10;
							}
							#tagit".$tbh->gambartubuh_id." .name
							{
									/*float: left;*/
									background-color: #FFF;
									width: 295px;
									/*height: 92px;*/
									/*padding: 5px;*/
									font-size: 10pt;
									margin:0 auto;
									margin-bottom: 0 auto;
							}
							#tagit".$tbh->gambartubuh_id." DIV.text
							{
									margin-bottom: 5px;
							}
							#tagit".$tbh->gambartubuh_id." INPUT[type=text]
							{
									margin-bottom: 5px;
							}
							#tagit".$tbh->gambartubuh_id." #tagname".$tbh->gambartubuh_id."
							{
									width: 110px;
							}";
				?>
						<div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
								<img data-id="<?php echo $tbh->gambartubuh_id; ?>" img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $i ?>" src="<?php echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>"  style="width:480px;"/> 
							<div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
						</div>
				<?php
					}
					$i++;
				}
				if (!empty($css)) {
					Yii::app()->clientScript->registerCss('anatomi', $css);
				}
				?>
		</div>
	</div>
	<div class="col-sm-7">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Tabel Pemeriksaan</div>
			</div>
			<div class="panel-body table-responsive">
				<div class='block-tabel'>
					<table class="items table table-bordered table-striped table-condensed" id="table-bagtubuh">
						<thead>
							<tr>
								<th  width='30px'>No.</th>
								<th>Bagian Tubuh</th>
                                <th>Look</th>
                                <th>Feel</th>
                                <th>Move</th>
                                <th>Sensory</th>
                                <th>Motorik</th>
                                <th>Keterangan</th>
								<th  width='80px'>Batal / Hapus</th>
							</tr>
						</thead>
						<tbody>
							<?php
                            if (($modPemeriksaanGambar)) {
                                foreach ($modPemeriksaanGambar as $ii => $vv) {
                                    $vv->namabagtubuh = $vv->bagiantubuh->namabagtubuh;
                                    $vv->kordinat_tubuh_x = number_format($vv->kordinat_tubuh_x, 7);
                                    $vv->kordinat_tubuh_y = number_format($vv->kordinat_tubuh_y, 7);
                                    echo $this->renderPartial($this->path_view . 'ginekologi/_rowPemeriksaanAnggotaTubuh', array('modPemeriksaanGbr' => $vv, 'i' => $ii + 1), true);
                                }
                            } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>