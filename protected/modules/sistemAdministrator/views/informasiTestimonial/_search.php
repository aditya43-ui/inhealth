<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasipegawailogin-v-search',
    'type' => 'horizontal',
    //	'focus'=>'#'.CHtml::activeId($model,'nomutasibrg'),
));
$format = new MyFormatter();
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pencarian</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal</label>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Status Verifikasi</label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'is_publish', array('empty' => '--- Pilih ---', true => 'Publish', false => 'Unpublish')) ?>
                        <!-- <select class="form-control"> -->
                        <!-- 
                           <option value="">--- Pilih ---</option>
                           <option value="true">Publish</option>
                           <option value="false">Un Publish</option>
                       </select> -->
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="fa fa-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="fa fa-refresh"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-danger',
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang data ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                ); ?>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#informasipegawailogin-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
                <?php
                $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>