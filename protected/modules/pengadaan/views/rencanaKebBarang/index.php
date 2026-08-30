
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Rencana Kebutuhan</strong></div>
            </div>
            <div class="panel-body">
				<?php
					$this->breadcrumbs=array(
				        'Transaksi Rencana Kebutuhan',
				    ); 
					if(isset($_GET['sukses'])){
						Yii::app()->user->setFlash('success',"Data Rencana Kebutuhan Barang berhasil disimpan !");
					}
				?>
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
					'id'=>'rencanakebutuhan-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal',
					'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//dimatikan karena pakai cekObat >> ,'onsubmit'=>'return requiredCheck(this);'
				)); ?>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Data Rencana Kebutuhan</div>
                    </div>
                    <div class="panel-body" id="form-rencanakebutuhan">
						<!--fieldset class="box" id="form-rencanakebutuhan"-->
							<div>
								<?php $this->renderPartial($this->path_view.'_formRencanaKebutuhan', array('form'=>$form,'format'=>$format,'modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
							</div>
						<!--/fieldset-->
                    </div>
                </div>								
<!--                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Recomended Order (RO)</div>
                    </div>
                    <div class="panel-body" id="form-recomendedorder">
						fieldset class="box"
							<div>
								<?php // $this->renderPartial($this->path_view.'_formRecomendedBarang', array('form'=>$form,'format'=>$format,'modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
							</div>
						/fieldset
                    </div>
                </div>								-->
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tambah Barang</div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
						<?php  if(!isset($_GET['sukses'])){ ?>
						<!--fieldset class="box"-->
							<div class="row-fluid">
								<?php $this->renderPartial($this->path_view.'_formBarangRencanaKebutuhan',array('modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
							</div>
						<!--/fieldset-->
						<?php } ?>
						<div class="panel panel-primary panel-default">
							<div class="panel-heading">
								<div class="panel-title">Tabel <strong>Rencana Kebutuhan</strong></div>
							</div>
							<div class="panel-body" style="overflow-x: scroll">
								<div class="block-tabel">
									<table class="items table table-bordered table-striped table-condensed" id="table-barang">
										<thead>
											<tr>
                                                                                            <th>No.</th>
                                                                                            <th>Tipe Barang</th>
                                                                                            <th>Kode Barang</th>
                                                                                            <th>Nama Barang</th>
                                                                                            <th>Stok Akhir</th>
                                                                                            <th>Min Stok</th>
                                                                                            <th>Maks Stok</th>                    
                                                                                            <th>Jumlah Kebutuhan</th>
                                                                                            <th>Harga Satuan (Rp)</th>       
                                                                                            <th>PPN (%)</th>
                                                                                            <th>PPN (Rp)</th>
                                                <!--<th>HPP</th>-->
                                                                                            <th>Sub Total (Rp)</th>
                                                                                            <th>Batal</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if(count((array)$modDetails) > 0){
												foreach($modDetails AS $i=>$modRencanaDetailKebBarang){
													$modRencanaDetailKebBarang->harga_barang = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->harga_barang, 2);
													$modRencanaDetailKebBarang->harga_barangdet = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->harga_barangdet, 2);
													$modRencanaDetailKebBarang->ppn = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->ppn, 2);
													$modRencanaDetailKebBarang->hpp = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->hpp, 2);
													$modRencanaDetailKebBarang->jmlpermintaanbarangdet = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->jmlpermintaanbarangdet, 2);
													$modRencanaDetailKebBarang->stokakhir_barangdet = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->stokakhir_barangdet, 2);
													$modRencanaDetailKebBarang->minstok_barangdet = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->minstok_barangdet, 2);
													$modRencanaDetailKebBarang->makstok_barangdet = MyFormatter::formatNumberForPrint($modRencanaDetailKebBarang->makstok_barangdet, 2);
                                                                                                    
                                                                                                    // var_dump($modRencanaDetailKebBarang->attributes); die;
													echo $this->renderPartial($this->path_view.'_rowBarangRencanaKebutuhan',array('modRencanaDetailKebBarang'=>$modRencanaDetailKebBarang,'modRencanaKebBarang'=>$modRencanaKebBarang));
												}
											}
											?>
											<tfoot>
												<tr>
													<td colspan="11" style = "text-align:right;">Total</td>
													<td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::textField('total','',array('class'=>'span2 integer-decimal','style'=>'width:90px;','readonly'=>true)):CHtml::passwordField('total','',array('class'=>'span2 integer-decimal','style'=>'width:90px;','readonly'=>true));?></td>					
													<td></td>
												</tr>
											</tfoot>
										</tbody>
									</table>
								</div>  
								<?php isset($_GET['ubah'])? $modRencanaKebBarang->renkebbarang_id = '' : '' ; ?>
							</div>
						</div>
                    </div>
                </div>	
				<div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Pegawai Berwenang</div>
                    </div>
                    <div class="panel-body">
						<!--fieldset class="box"-->
							<div class="row-fluid">
								<div class="col-sm-6">
									<div class="control-group ">
										<?php echo Chtml::label("Pegawai Gudang <font style='color:red;'>*</font>", 'pegmengetahui_id', array('class' => 'control-label')); ?>
										<div class="controls">
											<?php echo $form->hiddenField($modRencanaKebBarang, 'pegmengetahui_id',array('readonly'=>true)); ?>
											<?php echo $form->textField($modRencanaKebBarang, 'pegmengetahui_nama',array('readonly'=>true, 'class' => 'required')); ?>
											<?php
											/*$this->widget('MyJuiAutoComplete', array(
												'model'=>$modRencanaKebBarang,
												'attribute' => 'pegmengetahui_nama',
												'source' => 'js: function(request, response) {
																   $.ajax({
																	   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
																	   dataType: "json",
																	   data: {
																		   term: request.term,
																	   },
																	   success: function (data) {
																			   response(data);
																	   }
																   })
																}',
												'options' => array(
													'showAnim' => 'fold',
													'minLength' => 3,
													'focus' => 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
													'select' => 'js:function( event, ui ) {
														$("#'.Chtml::activeId($modRencanaKebBarang, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
														return false;
													}',
												),
												'htmlOptions' => array(
													'class'=>'pegawaimengetahui_nama',
													'onkeyup'=>"return $(this).focusNextInputField(event)",
													'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebBarang, 'pegmengetahui_id') . '").val(""); '
												),
												'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
											));*/
											?>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="control-group ">
										<?php echo Chtml::label("Kepala Instalasi Gudang Umum <font style='color:red;'>*</font>", 'pegmenyetujui_id', array('class' => 'control-label')); ?>
										<div class="controls">
											<?php echo $form->hiddenField($modRencanaKebBarang, 'pegmenyetujui_id',array('readonly'=>true)); ?>
											<?php echo $form->textField($modRencanaKebBarang, 'pegmenyetujui_nama',array('readonly'=>true, 'class' => 'required')); ?>
                                                                                            <?php
//											$this->widget('MyJuiAutoComplete', array(
//												'model'=>$modRencanaKebBarang,
//												'attribute' => 'pegmenyetujui_nama',
//												'source' => 'js: function(request, response) {
//													$.ajax({
//														url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
//														dataType: "json",
//														data: {
//															term: request.term,
//														},
//														success: function (data) {
//															response(data);
//														}
//													})
//												}',
//												'options' => array(
//													'showAnim' => 'fold',
//													'minLength' => 3,
//													'focus' => 'js:function( event, ui ) {
//														$(this).val( ui.item.label);
//														return false;
//													}',
//													'select' => 'js:function( event, ui ) {
//														$("#'.Chtml::activeId($modRencanaKebBarang, 'pegmenyetujui_id') . '").val(ui.item.pegawai_id); 
//														return false;
//													}',
//												),
//												'htmlOptions' => array(
//													'class'=>'pegawaimenyetujui_nama required hurufs-only',
//													'onkeyup'=>"return $(this).focusNextInputField(event)",
//													'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebBarang, 'pegmenyetujui_id') . '").val(""); '
//												),
//												'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
//											));
											?>
										</div>
									</div>
								</div>
							</div>
						<!--/fieldset-->
                    </div>
                </div>				
				<div class="row-fluid">
					<div class="form-actions">
						<?php 
							if(!isset($_GET['sukses'])){
								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekBarang();', 'onKeypress' => 'return formSubmit(this,event)')); //formSubmit(this,event)
								echo "&nbsp;";
							}else{
								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
								echo "&nbsp;";
							}
							if(!isset($_GET['frame'])){
								echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
									$this->createUrl($this->id.'/index'), 
									array('class'=>'btn btn-danger',
									'onclick'=>'return refreshForm(this);'));
								echo "&nbsp;";
							}
							if(!isset($_GET['sukses'])){
								echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
								echo "&nbsp;";
							}else{
								echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
								echo "&nbsp;";
							}

							$content = $this->renderPartial($this->path_view.'tips/tipsRencanaKebutuhan',array(),true);
							$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
						?> 
					</div>
				</div>
				<?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>     	
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebBarang'=>$modRencanaKebBarang)); ?>
