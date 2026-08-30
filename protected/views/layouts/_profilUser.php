<div class="profil-pegawai">
				<div class="span3">
					<div class="control-group">
				<?php 
					$path_foto = "data/images/pasien/no_photo.jpeg";
					if(isset($modPegawai->photopegawai)){
						$path_foto = Params::pathPegawaiDirectory().$modPegawai->photopegawai;
					}else if(isset($modPemakai->photouser)){
						$path_foto = "data/images/".$modPemakai->photouser;
					}
				?>
				<?php echo CHtml::image($path_foto,"Foto Pegawai", array('class'=>'span3')); ?>
					</div>
					<div class="control-group">
						<?php echo CHtml::activeLabel($modPegawai,'nama_pegawai', array('class'=>'control-label	')); ?>
						<div class="controls">
							<?php echo $modPegawai->gelardepan." ".$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? ", ".$modPegawai->gelarbelakang->gelarbelakang_nama : ""); ?>
						</div>
					</div>

					<div class="control-group">
						<?php echo CHtml::activeLabel($modPegawai,'tgl_lahirpegawai', array('class'=>'control-label	')); ?>
						<div class="controls">
							<?php echo isset($modPegawai->tgl_lahirpegawai) ? $format->formatDateTimeId($modPegawai->tgl_lahirpegawai) : "-"; ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::activeLabel($modPegawai,'alamatemail', array('class'=>'control-label	')); ?>
						<div class="controls">
							<?php echo isset($modPegawai->alamatemail) ? $modPegawai->alamatemail : "-"; ?>
						</div>
					</div>

				</div>

			</div>