<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        #penjamin label.checkbox {
            width: 100px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Status Bayar</label>
                <div class="controls">
                    <?php echo $form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

            <!--<div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Berdasarkan Status Bayar
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    echo '<table>
                        <tr>
                            <td>
                                <div class="penjamin">' .
                        $form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
                                </div>
                            </td>
                        </tr>
                    </table>';
                    ?>
                </div>
            </div>-->
        </div>

        <div class="col-sm-6">
            <!--<div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Berdasarkan Jenis Penjamin
                    </div>
                </div>
                <div class="panel-body">-->
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $model,
                                'penjamin_id',
                                array(),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ); ?>
                        </div>
                    </div>
                <!--</div>
            </div>-->
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        ));
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>