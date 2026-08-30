<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Rencana Kebutuhan (Barang)</strong></div>
            </div>
            <div class="panel-body">
				<?php
					$url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/FrameRencanaKebutuhanBarang&id=1');
					Yii::app()->clientScript->registerScript('search', "
					$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
					});
					$('#search-laporan').submit(function(){
						$.fn.yiiGridView.update('laporan-grid', {
							data: $(this).serialize()
						});
						return false;
					});
					");
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'search-laporan',
            'focus' => '#' . CHtml::activeId($model, 'noperencnaan'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php echo CHtml::hiddenField('filter_tab', 'rekap'); ?>
                        <div class="control-group">
                            <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                            <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                            <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
						<div class="row-fluid">
							<div class="col-sm-6">
								<?php echo CHtml::hiddenField('type', ''); ?>
								<?php echo CHtml::hiddenField('filter_tab','rekap'); ?>									
								<div class="control-group">
									<?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
									<?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
									<?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
									<?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
									<?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
									<?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
									<div class="controls">
										<div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
											<i class="entypo-calendar"></i>
											<span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
											<?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
											<?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
										</div>
									</div>
								</div>																		
							</div>								
						</div>
						<?php /*
						<div class="control-group">
						<?php echo CHtml::label('No. Perencanaan','',array('class'=>'control-label')); ?>
							<div class="controls">
								<?php   
									   echo $form->textField($model,'renkebbarang_no',array('placeholder'=>'Ketik No. Perencanaan','class'=>'span3'));
								?>
							</div>
						</div>
					*/ ?>
						<div class="form-actions">
							<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
								array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
							<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
								Yii::app()->createUrl($this->module->id.'/laporan/rencanaKebutuhan'), 
								array('class'=>'btn btn-danger',
									'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
						</div>
						<?php $this->endWidget(); ?>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Rencana Kebutuhan (Barang)</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->renderPartial($this->path_view.'_tableRencanaBarang',array('model'=>$model)); ?>
						</div>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Grafik</div>
                    </div>
                    <div class="panel-body">
						<div class="block-tabel">
							<?php $this->renderPartial($this->path_view.'_tab'); ?>
							<iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
							</iframe>
						</div>
                    </div>
                </div>								
				<?php 
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintRencanaKebutuhanBarang');
				$this->renderPartial($this->path_view.'_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
				?>
            </div>
        </div>
    </div>
</div>    
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model));?>