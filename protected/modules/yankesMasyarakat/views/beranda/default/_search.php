<?php
/**
 * mencari data
 * issue RSST-2430
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'orientasi-r-search',
        'type' => 'horizontal',
    ));
    $format = new MyFormatter();
    ?>

    
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6" >
            <div class="control-group">		
                <?php echo CHtml::label("Periode", 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline setIndikator" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y') ?>" data-end-date="<?php echo date('F d, Y') ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('F d, Y') ?> - <?php echo date('F d, Y') ?></span>
                        <?php echo CHtml::activeHiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo CHtml::activeHiddenField($model,'tgl_akhir',  array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
    
<?php $this->endWidget(); ?>