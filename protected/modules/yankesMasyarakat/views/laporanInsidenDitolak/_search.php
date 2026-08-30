<div class="search-form"> 
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'laporan-insidenditolak-search',
        'type' => 'horizontal',
    ));
    ?>

    <div class="row-fluid">
        <div class="col-md-6">
            <div class="row-fluid">
                <div class="control-group">		
                    <?php echo CHtml::label("Periode Laporan", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('type', ''); ?>

                        <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div id='searching'>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'instalasi',
                    'slide' => true,
                    'content' => array(
                        'content4' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Instalasi dan Ruangan',
                            'isi' => 
                            '<div class="control-group">
                                            ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                                            <div class="controls">
                                                ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple')) . '											
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
                                            <div class="controls">												 
                                                ' . $form->dropDownList($model, 'ruangan_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . ' 													
                                            </div>
                                        </div>',
                            'active' => true,
                        ),
                    ),
                ));
                ?>	
            </div> 
        </div>
        <div class="col-sm-6">
            <div id='searching'>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'grafiknya',
                    'content' => array(
                        'content3' => array(
                            'header' => 'Berdasarkan Kategori Penolakan',
                            'isi' => CHtml::hiddenField('filter', 'pilih', array('disabled' => 'disabled')) .
                                    '<table>
                                        <tr>
                                            <td>' .
                                            $form->dropDownList($model, 'kategoripenolakan', LookupM::getItems("kategoripenolakan"), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) 
                                            .'</td>'
                                        . '</tr>'
                                    . '</table>',
                            'active' => true,
                        ),),
                ));
                ?>                               
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->renderPartial('_jsFunctions', array('model' => $model));
?>