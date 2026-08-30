<div class="row-fluid">
  <div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Riwayat Menstruasi & Perkawinan</strong></div>
    </div>
     <div class="panel-body">
       <div class="panel panel-primary panel-success">
          <div class="panel-heading">
              <div class="panel-title"><strong>Riwayat Menstruasi</strong></div>
          </div>
           <div class="panel-body">
             <div class="row">
               <div class="col-sm-6">
                 <div class="control-group ">
                    <?php echo CHtml::label('Siklus Haid','', array('class'=>'control-label')) ?>
                    <div class="controls">
                      <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_siklushaid',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;', 'onblur'=>'hitungSiklusHaid();')); ?> Hari
                    </div>
                </div>
                <div class="control-group ">
                   <?php echo CHtml::label('Menarche umur','', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_menarcheumur',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;')); ?> Hari
                   </div>
               </div>
               <div class="control-group ">
                  <?php echo CHtml::label('Menstruasi Terakhir','', array('class'=>'control-label')) ?>
                  <div class="controls">
                    <?php
                      $this->widget('MyDateTimePicker', array(
                              'model' => $modAsesmenawalkeperawatanT,
                              'attribute' => 'obgyn_mensterakhir',
                              'mode' => 'date',
                              'options' => array(
                                  'dateFormat' => Params::DATE_FORMAT,
                              ),
                              'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                              'onkeypress' => "return $(this).focusNextInputField(event)",
                              'onchange' => 'hitungSiklusHaid();',
                              ),

                      ));
                    ?>
                  </div>
              </div>
              <div class="control-group ">
                 <?php echo CHtml::label('Keluhan saat haid','', array('class'=>'control-label')) ?>
                 <div class="controls">
                   <?php  echo $form->textArea($modAsesmenawalkeperawatanT,'obgyn_keluhansaathaid',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 </div>
             </div>
           </div>
           <div class="col-sm-6">
             <div class="control-group ">
                <?php echo CHtml::label('Banyaknya','', array('class'=>'control-label')) ?>
                <div class="controls">
                  <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_banyaknyahaid',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
              </div>
                <div class="control-group ">
                   <?php echo CHtml::label('Haid Teratur','', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <div class="radio inline">
                       <div class="form-inline">
                         <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'obgyn_keteraturanhaid',array('Teratur'=>'Teratur','Tidak Teratur'=>'Tidak Teratur'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_keteraturanhaid','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                       </div>
                     </div>
                   </div>
               </div>
               <div class="control-group ">
                  <?php echo CHtml::label('Lama haid','', array('class'=>'control-label')) ?>
                  <div class="controls">
                    <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_lamahaid',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;'));?> Hari
                  </div>
              </div>
              <div class="control-group ">
                 <?php echo CHtml::label('Taksiran tanggal persalinan','', array('class'=>'control-label')) ?>
                 <div class="controls">
                   <?php
                     $this->widget('MyDateTimePicker', array(
                             'model' => $modAsesmenawalkeperawatanT,
                             'attribute' => 'obgyn_taksiranpersalinan',
                             'mode' => 'date',
                             'options' => array(
                                 'dateFormat' => Params::DATE_FORMAT,
                             ),
                             'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                             'onkeypress' => "return $(this).focusNextInputField(event)"),
                     ));
                   ?>
                 </div>
             </div>
             <div class="control-group ">
                <?php echo CHtml::label('Usia Kehamilan menurut HPHT','', array('class'=>'control-label')) ?>
                <div class="controls">
                  <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_usiakehamilanhpht',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;')); ?> Minggu
                </div>
            </div>

           </div>
         </div>
       </div>
   </div>
   <div class="panel panel-primary panel-success">
      <div class="panel-heading">
          <div class="panel-title"><strong>Riwayat Menstruasi</strong></div>
      </div>
     <div class="panel-body">
       <div class="row">
         <div class="col-sm-6">
           <div class="control-group ">
              <?php echo CHtml::label('Status','', array('class'=>'control-label')) ?>
              <div class="controls">
                <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'obgyn_statuskawin',array('Belum Kawin'=>'Belum Kawin','Cerai'=>'Cerai','Kawin'=>'Kawin') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_statuskawin','onclick'=>'setStatuskawin_obgyn();')); ?>
              </div>
            </div>
            <div class="control-group ">
               <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
               <div class="controls">
                 <div class="control-group ">
                    <?php echo CHtml::label('Jumlah','', array('class'=>'control-label','style'=>'width: 50px')) ?>
                    <div class="controls">
                      <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_jumlahperkawainan',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;')); ?> Kali
                    </div>
                </div>
               </div>
           </div>
         </div>
         <div class="col-sm-6">
           <div class="control-group ">
              <?php echo CHtml::label('Umur waktu kawin pertama','', array('class'=>'control-label')) ?>
              <div class="controls">
                <?php  echo $form->textField($modAsesmenawalkeperawatanT,'obgyn_umurkawinpertama',array('class'=>'span1 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'style'=>'text-align: right;')); ?> Tahun
              </div>
          </div>
          <div class="control-group ">
             <?php echo CHtml::label('Golongan Darah','', array('class'=>'control-label')) ?>
             <div class="controls">
                <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'obgyn_golongandarah', array('value'=>'A','uncheckValue'=>null,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_golongandarah')); ?> <label>A</label> &nbsp;&nbsp;&nbsp;
                <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'obgyn_golongandarah', array('value'=>'0','uncheckValue'=>null,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_golongandarah')); ?> <label>O</label>
                <br/>
                <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'obgyn_golongandarah', array('value'=>'B','uncheckValue'=>null,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_golongandarah')); ?> <label>B</label>&nbsp;&nbsp;&nbsp;
                <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'obgyn_golongandarah', array('value'=>'Tidak Tahu','uncheckValue'=>null,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_golongandarah')); ?> <label>Tidak Ada</label>
                <br/>
                <?php echo $form->radioButton($modAsesmenawalkeperawatanT,'obgyn_golongandarah', array('value'=>'AB','uncheckValue'=>null,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'obgyn_golongandarah')); ?> <label>AB</label>
             </div>
         </div>

         </div>
       </div>
     </div>
   </div>
  </div>
 </div>
</div>
