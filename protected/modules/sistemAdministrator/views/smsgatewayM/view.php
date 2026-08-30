<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>SMS Gateway</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'SMS Gateaway' => array('view', 'id' => $model->smsgateway_id),
            $model->smsgateway_id,
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'smsgateway_id',
                        'modul_id',
                        'tujuansms',
                        'jenissms',
                        'formatsms',
                        'jmlkaraktersms',
                        'katawalsms',
                        //'kataakhirsms',
                        //'ishurufkapital',
                        //'modcontroller',
                        //'modaction',
                        //'templatesms',
                        //'statussms',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'smsgateway_id',
                        //'modul_id',
                        //'tujuansms',
                        //'jenissms',
                        //'formatsms',
                        //'jmlkaraktersms',
                        //'katawalsms',
                        'kataakhirsms',
                        'ishurufkapital',
                        'modcontroller',
                        'modaction',
                        'templatesms',
                        'statussms',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->smsgateway_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Smsgateway', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>