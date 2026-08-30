<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kontrol Risiko Infeksi</strong></div>
        </div>
         <div class="panel-body">
             <!-- <div class="col-md-6"> -->
               <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'kontrolrisikoinfeksi_status', array('class'=>'control-label','label'=>'Status')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'kontrolrisikoinfeksi_status',array('Tidak Diketahui'=>'Tidak Diketahui','Suspect'=>'Suspect','Diketahui'=>'Diketahui') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'kontrolrisikoinfeksi_status','onclick'=>'setStatusKontrolRisiko();')); ?>
                  </div>
              <!-- </div> -->
              <div class="control-group ">
                 <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                 <div class="controls">
                   <div class="control-group ">
                      <?php echo CHtml::label('Jenis Risiko Infeksi','', array('class'=>'control-label')) ?>
                      <div class="controls">
                        <?php
                             $lookupJenisRisiko = LookupM::model()->findAll("lookup_type = 'jenisrisikoinfeksi'");

                             if(count((array)$lookupJenisRisiko) >0 ){
                               $htmlRisiko = "";
                               foreach($lookupJenisRisiko as $i => $look_risiko){
                                 if($i > 0){
                                   $htmlRisiko .= "<br/>";
                                 }
                                $htmlRisiko .= CHtml::hiddenField('RisikoInfeksi['.$i.'][jenisrisiko]',$look_risiko->lookup_value);
                                 if($look_risiko->lookup_value == 'Lainnya'){
                                   $htmlRisiko .= CHtml::checkBox('RisikoInfeksi['.$i.'][isRisiko]',false , array('datavalue'=>$look_risiko->lookup_value,'class'=>'jenisrisiko disabledinputan','onchange'=>'setJenisRisikoLainnya(this)')).' <label>'.$look_risiko->lookup_name.'</label>';
                                   $htmlRisiko .= "<br/>".CHtml::activeTextField($modAsesmenawalkeperawatanT,'jenisrisikoinfeksi_lainnya',array('class'=>'span3'));
                                 }else{
                                   $htmlRisiko .= CHtml::checkBox('RisikoInfeksi['.$i.'][isRisiko]',false,array('datavalue'=>$look_risiko->lookup_value,'class'=>'jenisrisiko disabledinputan')).' <label>'.$look_risiko->lookup_name.'</label>';
                                 }
                               }
                               echo $htmlRisiko;
                             }
                         ?>
                      </div>
                  </div>

                 </div>
             </div>

             </div>
             <div class="col-md-6">
               <div class="control-group ">
                  <?php echo CHtml::label('Addition Precaution yang harus dilakukan','', array('class'=>'control-label')) ?>
                  <div class="controls">
                    <?php
                         $lookupAddtion = LookupM::model()->findAll("lookup_type = 'addtional_precaution'");

                         if(count((array)$lookupAddtion) >0 ){
                           $htmlAddtion = "";
                           foreach($lookupAddtion as $i => $look_risiko){
                             if($i > 0){
                               $htmlAddtion .= "<br/>";
                             }
                            $htmlAddtion .= CHtml::hiddenField('Addtional['.$i.'][addtional_precaution]',$look_risiko->lookup_value);
                             $htmlAddtion .= CHtml::checkBox('Addtional['.$i.'][isaddtional_precaution]',false,array('class'=>'')).' <label>'.$look_risiko->lookup_name.'</label>';
                           }
                         echo $htmlAddtion;
                         }
                     ?>
                  </div>
              </div>
             </div>
         </div>
     </div>
</div>
