<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rjruanganpegawai-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        // $ruanganid = Yii::app()->user->ruangan_id;
        // if ($ruanganid != 1) {
        //     $modruangan = RuanganM::model()->findByPK($ruanganid);
        //     echo CHtml::hiddenField('ruanganid', $ruanganid, array('readonly' => false));
        //     echo $form->textFieldRow($model, 'ruangan_nama', array('value' => $modruangan->ruangan_nama, 'readonly' => false, 'class' => 'span3',));
        // }
        ?>
       <?php
       $ruanganid = Yii::app()->user->ruangan_id;
        if (empty($model->ruangan_id)) {
            $model->ruangan_id = $ruanganid;
        }
        
       echo $form->dropDownListRow(
            $model,
            'ruangan_id',
            Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),
            array(
                'empty' => '-- Pilih --',
                'id'=>'ruangan_id',
                'class' => 'span3 required',
                'maxlength' => 50
            )
        );
      
        
        ?>
        <?php echo $form->textFieldRow(
            $model,
            'nama_pegawai',
            array(
                'class' => 'span3',
                'placeholder' => 'Nama Pegawai'
            )
        ) ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'title' => 'Cari',
            'onclick'=>'validateDropdownListRow();'
        )
    ); ?>
<!-- <?php 
//    echo CHtml::link(
//     Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
//     Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
//     array(
//         'title' => 'Ulang',
//         'class' => 'btn btn-default',
//         'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
//     )
// ); ?> -->
</div>
<script>
    function validateDropdownListRow() {
  var dropdownList = document.getElementById("ruangan_id");
  if (dropdownList.value == "") {
    myAlert("Mohon Untuk Memilih Ruangan Terlebih Dahulu.");
    return false;
  }
  return false;
}
    </script>
<?php $this->endWidget(); ?>