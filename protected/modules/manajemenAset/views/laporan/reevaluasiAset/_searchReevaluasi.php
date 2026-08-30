<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchReevaluasi',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        #ruangan label{
            width: 120px;
            display:inline-block;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
    </style>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian</div>
        </div>
        <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class='control-group hari'>
                    
                    <div class="control-group">
                        <?php echo CHtml::label('Tanggal Re-evaluasi', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            ?>
        </div>
        </div>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
