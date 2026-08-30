<div class="white-container">
    <legend class="rim2">Lihat <b>Obat Supplier</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Obat Supplier Ms' => array('index'),
        $model->supplier_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Obat Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Supplier', 
    //                            'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'label' => 'ID Supplier',
                'type' => 'raw',
                'value' => $model->supplier_id,
            ),
            array(
                'label' => 'Kode',
                'type' => 'raw',
                'value' => $model->supplier_kode,
            ),
            array(
                'label' => 'Nama',
                'type' => 'raw',
                'value' => $model->supplier_nama,
            ),
            array(
                'label' => 'Alamat',
                'type' => 'raw',
                'value' => $model->supplier_alamat,
            ),
        ),
    )); ?>
    <div class='block-tabel'>
        <h6>Data <B>Obat Supplier</b></h6>
        <table width='100%' class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama Obat Alkes</th>
                    <th>Satuan Besar</th>
                    <th>Satuan Kecil</th>
                    <th>Harga Beli <br> Satuan Besar</th>
                    <th>Harga Beli <br> Satuan Kecil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($modSupplier as $i => $obat) {
                ?>
                    <tr>
                        <td><?php echo (isset($obat->obatalkes->obatalkes_nama) ? $obat->obatalkes->obatalkes_nama : ""); ?></td>
                        <td><?php echo (isset($obat->satuanbesar->satuanbesar_nama) ? $obat->satuanbesar->satuanbesar_nama : ""); ?></td>
                        <td><?php echo (isset($obat->satuankecil->satuankecil_nama) ? $obat->satuankecil->satuankecil_nama : ""); ?></td>
                        <td><?php echo (isset($obat->hargabelibesar) ? $obat->hargabelibesar : ""); ?></td>
                        <td><?php echo (isset($obat->hargabelikecil) ? $obat->hargabelikecil : ""); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Obat Supplier', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl(
                Yii::app()->controller->id . '/admin',
                array('modul_id' => Yii::app()->session['modul_id'])
            ),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>