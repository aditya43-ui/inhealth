<?php
$this->breadcrumbs = array(
    'Petunjuktransaksi Ms' => array('index'),
    $model->petunjuktransaksi_id,
);
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Lihat <b> Petunjuk Transaksi </b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <div class="row-fluid">
                <div class="span6">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th> Tipe</th>
                            <td> <?= $model->petunjuktransaksi_type?> </td>
                        </tr>
                        <tr>
                            <th> Nama </th>
                            <td> <?= $model->petunjuktransaksi_nama?> </td>
                        </tr>
                        <tr>
                            <th> Deskripsi </th>
                            <td> <?= $model->petunjuktransaksi_deskripsi?> </td>
                        </tr>
                        <tr>
                            <th> Gambar </th>
                            <td> <?php 
                            $img = "";
                                if (empty($model->petunjuktransaksi_image)) {
                                    $img = "";
                                } else {
                                    if (file_exists(Params::pathPetunjukTransaksiDirectory() . $model->petunjuktransaksi_image)) {
                                        $img = Params::urlPetunjukTransaksiDirectory() . $model->petunjuktransaksi_image;
                                    } else {
                                        $img = Params::urlPetunjukTransaksiDirectory() . "no_photo.jpeg";
                                    }
                                }
                                echo '<img src="' . $img . '" height="200" width="200">';
                            ?> </td>
                        </tr>
                        <tr>
                            <th> Aktif </th>
                            <td> <?= ($model->petunjuktransaksi_aktif == 1 ) ? "Aktif" : "Tidak Aktif" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->petunjuktransaksi_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Petunjuk Penggunaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>
