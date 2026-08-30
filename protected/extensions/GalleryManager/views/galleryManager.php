<?php
/**
 * @var $this GalleryManager
 * @var $model GalleryPhoto
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
?>
<?php echo CHtml::openTag('div', $this->htmlOptions); ?>
    <!-- Gallery Toolbar -->
    <div class="row">
		<div class="col-sm-12">
                <label>Judul Gambar</label><br>
                <?php echo CHtml::textField('judulphoto','',array('readonly'=>true,'placeholder'=>'Ketikan Judul Photo Pemeriksaan')); ?>
		</div>
	</div>
    <div class="btn-toolbar gform">
		<div class="row">
			<div class="col-sm-12">
				<?php $pendaftaran_id = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;?>
					<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil Gambar',array('{icon}'=>'<i class="icon-camera icon-white"></i>')), 
                    array('class'=>'btn btn-primary','onclick'=>"$('#dialog-addphoto').dialog('open');",
                          'id'=>'btn-addphoto','onkeyup'=>"return $(this).focusNextInputField(event)",
                          'rel'=>'tooltip','title'=>'Klik untuk Ambil Foto','style'=>'')) ?>        
				<div class="btn btn-success fileinput-button">
					<i class="icon-plus icon-white"></i>
					<?php echo Yii::t('galleryManager.main', 'Tambah');?>
					<input type="file" name="image" id="image" class="afile" accept="image/*" multiple="multiple" onChange="refreshGallery();" />
					<!--<input type="file" name="image" id="image" multiple="multiple" onChange="cekForm();"/>-->
					<!--class="afile" accept="image/*"-->
				</div>
				<div class="btn-group">
					<label class="btn" style="margin-top: 4px; margin-left:">
						<input type="checkbox" style="float:left;margin: 0;" class="select_all" />
						<?php echo Yii::t('galleryManager.main', 'Pilih Semua');?>
					</label>
					<!--<span class="btn disabled edit_selected"><i class="icon-pencil"></i> <?php //echo Yii::t('galleryManager.main', 'Edit');?></span>-->
				</div>
				<div class="btn disabled remove_selected">
					<i class="icon-remove icon-white" rel="tooltip" title="Klik untuk hapus gambar"></i> <?php echo Yii::t('galleryManager.main', 'Hapus');?>
				</div>
				<div class="btn disabled gallery_selected">
					<i class="icon-plus icon-white" rel="tooltip" title="Klik untuk tampilkan gambar ke gallery"></i> <?php echo Yii::t('galleryManager.main', 'Simpan di Galery');?>
				</div>
			</div>
		</div>             
    </div>
	
                
    <!-- Gallery Photos -->
    <div class="sorter" id="sorter">
        <div class="images"></div>
        <br style="clear: both;"/>
    </div>

    <!-- Modal window to edit photo information -->
    <div class="modal hide ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>

            <h3><?php echo Yii::t('galleryManager.main', 'Edit information')?></h3>
        </div>
        <div class="modal-body">
            <div class="form"></div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary save-changes">
                <?php echo Yii::t('galleryManager.main', 'Save changes')?>
            </a>
            <a href="#" class="btn" data-dismiss="modal"><?php echo Yii::t('galleryManager.main', 'Close')?></a>
        </div>
    </div>
    <div class="overlay">
        <div class="overlay-bg">&nbsp;</div>
        <div class="drop-hint">
            <span class="drop-hint-info"><?php echo Yii::t('galleryManager.main', 'Drop Files Here…')?></span>
        </div>
    </div>
    <div class="progress-overlay" style="width:500px; margin-left: 100px;">
        <div class="overlay-bg">&nbsp;</div>
        <!-- Upload Progress Modal-->
        <div class="modal progress-modal">
            <div class="modal-header">
                <h3><?php echo Yii::t('galleryManager.main', 'Uploading images…')?></h3>
            </div>
            <div class="modal-body">
                <div class="progress progress-striped active">
                    <div class="bar upload-progress"></div>
                </div>
            </div>
        </div>
    </div>
<?php echo CHtml::closeTag('div'); ?>