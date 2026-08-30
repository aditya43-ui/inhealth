<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - menampilkan detail data
* RSST-1620
*/


?>

<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Pengeluaran Aset</div>
	</div>
	<div class="panel-body">
            <?php  echo CHtml::beginForm(); ?>
		<div class="row-fluid">
			
			<div class="col-sm-6">
                            <div class="control-group">
                                <div class="col-sm-3">
                                    <?php echo CHtml::label('Tanggal Pengeluaran','',array('class'=>'control-label')); ?>
                                </div>
                                <div class="col-sm-3">
                                    <div class="controls">	
                                        <?php echo CHtml::activeTextField($model,'tglpengeluaranaset',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                </div>    
			    </div>
                        </div>
                    <div class="col-sm-6">
                            <div class="control-group">
                                <div class="col-sm-3">
                                	<?php echo CHtml::label('Kode Lokasi','',array('class'=>'control-label')); ?>
                                </div>
                                <div class="col-sm-3">
                                    <div class="controls">

                                            <?php echo CHtml::activeTextField($model,'kd_lokasi_kode',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                </div>   
                            </div>
                    </div>
                    <div class="col-sm-6">
                            <div class="control-group">
                                <div class="col-sm-3">
                                	<?php echo CHtml::label('Lokasi Aset','',array('class'=>'control-label')); ?>
                                </div>
                                <div class="col-sm-3">
                                    <div class="controls">

                                            <?php echo CHtml::activeTextField($model,'lokasiaset_kode',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6">
                            <div class="control-group">
                                    <div class="col-sm-3">
                                	<?php echo CHtml::label('Lokasi Penerimaan','',array('class'=>'control-label')); ?>
                                    </div>
                                <div class="col-sm-3">
                                    <div class="controls">

                                            <?php echo CHtml::activeTextField($model,'lokasipenerima_kode',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                            </div>
                    </div> 
                    <div class="col-sm-6">
                             <div class="control-group">
                                    <div class="col-sm-3">
                                	<?php echo CHtml::label('Ruangan Aset','',array('class'=>'control-label')); ?>
                                    </div>
                                 <div class="col-sm-3">
                                    <div class="controls">

                                             <?php echo CHtml::activeTextField($model,'ruangan_nama',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                </div>     
                            </div>
                    </div> 
                    <div class="col-sm-6">
                            <div class="control-group">
                                    <div class="col-sm-3">
                                	<?php echo CHtml::label('Penerimaan Barang','',array('class'=>'control-label')); ?>
                                    </div>
                                <div class="col-sm-3">
                                    <div class="controls">

                                            <?php echo CHtml::activeTextField($model,'penerimaaset',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                            </div>
                    </div> 
                    <div class="col-sm-6">
                            <div class="control-group">
                                    <div class="col-sm-3">
                                	<?php echo CHtml::label('Jenis/Peruntukan','',array('class'=>'control-label')); ?>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="controls">
                                        
                                        <?php echo CHtml::activeTextField($model,'jenisperuntukan',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>    
                                </div>
                            </div>
                    </div> 
                    <div class="col-sm-6">
			    <div class="control-group">
                                        <div class="col-sm-3">
                                            <?php echo CHtml::label('Pengawai Mengeluarkan','',array('class'=>'control-label')); ?>
					</div>
                                    <div class="col-sm-3">
                                         <div class="controls">
						<?php echo CHtml::activeTextField($model,'pengeluaran_nama',array('readonly'=> true,'class'=>'span3')); ?>
					</div>
                                    </div>
							
                            </div>
                        </div>
                    <div class="col-sm-6">
                                <div class="control-group">
                                        <div class="col-sm-3">
                                            <?php echo CHtml::label('Pengawai Menyetujui','',array('class'=>'control-label')); ?>
					</div>
                                        <div class="col-sm-3">
                                        <div class="controls">
						<?php echo CHtml::activeTextField($model,'mengetahui_nama',array('readonly'=> true,'class'=>'span3')); ?>
					</div>
                                        </div>
				</div>
                    </div>    
                        <div class='col-sm-6'>
                            <div class="control-group">
                                    <div class="col-sm-3">
                                	<?php echo CHtml::label('Nomor Pengeluaran','',array('class'=>'control-label')); ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="controls">

                                        <?php echo CHtml::activeTextField($model,'nopengeluaranaset',array('readonly'=> true,'class'=>'span3')); ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="control-group">
                                    <div class="col-sm-3">
                                	<?php echo CHtml::label('Surat Perintah','',array('class'=>'control-label')); ?>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="controls">
                                        
                                        <?php echo CHtml::activeTextField($model,'no_suratperintah',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                             <div class="control-group ">
                                        <div class="col-sm-3">
                                            <?php echo CHtml::label('Tanggal Surat Perintah','',array('class'=>'control-label')); ?>
                                         </div>
                                        <div class="col-sm-3"> 
                                            <div class="controls">
                                                   <?php echo CHtml::activeTextField($model,'tglsuratperintah',array('readonly'=> true,'class'=>'span3')); ?>
                                            </div>
                                        </div>
			    </div>
                        </div> 
                    <div class='col-sm-6'>
                             <div class="control-group ">
                                        <div class="col-sm-3">
                                            <?php echo CHtml::label('Tanggal Penyerahan','',array('class'=>'control-label')); ?>
					</div>
                                        <div class="col-sm-3"> 
                                            <div class="controls">

                                                <?php echo CHtml::activeTextField($model,'tglpenyerahan',array('readonly'=> true,'class'=>'span3')); ?>
                                            </div>
                                        </div>    
			    </div>
                    </div> 
                    <div class='col-sm-6'>
                            <div class="control-group">
                                    <div class="col-sm-3">
                                        <?php echo CHtml::label('Alasan','',array('class'=>'control-label')); ?>
                                    </div>
                                <div class="col-sm-3"> 
                                    <div class="controls">

                                            <?php echo CHtml::activeTextField($model,'alasan_pengeluaran',array('readonly'=> true,'class'=>'span3')); ?>
                                    </div>
                                    </div>
                            </div>
                    </div>    
                            <?php echo CHtml::endForm(); ?>
                        </div>
                        </div>
		</div>
	</div>
<div class="panel panel-primary panel-success">
	<div class="panel-heading">
            <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Tabel Data Aset</div>
	</div>
	<div class="panel-body">
				
		<div class="panel panel-primary panel-success">
			<div class="panel-body table-responsive">
				<?php $this->renderPartial($this->path_view.'_tableDetailPengeluaranAset', array('modDetail'=>$detail)); ?>
			</div>
		</div>
	</div>
</div>


