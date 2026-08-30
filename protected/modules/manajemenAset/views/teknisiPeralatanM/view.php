<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Teknisi Peralatan</b></div>
    </div>
    <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Teknisi Peralatan'=>array('index'),
					$model->teknisiperalatan_id,
				);
				$arrMenu = array();    
				$this->menu=$arrMenu;
                
                $pendidikan = PendidikanM::model()->findByPk($model->pendidikan_id);
                if($pendidikan != NULL){
                    $nama_pendidikan = $pendidikan->pendidikan_nama;
                }else{
                    $nama_pendidikan  = "-";
                }
                
                $kabupaten = KabupatenM::model()->findByPk($model->kabupaten_id);
                if($kabupaten != NULL){
                    $nama_kabupaten = $kabupaten->kabupaten_nama;
                }else{
                    $nama_kabupaten  = "-";
                }
                
                $supplier = SupplierM::model()->findByPk($model->supplier_id);
                if($supplier != NULL){
                    $nama_supplier = $supplier->supplier_nama;
                }else{
                    $nama_supplier  = "-";
                }
                
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						'teknisiperalatan_id',
						'namateknisi',
						'jeniskelamin',
						'tempatlahir',
                        array(
                            'label'=>'Tanggal Lahir',
                            'type'=>'raw',
                            'value'=>MyFormatter::formatDateTimeforUser($model->tgllahir),
                        ),
						array(
                            'label'=>'Pendidikan',
                            'type'=>'raw',
                            'value'=>$nama_pendidikan,
                        ),
                        'statusperkawinan',
                        array(
                            'label'=>'Domisili',
                            'type'=>'raw',
                            'value'=>$nama_kabupaten,
                        ),
                        'alamat_teknisi',
                        'no_kontak_teknisi',
                        array(
                            'label'=>'Supplier',
                            'type'=>'raw',
                            'value'=>$nama_supplier,
                        ),
					),
				)); ?>
                <div class="block-tabel" >
                    <table class="items table table-bordered table-striped table-condensed" id="table-sertifikat">
                        <thead>
                            <tr>
                                <th>No Sertifikat</th>
                                <th>Nama Sertifikat</th>
                                <th>Keterangan</th>
                                <th>Berlaku Sampai</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count($modSertifikat) > 0){
                                foreach($modSertifikat AS $i=> $modDetail){
                                    $modDetail->berlaku_sd = MyFormatter::formatDateTimeForUser($modDetail->berlaku_sd);
                                    echo $this->renderPartial($this->path_view.'_rowDetailView',array('modSertifikat'=> $modDetail));
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
        <div class="form-actions">
				<?php 
				echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Teknisi Peralatan', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
				$this->widget('UserTips',array('type'=>'view'));
				?>
            </div>
            </div>
        </div>    
