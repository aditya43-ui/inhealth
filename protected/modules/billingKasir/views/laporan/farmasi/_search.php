<style>
    td label.checkbox {
        width: 150px;
        display: inline-block;

    }

    .checkbox.inline+.checkbox.inline {
        margin-left: 0;
    }
</style>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        table {
            margin-bottom: 0;
        }

        .form-actions {
            padding: 4px;
            margin-top: 5px;
        }

        #ruangan label {
            width: 120px;
            display: inline-block;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo $form->hiddenField($model, 'filter_tab'); ?>
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
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="row" id="carabayar">
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'carabayar',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Jenis Penjamin',
                        'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                               ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                               <div class="controls">
                                   ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                               </div>
                           </div>
                           <div class="control-group">
                               ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                               <div class="controls">												 
                                   ' . $form->dropDownList(
                                $model,
                                'penjamin_id',
                                array(),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ) . '
                               </div>
                           </div>',
                        'active' => true,
                    ),
                ),
                //                                    'htmlOptions'=>array('class'=>'aw',)
            ));
            ?>
        </div>
    </div>
    <div class="form-actions">
        <div style="float:left;margin-right:6px;">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')
            ); ?>
        </div>
        <!--<div style="float:left;margin-right:6px;">            
    </div>-->
        <div style="clear:both;"></div>
    </div>
</div>
<?php
$this->endWidget();
?>
<script type="text/javascript">
    function cek_all_penjamin(obj) {
        if ($(obj).is(':checked')) {
            $("#penjamin").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#penjamin").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }

    function checkAll(obj) {
        if ($(obj).is(':checked')) {
            $("#penjamin").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#penjamin").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>