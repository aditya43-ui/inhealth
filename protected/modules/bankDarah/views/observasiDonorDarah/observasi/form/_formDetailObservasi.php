<?php
/**
 * -Digunakan untuk menampilkan form detail observasi (disable input)
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1534
 */

?>
<style>
    .bit-box{
        z-index: -10 !important;
    }
    
    .kel-tekanan{
        width:70px !important;
    }
    
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }
</style>
<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Tanggal Penyadapan</label>
        <div class="controls">
            <?php $model->tglmulaiobservasi = $format->formatDateTimeForUser($model->tglmulaiobservasi); ?>
             <?php
                $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglmulaiobservasi',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'
                        ),
                ));
            ?>
        </div>
        <div class="controls">
            <label>Mulai Penyadapan</label>
        </div>
        <div class="controls">
            <div class="input-append">
            <input readonly="readonly" class="span2  hasDatepicker" onkeypress="return $(this).focusNextInputField(event)" style="width:120px;" value="<?php echo date('H:i:s', strtotime($model->tglmulaiobservasi)); ?> " type="text">
                <span id="BDObservasipendonorT_durasi_penyadapan" class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>
        <div class="controls">
            <label>Selesai Penyadapan</label>
        </div>
        <div class="controls">
            <div class="input-append">
                     <input readonly="readonly" class="span2  hasDatepicker" onkeypress="return $(this).focusNextInputField(event)" style="width:120px;" value="<?php echo date('H:i:s', strtotime($model->sd_observasi)); ?> " type="text">
                <span id="BDObservasipendonorT_durasi_penyadapan" class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>
    </div>
    
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="control-group">
        <div class="control-group">
            <label class="control-label">Kelancaran Aliran Darah</label>
            <?php
                $alasan = LookupM::getItems('kelancarandarah');
                $get = array();
                foreach ($alasan as $key => $val){                
                    echo "<div class='controls'>";
                    echo $form->radioButton($model,'kelancarandarah',array('uncheckValue'=>null,'value'=> $key)).'<label>'.$val.'</label>';
                    echo "</div>";
                }                                    
            ?>                
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Keluhan</label>
        <div class="controls">
            <?php echo $form->textArea($model,'keluhan_pendonor',array('disabled'=>true)); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            &nbsp;
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Durasi Penyadapan</label>
        <div class="controls">
            <div class="input-append">
                <?php echo $form->textField($model,'durasi_penyadapan',array('readonly'=>true)) ?>
                <span id="BDObservasipendonorT_durasi_penyadapan" class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>        
    </div>
    
    
</div>
<div class="clear"></div>
<p>&nbsp;</p>

<div class="panel panel-darkk">
    <span class="group-title">
        Tanda Vital
    </span>
    <div class="panel-body" id="tandavital">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?php echo $form->textField($model,'nadi_observasi',array('readonly' => true,'class'=>'span2 numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>x/mnt</label>
                </div>
            </div>                        
            
            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?php echo $form->textField($model,'nadi_observasi',array('readonly' => true,'class'=>'span2 numbers-only')); ?>
                </div>
                <div class="controls">
                    <label><sup>o</sup>C</label>
                </div>
            </div>
            
            <div class="control-group" >
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?php echo $form->textField($model,'td_systolic',array('readonly' => true,'class'=>'kel-tekanan numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>/</label>
                </div>
                <div class="controls">
                    <?php echo $form->textField($model,'td_diastolic',array('readonly' => true,'class'=>'kel-tekanan numbers-only')); ?>
                </div>
                 <div class="controls">
                    <label>mm/Hg</label>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Pernapasan</label>
                <div class="controls">
                    <?php echo $form->textField($model,'pernapasan',array('readonly' => true,'class'=>'span2')); ?>
                </div>
                <div class="controls">
                    <label>x/mnt</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Kesadaran</label>
                <div class="controls">
                    <?php echo $form->textField($model,'kesadaran',array('readonly' => true,'class'=>'span2')); ?>
                </div>               
            </div>
        </div>
    </div>
</div>

<div class="clear">
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Keterangan</label>
        <div class="controls">
            <?php echo $form->textArea($model,'ket_observasi',array('disabled'=>true)); ?>
        </div>
    </div>
</div>
<div class="clear">
</div>
<div class="panel">    
    <div class="panel-body">
        <?php echo $form->checkBox($model,'is_batalpenyadapan',array('disabled'=>true,'onclick'=>'cekBatal(this);')); ?><label>&nbsp;&nbsp;&nbsp;Cek jika penyadapan darah gagal</label>
    </div>
</div>

<div class="clear">
</div>
<div class="panel panel-darkk">
    <span class="group-title">
        Alasan gagal sadap
    </span>
    <?php echo $form->hiddenField($model,'ket_alasanbatal',array('readonly'=>true)); ?>
    <div class="panel-body" id="alasanbatal-sadap">
        <?php
            $alasan = LookupM::getItems('alasanbatal_penyadapan');
            $get = array();
            foreach ($alasan as $key => $val){                
                if (strcmp(strtolower($key),strtolower($val)) != 0){
                    $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['look'] = ucwords(str_replace(strtolower($val), '', strtolower($key))); 
                    $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['val'] = $key; 
                    $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['det'][$key]['name'] = $val; 
                    $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['det'][$key]['value'] =$key; 
                }else{
                    $get[$key]['look'] = $val;                     
                }
            }                                    
        ?>
        <table width="100%" id="alasanbatalcek">
            <?php
                if (!empty($get)){
                    
                    $value = $model->alasanbatal_penyadapan;
                    $ket = $model->ket_alasanbatal;
                    
                    foreach ($get as $look){
                        echo "<div class='control-group'>";                        
                        $st = (strtolower($value) == strtolower($look['look'])?true:false);                        
                        if (isset($look['det'])){
                            
                            echo "<div class='controls'>".CHtml::checkBox('cekPilih',$st,array('disabled'=>true,'class'=>'utama ceklis tidakmasuk haschild','value'=>$look['look'], 'onclick'=>'openChild(this);'))."<label>&nbsp;".$look['look']." :</label></div>";
                            echo "<div class='controls'>";                            
                            foreach($look['det'] as $d){
                                $st = (strtolower($value) == strtolower($d['value'])?true:false);
                                
                                if ($st != true){
                                    $ket = '';                                    
                                }else{
                                    $ket = $model->ket_alasanbatal;
                                }
                                
                                echo "<div class=''>";
                                echo "<div class='col-sm-4'>";
                                echo CHtml::checkBox('cekPilih',$st,array('disabled'=>true,'class'=>'ceklis masuk hasparent','value'=>$d['value'], 'onclick'=>'tambahCeklis(this);'))."<label>&nbsp;".$d['name'];
                                echo "</div>";                                
                                echo '<div class="col-sm-6">'.CHtml::textField('textPilih',$ket,array('disabled'=>true,'class'=>'masuk hasparent','hasil'=>$d['value'],'onblur'=>'inputKeterangan(this);'))."</div>";
                                echo '</label></div>';
                                echo "<div class='clear' style='padding:5px;'></div>";
                                //echo "<br/>";
                            }                            
                            echo "</div>";
                        }else{
                            echo "<div class='controls'>".CHtml::checkBox('cekPilih',$st,array('disabled'=>true,'class'=>'utama ceklis masuk','value'=>$look['look'], 'onclick'=>'tambahCeklis(this);'))."<label>&nbsp;".$look['look']."</label></div>";
                        }
                        echo "</div>";
                    }
                }
            ?>
        </table>
        
        <table width="100%" id="tampungceklis" hidden>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="panel">    
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Waktu Observasi</label>
                <div class="controls">
                    <?php $model->waktu_observasi = $format->formatDateTimeForUser($model->waktu_observasi); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'waktu_observasi',
                                'mode' => 'datetime',
                                'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                ),
                        ));					
                    ?>	
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Petugas <span class="required">*</span></label>
                <div class="controls">
                    <?php
                        $nama_pegawai =PegawairuanganV::model()->findByAttributes(array('pegawai_id'=>$model->petugas_id));
                   ?>
                    <input readonly="readonly" class="span3" value="<?php echo $nama_pegawai->nama_pegawai ?>" type="text">
                </div>
            </div>
        </div>
    </div>
</div>