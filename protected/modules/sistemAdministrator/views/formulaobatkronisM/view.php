<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Formula Obat Kronis</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pabrik Farmasi' => array('admin'),
            $model->formulaobatkronis_id,
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'formulaobatkronis_id',
                        'jumlahobat', 
                        'jumlahobat_minimal', 
                        'jumlahobat_maksimal',
                        array(
                            'name' => 'is_aktif',
                            'type' => 'raw',
                            'value' => (($model->is_aktif) ? "Aktif" : "Tidak Aktif"),
                        ),
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                // $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                //     'data' => $model,
                //     'attributes' => array(

                       
                //     ),
                // ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->formulaobatkronis_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Pabrik', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>