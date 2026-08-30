<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Skrinning Nyeri - Metode CRIES</strong></div>
        </div>
         <div class="panel-body">
           <table class="items table table-bordered table-striped table-condensed" width="100%" id="tblSkrining">
               <thead>
                   <tr>
                       <th width="50px">No</th>
                       <th>Penilaian</th>
                       <th width="250px">Nilai 0</th>
                       <th width="250px">Nilai 1</th>
                       <th width="250px">Nilai 2</th>
                       <th width="80px">Nilai</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td><label>1</label></td>
                      <td style="font-style: italic;"><label>Crying</label></td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_crying',array('class'=>'isneonatus_cries_crying','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesCrying(this)','labelradio'=>"Tidak ada tangisan/ tangisan tidak melengking")); ?>
                        <label>Tidak ada tangisan/ tangisan tidak melengking</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_crying',array('class'=>'isneonatus_cries_crying','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesCrying(this)','labelradio'=>"Tangisan melengking tetapi bayi mudah dihibur")); ?>
                        <label>Tangisan melengking tetapi bayi mudah dihibur</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_crying',array('class'=>'isneonatus_cries_crying','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesCrying(this)','labelradio'=>"Tangisan melengking tetapi bayi tidak mudah dihibur")); ?>
                        <label>Tangisan melengking tetapi bayi tidak mudah dihibur</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeHiddenField($model,'neonatus_cries_cryingket') ?>
                        <?php echo CHtml::activeTextField($model,'neonatus_cries_cryingnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                      </td>
                    </tr>
                    <tr>
                      <td><label>2</label></td>
                      <td style="font-style: italic;"><label>Requires</label></td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_requires',array('class'=>'isneonatus_cries_requires','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesRequires(this)','labelradio'=>"Tidak perlu oksigen")); ?>
                        <label>Tidak perlu oksigen</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_requires',array('class'=>'isneonatus_cries_requires','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesRequires(this)','labelradio'=>"perlu oksigen ≤ 30%")); ?>
                        <label>perlu oksigen ≤ 30%</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_requires',array('class'=>'isneonatus_cries_requires','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesRequires(this)','labelradio'=>"perlu oksigen ≥ 30%")); ?>
                        <label>perlu oksigen ≥ 30%</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeHiddenField($model,'neonatus_cries_requiresket') ?>
                        <?php echo CHtml::activeTextField($model,'neonatus_cries_requiresnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                      </td>
                    </tr>
                    <tr>
                      <td><label>3</label></td>
                      <td style="font-style: italic;"><label>Increased</label></td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_increased',array('class'=>'isneonatus_cries_increased','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesIncreased(this)','labelradio'=>"Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line")); ?>
                        <label>Detak jantung dan tekanan darah tidak berubah atau kurang dari nilai base line</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_increased',array('class'=>'isneonatus_cries_increased','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesIncreased(this)','labelradio'=>"Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%")); ?>
                        <label>Detak jantung atau tekanan darah meningkat, tetapi peningkatan ≤ 20%</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_increased',array('class'=>'isneonatus_cries_increased','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesIncreased(this)','labelradio'=>"Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line")); ?>
                        <label>Detak jantung atau tekanan darah meningkat ≥ 20% dari nilai base line</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeHiddenField($model,'neonatus_cries_increasedket') ?>
                        <?php echo CHtml::activeTextField($model,'neonatus_cries_increasednilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                      </td>
                    </tr>
                    <tr>
                      <td><label>4</label></td>
                      <td style="font-style: italic;"><label>Expression</label></td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_expression',array('class'=>'isneonatus_cries_expression','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesExpression(this)','labelradio'=>"Tidak ada seringai")); ?>
                        <label>Tidak ada seringai</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_expression',array('class'=>'isneonatus_cries_expression','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesExpression(this)','labelradio'=>"Seringai ada")); ?>
                        <label>Seringai ada</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_expression',array('class'=>'isneonatus_cries_expression','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesExpression(this)','labelradio'=>"Seringai ada dan tidak ada suara tangisan dengkur")); ?>
                        <label>Seringai ada dan tidak ada suara tangisan dengkur</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeHiddenField($model,'neonatus_cries_expressionket') ?>
                        <?php echo CHtml::activeTextField($model,'neonatus_cries_expressionnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                      </td>
                    </tr>
                    <tr>
                      <td><label>5</label></td>
                      <td style="font-style: italic;"><label>Sleepless</label></td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_sleepless',array('class'=>'isneonatus_cries_sleepless','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesSleepless(this)','labelradio'=>"Bayi terus menerus tidur")); ?>
                        <label>Bayi terus menerus tidur</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_sleepless',array('class'=>'isneonatus_cries_sleepless','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesSleepless(this)','labelradio'=>"Bayi terbangung pada interval berulang")); ?>
                        <label>Bayi terbangung pada interval berulang</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeRadioButton($model,'isneonatus_cries_sleepless',array('class'=>'isneonatus_cries_sleepless','value'=>'2','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onChange'=>'changeCriesSleepless(this)','labelradio'=>"Bayi terjaga, terbangun secara terus menerus")); ?>
                        <label>Bayi terjaga, terbangun secara terus menerus</label>
                      </td>
                      <td>
                        <?php echo CHtml::activeHiddenField($model,'neonatus_cries_sleeplessket') ?>
                        <?php echo CHtml::activeTextField($model,'neonatus_cries_sleeplessnilai', array('class'=>'span1 totalcries','readonly'=>true)); ?>
                      </td>
                    </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"><label>Total Nilai</label></td>
                    <td>
                      <?php echo CHtml::activeTextField($model,'neonatus_cries_totalnilai', array('class'=>'span1','readonly'=>true)); ?>
                    </td>
                  </tr>
                </tfoot>
            </table>

         </div>
     </div>
</div>
<div class="row-fluid">
    <div class="form-actions pull-right">
        <?php
            if(isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','id'=>'btn_simpan','disabled'=>true));
            }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','onclick'=>'simpanAllDataNeonatus();')); //RND-8620
            }
        ?>
    </div>
</div>
