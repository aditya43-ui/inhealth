<?php

$modPpds = new PpdsM();
$modPpds->unsetAttributes();

if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}

$x=1;
?>
<tr class="no-row">
    <td class="nomor">
        <?php echo CHtml::activeHiddenField($model, 'ppds_id', array('readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
  <?php echo $model->urutan_ppds = $x++;  ?>
      </td>
    <td class="ppds">
    <?php 
    echo CHtml::activeHiddenField($modPpds, '[i]ppds_id');
    $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPpds,
                                'attribute' => '[i]ppds_nama',
                                'name'=>'ppds_nama',
                                'sourceUrl' => Yii::app()->createUrl('rawatJalan/DaftarPasien/AutoPPDS'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.value);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) { 
                                        setDaftar(ui.item, this);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Nama PPDS',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'ppds_nama span4 required',
                                    'onblur'=>'if(this.value==""){clearDaftarHasil(this);}'
                                ),
                                'tombolDialog' => array(
                                    'idDialog' => 'dialogPPPDS',
                                    'jsFunction' => 'setValuePPDS(this);setRow(this);$("#dialogPPPDS").dialog("open");'
                                ),
                            ));
                             ?>
    </td>
    <td style="width: 120px; text-align: center;" class="rowbutton">
   
    <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary','id'=>'minus', 'onclick' => 'hapusBaris(this)')); ?>
     <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahBaris()')); ?>
        
    </td>
</tr>
