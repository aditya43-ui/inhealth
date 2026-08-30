<div class="panel panel-primary panel-gradient">
   <div class="panel-heading">
       <div class="panel-title"><strong>Konsep Diri dan Kognitif</strong></div>
   </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-6">
          <div class="control-group ">
             <?php echo $form->labelEx($modAskepgeriatriT,'pengetahuanttg_penyakitsaatini', array('class'=>'control-label','label'=>'Pengetahuan tentang penyakit saat ini')) ?>
             <div class="controls">
                 <?php echo $form->radioButtonList($modAskepgeriatriT,'pengetahuanttg_penyakitsaatini',LookupM::getItems('pengetahuanttg_penyakitsekarang') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'pengetahuanttg_penyakitsaatini')); ?>
             </div>
         </div>
         <div class="control-group ">
            <?php echo $form->labelEx($modAskepgeriatriT,'pengetahuanttg_perawatan', array('class'=>'control-label','label'=>'Perawatan/ tindakan yang dilakukan')) ?>
            <div class="controls">
                <?php echo $form->radioButtonList($modAskepgeriatriT,'pengetahuanttg_perawatan',array('Mengerti'=>'Mengerti','Tidak Mengerti'=>'Tidak Mengerti') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'pengetahuanttg_perawatan')); ?>
            </div>
        </div>
        </div>
        <div class="col-sm-6">
          <div class="control-group ">
             <?php echo CHtml::label('Apakah ada Perasaan','', array('class'=>'control-label')) ?>
             <div class="controls">
               <?php
                    $look_Perasaan = LookupM::model()->findAll("lookup_type = 'geriatri_memilikiperasaan' order by lookup_urutan ASC");

                    if(count((array)$look_Perasaan) >0 ){
                      $htmlPerasaan = "";
                      foreach($look_Perasaan as $i => $look){
                        $isPerasaan = false;

                        if(!empty($modAskepgeriatriT->perasaanyg_dirasakan)){
                          $oriArrPerasaan = json_decode($modAskepgeriatriT->perasaanyg_dirasakan);

                          foreach($oriArrPerasaan as $oriPerasaan){
                            if($look->lookup_value == $oriPerasaan){
                                $isPerasaan= true;
                            }
                          }
                        }

                        if($i > 0){
                          $htmlPerasaan .= "<br/>";
                        }
                       $htmlPerasaan .= CHtml::hiddenField('Perasaan['.$i.'][name]',$look->lookup_value);
                       $htmlPerasaan .= CHtml::checkBox('Perasaan['.$i.'][isPerasaan]',$isPerasaan,array('class'=>'isPerasaan')).' <label>'.$look->lookup_name.'</label>';

                      }
                      echo $htmlPerasaan;
                    }
                ?>
             </div>
         </div>
        </div>
      </div>
    </div>
</div>
