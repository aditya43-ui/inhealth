<?php
if(count((array)$dataHasilPemeriksaanPAs) > 0){
    foreach($dataHasilPemeriksaanPAs AS $i => $pemeriksaan){
//        $trpemeriksaan = false;
//        if($i == 0){
//            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$dataHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//        }else if(($i) < count((array)$dataHasilPemeriksaanPAs)){
//            if($dataHasilPemeriksaanPAs[$i]->pemeriksaanlab_id != $dataHasilPemeriksaanPAs[$i-1]->pemeriksaanlab_id){
//                echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$dataHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//            }
//        }
        
    $pemeriksaan->tglperiksapa = $format->formatDateTimeForUser($pemeriksaan->tglperiksapa);
    $jenisperiksa = $pemeriksaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
    $pemeriksaanlab = $pemeriksaan->pemeriksaanlab;
?>   
    <div class="item_pa">
        <?php echo CHtml::hiddenField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;')) ?>
        <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']hasilpemeriksaanpa_id',array('readonly'=>true)) ?>
        <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']tindakanpelayanan_id',array('readonly'=>true)) ?>
        <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']pemeriksaanlab_id',array('readonly'=>true)) ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Hasil Pemeriksaan Patologi Anatomi <?php echo $jenisperiksa; ?></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'nosediaanpa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']nosediaanpa',array('placeholder'=>'No. Sediaan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", "readonly"=>false)) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'statushasilperiksapa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']statushasilperiksapa',array('placeholder'=>'Status Hasil','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", "readonly"=>true)) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Pemeriksaan', '', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('pemeriksaan', $pemeriksaan->pemeriksaanlab->pemeriksaanlab_nama, array('placeholder'=>'Pemeriksaan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", "readonly"=>true)) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'tglperiksapa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $pemeriksaan,
                                    'attribute' => '['.$i.']tglperiksapa',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        //                                'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('class' => 'span3 tglperiksa', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                                ));
                                ?>
                                <?php //echo CHtml::activeTextField($pemeriksaan,'['.$i.']tglperiksapa',array('placeholder'=>'Tanggal Pemeriksaan','class'=>'span3 tglperiksa','onkeyup'=>"return $(this).focusNextInputField(event)", "readonly"=>true)) ?>
                            </div>
                        </div>
                        <?php if ($pemeriksaanlab->formathasilperiksa == "umum") { ?>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'organ_lokasi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']organ_lokasi',array('placeholder'=>'Organ/Lokasi','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($pemeriksaanlab->formathasilperiksa == "umum") { ?>
                <div class="row-fluid redactor">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'diagnosaklinis', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']diagnosaklinis','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'mikroskopis', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']mikroskopis','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'catatanpa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']catatanpa','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'makroskopis', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']makroskopis','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'kesimpulanpa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']kesimpulanpa','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'saranpa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']saranpa','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                    </div>    
                </div>
                <?php } else { ?>
                <div class="row-fluid redactor">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'diagnosaklinis', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']diagnosaklinis','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'kategoriumum', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']kategoriumum','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'kesimpulanpa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']kesimpulanpa','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'adekuasisediaan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']adekuasisediaan','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'diagnosadeskriptif', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']diagnosadeskriptif','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($pemeriksaan, 'catatanpa', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$pemeriksaan,'attribute'=>'['.$i.']catatanpa','toolbar'=>'mini','height'=>'150px')) ?>
                            </div>
                        </div>
                    </div> 
                </div>
                <?php } ?>
            </div>
        </div>
    
    </div>
    <hr/>
    
    <?php /*
    <tr>
        <td>
            <?php echo CHtml::textField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;')) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']hasilpemeriksaanpa_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']tindakanpelayanan_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']pemeriksaanlab_id',array('readonly'=>true)) ?>
        </td>
        <td></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']tglperiksapa',array('readonly'=>true,'class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo $pemeriksaan->pemeriksaanlab->pemeriksaanlab_nama; ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']makroskopis',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']mikroskopis',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']kesimpulanpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']saranpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']catatanpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
    </tr>
    */ ?>
<?php        
    }
}
?>

