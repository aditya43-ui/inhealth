<style>
    .integerfloat {
        text-align: right;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi Faktur <strong>Pembelian Farmasi</strong></div>
            </div>
            <div class="panel-body">
				<?php
					if(isset($_GET['sukses'])){
						Yii::app()->user->setFlash('success',"Data Faktur Pembelian berhasil disimpan !");
					}
				?>
				<?php
				 	$this->breadcrumbs=array(
				            'Transaksi Faktur Pembelian Farmasi',
				        );
					$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php
					$this->widget('application.extensions.moneymask.MMask',array(
						'element'=>'.currency',
						'currency'=>'PHP',
						'config'=>array(
							'symbol'=>'Rp. ',
							'defaultZero'=>true,
							'allowZero'=>true,
							'precision'=>0,
						)
					));
					$this->widget('application.extensions.moneymask.MMask',array(
						'element'=>'.integerfloat',
						'currency'=>'PHP',
						'config'=>array(
							'defaultZero'=>true,
							'allowZero'=>true,
							'precision'=>2,
                            'decimal'=>',',
                            'thousands'=>'.',
						)
					));
				?>
				<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
					'id'=>'fakturpembelian-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal',
					'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)' //, 'onsubmit'=>'return requiredCheck(this);'
                        ),
				)); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Data Penerimaan </span></div>
                    </div>
                    <div class="panel-body" id="form-rencanakebutuhan">
						<div>
							<?php $this->renderPartial($this->path_view.'_formPenerimaanBarang', array('form'=>$form,'format'=>$format,'modPenerimaanBarang'=>$modPenerimaanBarang,'modFakturPembelian'=>$modFakturPembelian)); ?>
						</div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow" style="display: none;" id="divuangmukabeli">
                    <div class="panel-heading">
                        <div class="panel-title">Data Pembayaran Uang Muka</div>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <div class="control-group ">
                                    <?php echo CHtml::label('No. Pembayaran <span class="required">*</span>', 'nopembayaran', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php  echo $form->textField($modUangmuka, 'nopembayaran', array('readonly'=>true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo CHtml::label('Tanggal Pembayaran <span class="required">*</span>', 'tgluangmukabeli', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php  echo $form->textField($modUangmuka, 'tgluangmukabeli', array('readonly'=>true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group ">
                                    <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jumlahuang', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php  echo $form->textField($modUangmuka, 'jumlahuang', array('readonly'=>true,'class'=>'integer-decimal span3')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Tabel Faktur Obat <strong>&amp; Alat Kesehatan</strong></div>
					</div>
					<div class="panel-body" style="overflow-x: auto;max-width: 100%">
						<div class="block-tabel">
							<table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
								<thead>
									<tr>
										<th hidden><?php  echo CHtml::checkBox('checklist',true,array('onclick'=>'checkAll(this);'));?></th>
										<th>No.</th>
										<th>Kode</th>
										<th>Nama Obat & Alkes</th>
										<th hidden>Jumlah Permintaan </th>
										<th>Jml Terima</th>
										<th>Harga Satuan (Rp)</th>
										<th width="50px;">Keringanan (%)</th>
										<th>Keringanan (Rp)</th>
										<th width="50px;">PPN (%)</th>
                                                                                <th>PPN (Rp.)</th>
										<th width="50px;">PPh (%)</th>
                                                                                <th>PPh (Rp)</th>
										<th>HPP</th>
										<th>Sub Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
										//if (!isset($_GET['fakturpembelian_id'])){
											if(count((array)$modDetails) > 0){
												foreach($modDetails AS $i=>$modFakturDetail){
													$modFakturDetail->harganettoper = MyFormatter::formatNumberForPrint($modFakturDetail->harganettoper,2);
                                                                                                    $modFakturDetail->jmlterima = number_format($modFakturDetail->jmlterima,2,",",".");
													echo $this->renderPartial($this->path_view.'_rowObatPenerimaanBarang',array('modFakturDetail'=>$modFakturDetail,'modFakturPembelian'=>$modFakturPembelian,'format'=>$format));
												}
											}
										//}else{
											//$modDetails = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id'=>$_GET['fakturpembelian_id']));
											//foreach($modDetails AS $i=>$modFakturDetail){
											//	echo $this->renderPartial($this->path_view.'_rowObatFakturPembelian',array('modFakturDetail'=>$modFakturDetail,'modFakturPembelian'=>$modFakturPembelian,'format'=>$format));
											//}
										//}
									?>

								</tbody>
									<tfoot hidden>
										<tr>
											<td colspan="9">Total</td>
											<td>
												<?php echo CHtml::textField('total','',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true))?>
												<?php echo $form->hiddenField($modPenerimaanBarang,'harganetto', array('readonly'=>true,'class'=>'integer2')); ?>
												<?php echo $form->hiddenField($modPenerimaanBarang,'totalharga', array('readonly'=>true,'class'=>'integer2')); ?>
												<?php echo $form->hiddenField($modPenerimaanBarang,'totalpajakpph', array('readonly'=>true,'class'=>'integer2')); ?>
												<?php echo $form->hiddenField($modPenerimaanBarang,'totalpajakppn', array('readonly'=>true,'class'=>'integer2')); ?>
												<?php echo $form->hiddenField($modPenerimaanBarang,'jmldiscount', array('readonly'=>true,'class'=>'integer2')); ?>
											</td>

										</tr>
									</tfoot>
							</table>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Faktur Pembelian</div>
					</div>
					<div class="panel-body" id="form-rencanakebutuhan">

							<?php $this->renderPartial($this->path_view.'_formFakturPembelianBaru', array('form'=>$form,'format'=>$format,'modFakturPembelian'=>$modFakturPembelian)); ?>

					</div>
				</div>


				<div class="row-fluid">
					<div class="form-actions">
						<?php
							if($modFakturPembelian->isNewRecord){
								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'tombolSimpan();', 'onkeypress'=>'tombolSimpan();'));
								echo "&nbsp;";
							}else{
								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true));
								echo "&nbsp;";
							}

							if(!isset($_GET['frame'])){
								echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
								$this->createUrl($this->id.'/index'),
								array('class'=>'btn btn-danger',
									  'onclick'=>'return refreshForm(this);'));
								echo "&nbsp;";
							}
							if($modFakturPembelian->isNewRecord){
								echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
								echo "&nbsp;";
								// echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));
								// echo "&nbsp;";
							}else{
								echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
								echo "&nbsp;";
								// echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
								// echo "&nbsp;";
							}

							$content = $this->renderPartial($this->path_view.'tips/tipsFakturPembelian',array(),true);
							$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
						?>
					</div>
				</div>
				<?php $this->endWidget(); ?>
				<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenerimaanBarang'=>$modPenerimaanBarang,'modFakturPembelian'=>$modFakturPembelian,'modUangmuka'=>$modUangmuka)); ?>
            </div>
        </div>
    </div>
