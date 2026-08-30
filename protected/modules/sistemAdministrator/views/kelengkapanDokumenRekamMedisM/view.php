<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelengkapan Dokumen</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Instalasi' => array('view', 'id' => $model->kelengkapandokumen_rm_id),
            $model->kelengkapandokumen_rm_id,
        );

        $arrMenu = array();
        
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jenisdokumen',
                'nama_dokumen',
                'urutan_dokumen',
                'level_dokumen',
                array(               // related city displayed as a link
                    'name' => 'kelengkapandokumen_aktif',
                    'type' => 'raw',
                    'value' => (($model->kelengkapandokumen_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kelengkapan Dokumen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('kelengkapanDokumenRekamMedisM/index', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>