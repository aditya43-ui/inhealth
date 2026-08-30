<?php

/**
 * digunakan untuk modul portal rs informasi STR dan SIP
 * RSST-2875
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'str-r-search',
    'type' => 'horizontal',
));
$format = new MyFormatter();
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Periode Laporan", 'tanggal_akhir_sk', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tanggalawal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tanggalakhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tanggalawal)) ?> - <?php echo date('d M Y', strtotime($model->tanggalakhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tanggalawal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tanggalakhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div id='searching'>
            <?php
            echo '<div class="control-group">                                            
                <label class="control-label">Jenis Pemeriksaan</label>
                <div class="controls">
                        ' . $form->dropDownList($model, 'tipe', array('PC' => 'Pemeriksaan Checkup ', 'PP' => 'Pemeriksaan Penunjang'), array('onchange' => 'cekform()')) . '<br>
                </div>                
        </div>';
            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'tipe',
            //     'slide' => true,
            //     'content' => array(
            //         'content1' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Kunjungan Pemeriksaan',
            //             'isi' => '<div class="control-group">                                            
            //                                     <label class="control-label">Jenis Pemeriksaan</label>
            //                                     <div class="controls">
            //                                             ' . $form->dropDownList($model, 'tipe', array('PC' => 'Pemeriksaan Checkup ', 'PP' => 'Pemeriksaan Penunjang'), array('onchange' => 'cekform()')) . '<br>
            //                                     </div>                
            //                             </div>',
            //             'active' => true,
            //         ),
            //     ),
            //     //                                    'htmlOptions'=>array('class'=>'aw',)
            // ));
            ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
</div>
<?php $this->endWidget(); ?>