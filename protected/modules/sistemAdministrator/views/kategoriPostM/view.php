<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Detail<b> Kategori Berita</b></div>
    </div>
    <div class="panel-body">

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Kategori Post',
                    'name' => 'kategoripost_nama',
                    'type' => 'raw',
                    'value' => $model->kategoripost_nama,
                ),
                array(
                    'label' => 'Nama Lainnya',
                    'name' => 'kategoripost_namalain',
                    'type' => 'raw',
                    'value' => $model->kategoripost_namalain,
                ),
                array(
                    'label' => 'Gambar kategori Post',
                    'name' => 'kategoripost_gambar',
                    'type' => 'raw',
                    'value' => (isset($model->kategoripost_gambar) ? '<img src="' . Params::urlKategoriBeritaGambar() . $model->kategoripost_gambar . '" width="200px" height="200px;">' : '<i>gambar belum diset</i>'),
                ),
                array(
                    'label' => 'Status',
                    'name' => 'kategoripost_aktif',
                    'type' => 'raw',
                    'value' => (($model->kategoripost_aktif == 1) ? "Aktif" : "Tidak Aktif"),
                ),
            ),
        ));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kategori Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>