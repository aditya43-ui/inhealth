<!--div class="white-container"-->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi Rincian <strong>Tagihan Pasien</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Rincian <strong>Tagihan Pasien</strong></div>
                    </div>
                    <div class="panel-body table-responsive">
						<?php
							Yii::app()->clientScript->registerScript('search', "
							$('.search-button').click(function(){
								$('.search-form').toggle();
								return false;
							});
							$('#rjrinciantagihanpasien-v-search').submit(function(){
								$.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
									data: $(this).serialize()
								});
								return false;
							});
							");

							$this->widget('bootstrap.widgets.BootAlert'); 
						?>

						<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>


						<div class="block-tabel">							
							<?php 
								$module  = $this->module->name; 
								$controller = $this->id;
							?>
							<?php $this->widget('bootstrap.widgets.BootAlert');	?>
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'rjrinciantagihanpasien-v-grid',
								'dataProvider'=>$model->searchRincian(),
							//	'filter'=>$model,
								'template'=>"{summary}\n{items}\n{pager}",
								'itemsCssClass'=>'table table-bordered table-striped table-condensed',
								'columns'=>array(                        
									array(
										'header' => 'Tanggal Pendaftaran/ <br/> No Pendaftaran',
										'type' => 'raw',
										'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran'
									),
									array(
										'header'=>'No. Rekam Medik',
										'type'=>'raw',
										'value'=>'$data->no_rekam_medik',
									),
									array(
										'header'=>'Nama Pasien',
										'type'=>'raw',
										'value'=>'$data->namadepan." ".$data->nama_pasien',
									),
									array(
										'header'=>'Jenis Penjamin / <br/>Penjamin',
										'type'=>'raw',
										'value'=>'$data->carabayar_nama."/ <br/>".$data->penjamin_nama',
									),
									array(
										'header' => 'Dokter Pemeriksa',
										'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'
									),                        
									'jeniskasuspenyakit_nama',
									array(
										'header'=>'Status Bayar',
										'type'=>'raw',
										'value'=>'(empty($data->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"' ,
									),
									array(
										'header'=>'Total Tagihan',
										'value'=>'number_format($data->totaltagihan,0,".",".")',
									),
									array(
										'header'=>'Rincian',
										'type'=>'raw',
										'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("'.$module.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: left; width:40px')
									),		
								),
								'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
							)); ?>
						</div>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="icon-white icon-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
						<fieldset class="search-form">
							<?php $this->renderPartial('laboratoriumPA.views.rinciantagihanpasienpenunjangV._search',array(
								'model'=>$model,'format'=>$format
							)); ?>
						</fieldset>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
							'id' => 'dialogRincian',
							'options' => array(
								'title' => 'Rincian Tagihan Pasien',
								'autoOpen' => false,
								'modal' => true,
								'width' => 900,
								'height' => 550,
								'resizable' => false,
							),
						));
						?>
						<iframe name='frameRincian' width="100%" height="100%"></iframe>
						<?php $this->endWidget(); ?>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>       
<!--/div-->