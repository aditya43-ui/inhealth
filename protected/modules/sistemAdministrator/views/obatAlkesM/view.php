<?php
$modZatAktif = ObatalkeszataktifM::model()->findAllByAttributes(array(
    'obatalkes_id'=>$model->obatalkes_id,
));

$zatAktif = "-";
if (count((array)$modZatAktif) > 0) {
    $zatAktif = "<ul>";
    foreach ($modZatAktif as $item) {
        $zatAktif .= "<li>".$item->obatalkeszataktif_nama."</li>";
    }
    $zatAktif .= "</ul>";
}

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Obat Alkes</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Obat Alkes'=>array('admin'),
					$model->obatalkes_id,
				);

				$arrMenu = array();
				//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
				//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAObatalkesM', 'icon'=>'list', 'url'=>array('index'))) ;
				//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAObatalkesM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
				//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAObatalkesM', 'icon'=>'pencil','url'=>array('update','id'=>$model->obatalkes_id))) :  '' ;
				//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAObatalkesM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->obatalkes_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
				//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Alkes', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

				$this->menu=$arrMenu;

				$this->widget('bootstrap.widgets.BootAlert'); ?>
                <div class="col-sm-6">
				<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						array(
						  'label'=>'ID',
						  'type'=>'raw',
						  'value'=>(isset($model->obatalkes_id) ? $model->obatalkes_id : ""),
						),

						array(
						   'label'=>'Kode Obat Alkes',
						   'type'=>'raw',
						   'value'=>(isset($model->obatalkes_kode) ? $model->obatalkes_kode : ""),
						),
						array(
						   'label'=>'Nama Obat Alkes',
						   'type'=>'raw',
						   'value'=>(isset($model->obatalkes_nama) ? $model->obatalkes_nama : ""),
						),

						array(
						   'label'=>'Harga Netto',
						   'type'=>'raw',
						   'value'=>(isset($model->harganetto) ? $model->harganetto : ""),
						),
						array(
						   'label'=>'Harga Jual',
						   'type'=>'raw',
						   'value'=>(isset($model->hargajual) ? $model->hargajual : ""),
						),
						array(
						   'label'=>'Keringanan',
						   'type'=>'raw',
						   'value'=>(isset($model->discount) ? $model->discount : ""),
						),
						array(
						   'label'=>'Tgl. Kadaluarsa',
						   'type'=>'raw',
						   'value'=>(isset($model->tglkadaluarsa) ? $model->tglkadaluarsa : ""),
						),
						array(
						   'label'=>'Lokasi Gudang',
						   'type'=>'raw',
						   'value'=>(isset($model->lokasigudang->lokasigudang_nama) ? $model->lokasigudang->lokasigudang_nama : ""),
						),
						array(
						   'label'=>'Generik',
						   'type'=>'raw',
						   'value'=>(isset($model->generik->generik_nama) ? $model->generik->generik_nama : ""),
						),
						array(
						   'label'=>'Satuan Besar',
						   'type'=>'raw',
						   'value'=>(isset($model->satuanbesar->satuanbesar_nama) ? $model->satuanbesar->satuanbesar_nama : ""),
						),
						array(
						   'label'=>'Satuan Kecil',
						   'type'=>'raw',
						   'value'=>(isset($model->satuankecil->satuankecil_nama) ? $model->satuankecil->satuankecil_nama : ""),
						),
						array(
						   'label'=>'Asal Barang',
						   'type'=>'raw',
						   'value'=>(isset($model->sumberdana->sumberdana_nama) ? $model->sumberdana->sumberdana_nama : ""),
						),
						array(
						   'label'=>'Jenis Obat Alkes',
						   'type'=>'raw',
						   'value'=>(isset($model->jenisobatalkes->jenisobatalkes_nama) ? $model->jenisobatalkes->jenisobatalkes_nama : ""),
						),
						array(
							'label'=>'Sub Jenis',
							'type'=>'raw',
							'value'=>(isset($model->subjenis->subjenis_nama) ? $model->subjenis->subjenis_nama : ""),
						),
						array(
						   'label'=>'Golongan',
						   'type'=>'raw',
						   'value'=>(isset($model->obatalkes_golongan) ? $model->obatalkes_golongan : ""),
						),
						array(
						   'label'=>'Kategori',
						   'type'=>'raw',
						   'value'=>(isset($model->obatalkes_kategori) ? $model->obatalkes_kategori : ""),
						),
						array(
						   'label'=>'Kadar Obat',
						   'type'=>'raw',
						   'value'=>(isset($model->obatalkes_kadarobat) ? $model->obatalkes_kadarobat : ""),
						),
						array(
						   'label'=>'Kemasan Besar',
						   'type'=>'raw',
						   'value'=>(isset($model->kemasanbesar) ? $model->kemasanbesar : ""),
						),
                        'bentuk_obat',
						'kekuatan',
						'satuankekuatan',
						'minimalstok',
						'formularium',
						'discountinue',
						array(            
							'label'=>'Aktif',
							'type'=>'raw',
							'value'=>(($model->obatalkes_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
						),
                        array(
                            'label'=>'Zat Aktif',
                            'type'=>'raw',
                            'value'=>$zatAktif,
                            'visible'=>$zatAktif != "-",
                        )
					),
				)); ?>
                </div>
				<div class="col-sm-6">
					<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Obat Alkes', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
						$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
					<?php $this->widget('UserTips',array('type'=>'view'));?>
				</div>
            </div>
        </div>
    </div>
</div> 
