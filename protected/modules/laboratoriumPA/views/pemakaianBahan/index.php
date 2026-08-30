<!--div class="white-container"-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<?php 
	if(isset($_GET['sukses'])){
		Yii::app()->user->setFlash('success',"Data pemakaian Bahan berhasil disimpan !");
	}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pemakaianbahp-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
	'focus'=>'#no_pendaftaran',
)); ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pemakaian <strong>Bahan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></div>
                    </div>
                    <div class="panel-body">
						<fieldset  id="form-datakunjungan">
							<div class="row-fluid">
								<?php $this->renderPartial($this->path_view_bmhp.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
							</div>
						</fieldset>
                    </div>
                </div>								              
				<div class="row-fluid">
					<div class="col-md-12">
						<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'riwayat-obatalkespasien-t',
								'content'=>array(
									'content-riwayat-obatalkespasien-t'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk menampilkan obat alkes pasien')).'<b> Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
										'isi'=>'
											<table class="table table-bordered table-condensed table-striped">
												<thead>
													<th>No.</th>
													<th>Tgl. Pelayanan</th>
													<th>Obat / Alat Kesehatan</th>
													<!--th>Satuan Kecil</th-->
													<th>Jumlah</th>
													<th>Hapus</th>
												</thead>
												<tbody>
													<tr><td colspan=7>Data tidak ditemukan</td></tr>
												</tbody>
											</table>',
										'active'=>true,
									),   
								),
						)); ?>
					</div>
				</div>                   						
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Obat dan Alat Kesehatan</div>
                    </div>
                    <div class="panel-body table-responsive ">
						<fieldset id="form-tambahobatalkes">
							<div class="row-fluid">
								<?php $this->renderPartial($this->path_view.'_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan)); ?>
							</div>
							<div class="block-tabel panel panel-primary panel-default">
								<div class="panel-heading">
									<div class="panel-title">Tabel Obat dan <strong>Alat Kesehatan</strong></div>
								</div>
								<div class="panel-body table-responsive">
									<table class="items table-bordered table table-striped table-condensed" id="table-obatalkespasien">
										<thead>
											<tr>
												<th>No.</th>
												<th>Obat / Alat Kesehatan</th>
												<!--th>Satuan Kecil</th-->
												<!--th>Stok</th-->
												<th>Jumlah</th>
                                                                                                <th>Status</th>
												<th>Batal</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(count($dataOas) > 0){
												foreach($dataOas AS $i=>$modObatAlkesPasien){
													echo $this->renderPartial($this->path_view.'_rowObatAlkesPasien',array('modObatAlkesPasien'=>$modObatAlkesPasien));
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</fieldset>
                    </div>
                </div>	
				<div class="row-fluid">
					<div class="form-actions">
							<?php 
//							if($modKunjungan->isNewRecord){
								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_submit','class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type'=>'button','disabled'=>(isset($_GET['sukses']))? true : false,'onclick'=>'setVerifikasi(this);', 'onkeypress'=>'formSubmit(this,event);'));
								echo "&nbsp;";
//							}
//							else
//							{
//								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary disabled', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
//								echo "&nbsp;";
//							}
								if(!isset($_GET['frame'])){
									echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
										$this->createUrl($this->id.'/index'), 
										array('class'=>'btn btn-danger',
			//                                  'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
												'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
									echo "&nbsp;";
								}
								if($modKunjungan->isNewRecord){
									echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
									echo "&nbsp;";
								}else{
									echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(".$modKunjungan->pasienmasukpenunjang_id.");return false"));
									echo "&nbsp;";
								}


								$content = $this->renderPartial('laboratoriumPA.views.pemakaianBahan.tips.tipsPemakaianBahan',array(),true);
								$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
							?> 
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
   
    
    
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view_bmhp.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
<script type ="text/javascript"> 
    
function setVerifikasi(obj) {
    if ($("#table-obatalkespasien tbody tr").length == 0) {
            myAlert("Obat/Alkes Tidak Boleh Kosong !");
            return false;
        } 
    if (!requiredCheck($("#pemakaianbahp-form"))) return false;
    
    
     
    $("#pemakaianbahp-form").submit();
    $("#btn_submit").prop('disabled', true);
    
    return false;
}    
</script>