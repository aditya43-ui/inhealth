<?php

/**
 * digunakan untuk pencarian
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
?>
<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'search-laporan',
        'type' => 'horizontal',
    )); ?>
    <style>
        #penjamin label.checkbox {
            width: 200px;
            display: inline-block;
        }

        label.checkbox,
        label.radio {
            width: 260px;
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
            <?php
            echo CHtml::hiddenField('filter', 'status', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Status', 'status', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'status', array('2' => 'Belum Kedaluwarsa', '1' => 'Sudah Kedaluwarsa'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                ' . CHtml::label('Instalasi dan Ruangan', 'carabayar_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>
            <div class="control-group">
                ' . CHtml::label('Ruangan', 'ruangan', array('class' => 'control-label')) . ' 
                <div class="controls">												 
                    ' . $form->dropDownList(
                    $model,
                    'ruangan_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                </div>
            </div>';
            ?>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'status',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Status',
                        'isi' => CHtml::hiddenField('filter', 'status', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                    ' . CHtml::label('Status', 'status', array('class' => 'control-label')) . ' 
                                    <div class="controls">
                                        ' . $form->dropDownList($model, 'status', array('2' => 'Belum Kedaluwarsa', '1' => 'Sudah Kedaluwarsa'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                    </div>
                                </div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'isntalasidanruangan',
                'slide' => true,
                'content' => array(
                    'content3' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Instalasi dan Ruangan',
                        'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                            '<div class="control-group">
									' . CHtml::label('Instalasi dan Ruangan', 'carabayar_id', array('class' => 'control-label')) . ' 
									<div class="controls">
										' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
									</div>
								</div>
								<div class="control-group">
									' . CHtml::label('Ruangan', 'ruangan', array('class' => 'control-label')) . ' 
									<div class="controls">												 
										' . $form->dropDownList(
                                $model,
                                'ruangan_id',
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
    </div>-->
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('obatAlkesKadaluarsa'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#search-laporan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#search-laporan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>