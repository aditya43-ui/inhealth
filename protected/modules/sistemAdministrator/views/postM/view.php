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
        <div class="panel-title">Detail<b> Post Berita</b></div>
    </div>
    <div class="panel-body">

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'post_judul',
                    'type' => 'raw',
                    'value' => $model->post_judul,
                ),
                array(
                    'name' => 'post_tgl',
                    'value' => MyFormatter::formatDateTimeForUser(date("d-M-Y", strtotime($model->post_tgl))),
                    'htmlOptions' => array('width' => '100', 'style' => 'text-align:center'),
                    'headerHtmlOptions' => array('style' => 'vertical-align:top;text-align:center;color:#373e4a;'),
                ),
                array(
                    'name' => 'post_desc',
                    'type' => 'raw',
                    'value' => $model->post_desc,
                ),
                array(
                    'name' => 'gambar_post',
                    'type' => 'raw',
                    'value' => (isset($model->post_gambar) ? '<img src="' . Params::urlBeritaGambar() . $model->post_gambar . '" width="200px" height="200px;">' : '<i>gambar belum diset</i>'),
                ),
                array(
                    'label' => 'kategori',
                    'name' => 'kategoripost_id',
                    'type' => 'raw',
                    'value' => $model->kategoripost->kategoripost_nama,
                ),
                array(
                    'label' => 'Login Pemakai',
                    'type' => 'raw',
                    'value' => $model->loginpemakai,
                ),
                array(// related city displayed as a link
                    'name' => 'post_aktif',
                    'type' => 'raw',
                    'value' => (($model->post_aktif == 1) ? "Aktif" : "Tidak Aktif"),
                ),
            ),
        ));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Post Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>