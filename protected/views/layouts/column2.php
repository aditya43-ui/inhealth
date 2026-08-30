<?php $this->beginContent('//layouts/main'); ?>
<?php
        $pemakai_id = Yii::app()->user->id;
        $modPemakai = LoginpemakaiK::model()->findByPk($pemakai_id);
        $modPegawai = PegawaiM::model()->findByPk($modPemakai->pegawai_id);
                if(empty($modPegawai)){
                    $modPegawai = new PegawaiM;
                }
        $modRuanganPegawai = RuanganpegawaiM::model()->findAllByAttributes(array('pegawai_id'=>$modPemakai->pegawai_id));
        $format = new MyFormatter;

?>
<div class="span-25tmp">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="sidebar">
    <div class="span-6 last">
        <div class="dashboard">
            <div class="gambar">
			<div class="pengumuman_box" style="margin-top:-10px;">
                <?php $this->widget('BoxPengumuman');?>
            </div>


			<div class="row">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'profiluser',
                            'content'=>array(
                                'content-profiluser'=>array(
                                    'header'=>'<b><i class="icon-user icon-white"></i>'.$modPegawai->gelardepan.' '.$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? ", ".$modPegawai->gelarbelakang->gelarbelakang_nama : "").' </b>',
                                    'isi'=>$this->renderPartial('//layouts/_profilUser',array('modPemakai'=>$modPemakai, 'modPegawai'=>$modPegawai, 'modRuanganPegawai'=>$modRuanganPegawai, 'format'=>$format),true),
                                    'active'=>false,
                                    ),   
                                ),
                                )); ?>      
			</div>
			<div class="row">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'carimodul',
                            'content'=>array(
                                'content-carimodul'=>array(
                                    'header'=>'<b><i class="icon-book icon-white"></i> Pencarian Modul</b>',
                                    'isi'=>$this->renderPartial('//layouts/_searchModul',array(),true),
                                    'active'=>true,
                                    ),   
                                ),
                                )); ?>      
			</div>
                        <div class="row">
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'jadwaldokter',
                            'content'=>array(
                                'content-jadwaldokter'=>array(
                                    'header'=>'<b><i class="icon-user icon-white"></i> Jadwal</b> '.
                                    '<b style="font-size:9.8px">'.MyFormatter::getDayUser(date("w"))." / ".MyFormatter::formatDateTimeForUser(date("Y-m-d")).'</b>',
                                    'isi'=>$this->renderPartial('//layouts/_searchJadwalDokter',array(),true),
                                    'active'=>true,
                                    ),   
                                ),
                                )); ?>      
			</div>
	
			</div>
 
            </div>
        </div>
    </div>


<?php $this->endContent(); ?>