<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Verifikasi Operasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 580,
        'height' => 230,
        'resizable' => false,
    ),
));
 
 echo '<div class="form-horizontal" style="padding:10px;">';
    echo '<div class="control-group">';
       echo '<label class="controls">Rencana operasi ini dilakukan pada tanggal </label>';
       echo '<div class="controls">';
       $this->widget('MyDateTimePicker', array(
              'name' => 'tglrencanaoperasi',
              'mode' => 'datetime',
              'options' => array(
                  'dateFormat' => Params::DATE_FORMAT,
                  // 'maxDate' => 'd',
              ),
              'htmlOptions' => array('readonly' => true, 'class'=>'required','id'=>'settglrencanaoperasi'),
        ));
       echo '</div>';
    echo '</div>';
    echo '<div class="control-group">';
       echo '<label class="controls">dengan no pendaftaran <b>'.$modPendaftaran->no_pendaftaran.'</b></label>';  
    echo '</div>';
    echo '<div class="form-actions">';
       echo CHtml::htmlButton("Ya",['class'=>'btn btn-success btn-sm','onclick'=>'setTglRencana();']);
       echo CHtml::htmlButton("Tidak",['class'=>'btn btn-gray btn-sm','onclick'=>'resetVerifikasi();']);
    echo '</div>';
 echo '</div>';
 
 
$this->endWidget();