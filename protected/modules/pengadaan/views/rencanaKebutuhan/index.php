
<style type="text/css">
    .integer-decimal{
        text-align: right;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-clipboard-check"></i> Transaksi <b>Rencana Kebutuhan</b>
                <span class="pull-right">
                    <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                    </a>
                </span>
            </div>
            </div>
            <div class="panel-body">
				<?php 
                    if(!empty($modDetails[0]->rencdetailkeb_id)){
                        $this->breadcrumbs=array(
                            'Informasi Rencana Kebutuhan'=>Yii::app()->request->getUrlReferrer(),
                            'Rencana Kebutuhan',
                        );
                    }else{
                        $this->breadcrumbs=array(
                            'Rencana Kebutuhan',
                        );
                    }
					if(isset($_GET['sukses'])){
						Yii::app()->user->setFlash('success',"Data Rencana Kebutuhan berhasil disimpan !");
					}
				?>
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
					'id'=>'rencanakebutuhan-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal',
					'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//dimatikan karena pakai cekObat >> ,'onsubmit'=>'return requiredCheck(this);'
				)); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Rencana Kebutuhan</div>
                    </div>
                    <div class="panel-body" id="form-rencanakebutuhan">
						<!--fieldset class="box" id="form-rencanakebutuhan"-->
							<div>
								<?php $this->renderPartial($this->path_view.'_formRencanaKebutuhan', array('form'=>$form,'format'=>$format,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
							</div>
						<!--/fieldset-->
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tambah Obat &amp; Alat Kesehatan</div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
                        <?php  if(!isset($_GET['sukses'])){ ?>
                        <!--fieldset class="box" id="form-tambahobatalkes"-->
                                <div class="row-fluid">
                                        <?php $this->renderPartial($this->path_view.'_formObatRencanaKebutuhan',array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modObatAlkesVv'=>$modObatAlkesVv)); ?>
                                </div>
                        <!--/fieldset-->
                        <?php } ?>
                        <div class="panel panel-default panel-primary">
                            <div class="panel-heading">
                                    <div class="panel-title">Tabel <strong>Rencana Kebutuhan</strong></div>
                            </div>
                            <div class="panel-body" style="overflow-x: scroll">
                                <div class="block-tabel">
                                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                                        <thead>
                                            <tr>
                                                    <th rowspan="2">No.</th>
                                                    <th rowspan="2">Supplier</th>
                                                    <th rowspan="2">Jenis</th>
                                                    <th rowspan="2">Nama Obat</th>
                                                    <th rowspan="2">Tgl. Kadaluarsa</th>
                                                    <th colspan="4" style="text-align: center;">Stok</th>

                                                    <th rowspan="2">Satuan </th>
                                                    <!--th>Buffer Stok</th-->
                                                    <th rowspan="2">Harga Satuan</th>
                                                    <th rowspan="2">PPN (%)</th>
                                                    <th rowspan="2">PPN (Rp)</th>
                                                    <th rowspan="2">HPP</th>
                                                    <th rowspan="2">Sub Total</th>
                                                    <th rowspan="2">VEN</th>
                                                    <th rowspan="2">ABC</th>
                                                    <th rowspan="2">Batal</th>
                                            </tr>
                                            <tr>

                                                    <th>Jumlah yang Harus Diorder</th>
                                                    <th>Awal</th>
                                                    <th>Pembelian</th>
                                                    <th>Akhir</th>																								
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(count((array)$modDetails) > 0){
                                                    foreach($modDetails AS $i=>$modRencanaDetailKeb){
                                                        $modRencanaDetailKeb->jmlpermintaan = number_format($modRencanaDetailKeb->jmlpermintaan,2,",",".");
                                                        $modRencanaDetailKeb->harganettorenc = MyFormatter::formatNumberForPrint($modRencanaDetailKeb->harganettorenc,2);

                                                        if(!empty($modRencanaDetailKeb->satuanbesar_id)){
                                                            $modRencanaDetailKeb->satuanobat = Params::SATUANOBAT_BESAR;
                                                        }else{
                                                            $modRencanaDetailKeb->satuanobat = Params::SATUANOBAT_KECIL;
                                                        }
                                                        $modRencanaDetailKeb->satuankecil_nama = $modRencanaDetailKeb->satuankecil_id;
                                                        $modRencanaDetailKeb->satuanbesar_nama = $modRencanaDetailKeb->satuanbesar_id;
                                                        $modRencanaDetailKeb->satuanobat_nama = $modRencanaDetailKeb->satuanobat;
                                                        echo $this->renderPartial($this->path_view.'_rowObatRencanaKebutuhan',array('modRencanaDetailKeb'=>$modRencanaDetailKeb,'modRencanaKebFarmasi'=>$modRencanaKebFarmasi));
                                                    }
                                            }
                                            ?>
                                            <tfoot>
                                                    <tr>
                                                            <td colspan="15">Total</td>
                                                            <td><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::textField('total','',array('class'=>'span2 integer-decimal','style'=>'width:90px;', 'readonly'=>true)):CHtml::passwordField('total','',array('class'=>'span2 integer-decimal','style'=>'width:90px;', 'readonly'=>true));?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>                                                            
                                                    </tr>
                                            </tfoot>
                                        </tbody>
                                    </table>
                                </div>  
                                <?php isset($_GET['ubah'])? $modRencanaKebFarmasi->rencanakebfarmasi_id = '' : '' ; ?>
                            </div>
                        </div>
                    </div>
                </div>	
				<div class="row-fluid">
					<div class="form-actions">
						<?php 
							if(!isset($_GET['sukses'])){
								echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();')); //formSubmit(this,event)
								echo "&nbsp;";
			//              Jika tanpa CekObat();
			//                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
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
			//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4043*/
							}else{
								echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
								echo "&nbsp;";
			//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4043*/
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
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi)); ?>
  

