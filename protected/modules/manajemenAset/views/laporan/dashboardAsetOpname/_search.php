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
            
     <div class="row-fluid">
         <div class="col-sm-1">
             &nbsp;
         </div>         
        <label class="col-sm-2">Periode Opname</label>             
        <div class="col-sm-6"><?= $form->dropDownList($model,'periodeasetopname_id', CHtml::listData(PeriodeasetopnameK::model()->findAllByAttributes([],[
            'order'=>'tanggal_akhir DESC'
        ]), 'periodeasetopname_id', 'periodeasetopname_nama'), ['class'=>'form-control periodeasetopname_id col-sm-12']) ?></div>
        <div class="col-sm-2">
            <?= CHtml::button("Cari",['class'=>'btn btn-danger', 'onclick'=>'cariData();']) ?>
            <?= '&nbsp;' ?>
            <?= CHtml::button("Ulang",['class'=>'btn btn-default', 'onclick'=>'resetData();']) ?>
        </div>         
        <div class="col-sm-1">
            &nbsp;
        </div>
     </div>
    
<?php $this->endWidget(); ?>