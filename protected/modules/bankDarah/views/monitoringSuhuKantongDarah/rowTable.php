<tr data-row=<?php echo $i ?>>
                                <td><?php echo CHtml::activehiddenField($modMonitoring,"[$i]monitoringkantong_id",array('class'=>'span1 monitoringkantong_id','readonly'=>true)); ?>
                                    <?php echo CHtml::activehiddenField($modMonitoring,"[$i]petugasmonitoring_id",array('class'=>'petugasmonitoring_id span1','readonly'=>true)); ?>
                              
                                <?php
                                    $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$modMonitoring,
                                        'attribute'=>"[$i]petugasmonitoring_nama",
                                        'source'=>'js: function(request, response) {
                                        $.ajax({
                                             url: "'.$this->createUrl('/ActionAutoComplete/dropPetugasRuangan').'",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id:'.Yii::app()->user->getState('ruangan_id').'
                                        },
                                        success: function (data) {
                                        response(data);
                                        }
                                    })
                                }',
                                'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength' => 3,
                                    'class'=>'span2',
                                    'focus'=> 'js:function( event, ui ) {
                                        $(this).val(ui.item.namaLengkap);
                                        return false;
                                    }',
                                    'select'=>'js:function( event, ui ) {
                                        $(this).parents("tr").find(".petugasmonitoring_id").val(ui.item.pegawai_id);
                                        $(this).val(ui.item.namaLengkap);
                                        return false;
                                    }',

                            ),
                            'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
                            'htmlOptions'=>array('class'=>'pegawai_nama span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", ),
                           )); ?>
           
                                </td>
                                
                                 <td width="300px"> 
                                   <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]kosongtanpalistrik",
                                            'value' => $modMonitoring->kosongtanpalistrik,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                         </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]kosongtanpalistrik_suhu",array('class'=>'span1 numbers-only integer2','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                    </div> 
                                </td>
                                <td width="300px">
                                    <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]kosongdenganlistrik",
                                            'value' => $modMonitoring->kosongdenganlistrik,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]kosongdenganlistrik_suhu",array('class'=>'span1 numbers-only','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                    </div> 
                                </td>
                                <td width="300px">
                                     <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]listrikdanicepack",
                                            'value' => $modMonitoring->listrikdanicepack,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]listrikdanicepack_suhu",array('class'=>'span1 numbers-only integer4','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                     </div> 
                                </td>
                                <td width="300px">
                                     <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]mulaiisikantong",
                                            'value' => $modMonitoring->mulaiisikantong,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]mulaiisikantong_suhu",array('class'=>'span1 numbers-only integer5','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                     </div> 
                                </td>
                                <td width="300px">
                                     <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]setelahdiisikantong",
                                            'value' => $modMonitoring->setelahdiisikantong,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]setelahdiisikantong_suhu",array('class'=>'span1 numbers-only integer6','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                     </div> 
                                </td>
                                <td width="300px">
                                     <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]lepaslistrik",
                                            'value' => $modMonitoring->lepaslistrik,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]lepaslistrik_suhu",array('class'=>'span1 numbers-only integer7','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                     </div> 
                                </td>
                                <td width="300px">
                                     <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]kirimkelabitd",
                                            'value' => $modMonitoring->kirimkelabitd,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]kirimkelabitd_suhu",array('class'=>'span1 numbers-only integer8','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                     </div> 
                                </td>
                                <td width="300px">
                                     <div class="control-group">
                                        <div class="controls">
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modMonitoring,
                                            'attribute' => "[$i]sampaidilabitd",
                                            'value' => $modMonitoring->sampaidilabitd,
                                            'mode' => 'time',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                            )); ?> <label>/</label>
                                        </div>
                                        <div class="controls">
                                             <?php echo CHtml::activeTextField($modMonitoring,"[$i]sampaidilabitd_suhu",array('class'=>'span1 numbers-only integer9','readonly'=>false)); ?><label>&#8451;</label>
                                        </div>
                                     </div> 
                                </td>
                                <td  width="300px">
                                    <div class="control-group">
                                        <div class="controls">
                                    <?php echo CHtml::activeTextField($modMonitoring,"[$i]ket_monitoring",array('class'=>'span2','readonly'=>false)); ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td  width="300px"> 
                                <div class="cotrol-group">
                                    <div class="controls rowbutton">            
                                        <?php                                         
                                            echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('tambah-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'btn btn-primary tambah','onclick'=>'tambahBaris()', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menambahkan baris baru",'data-placement'=>'left')); ?>            
                                    </div>
                                <div class="controls rowbutton"  >            
                                <?php 
                                    if ($i != 0){
                                        echo CHtml::link('<span style="font-size:20px;"><i class="'.MyIcon::getIcons('hapus-baris').'"></i></span>', 'javascript:;', array('style'=>'border-radius:100%;padding:0px;','class'=>'btn btn-danger hapus','onclick'=>'hapusBaris(this,'.$modMonitoring->monitoringkantong_id.')', "rel"=>"tooltip" ,"data-original-title"=>"Klik untuk menghapus baris",'data-placement'=>'left')); 
                                    }
                                ?>            
                                </div>
                                </div>
                                </td>
</tr>

