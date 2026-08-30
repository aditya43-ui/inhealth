<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Bed Triage</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Bed Triage' => array('admin'),
                    $model->bed_triage_id,
                );

                $arrMenu = array();
                $this->menu = $arrMenu;

                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                                array(
                                    'label' => 'ID',
                                    'type' => 'raw',
                                    'value' => (isset($model->bed_triage_id) ? $model->bed_triage_id : ""),
                                ),
                                array(
                                    'label' => 'No. Bed',
                                    'type' => 'raw',
                                    'value' => (isset($model->no_bed) ? $model->no_bed : ""),
                                ),
                                array(
                                    'label' => 'Keterangan',
                                    'type' => 'raw',
                                    'value' => (isset($model->keterangan) ? $model->keterangan : ""),
                                ),
                                array(
                                    'label' => 'Aktif',
                                    'type' => 'raw',
                                    'value' => (($model->is_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                                ),
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="col-sm-12">
                    <br>
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bed Triage', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
                    ?>
                    <?php $this->widget('UserTips', array('type' => 'view')); ?>
                </div>
            </div> 
        </div> 
    </div> 
</div> 
