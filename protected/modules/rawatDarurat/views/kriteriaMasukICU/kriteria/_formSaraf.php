<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                           <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Sistem Saraf Pusat</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Stroke akut dengan perubahan status mental</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isstrokeakut',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isstrokeakut',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                          
                          </tr>
                          <tr>
                              <th>Koma : metabolic,toxic,anoxic</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskoma',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskoma',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Perdarahan intakranial dengan potensi terjadi herniasi atau terdapat perubahan status mental</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_ispendarahan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_ispendarahan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Meningitis akut dengan perubahan status mental atau gangguan pernafasan</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isminingitis',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isminingitis',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>

                          <tr>
                              <th>Gangguan system saraf pusat atau neuromuscular disertai perburukan secra neurologis atau penurunan fungsi paru</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isgangguansistem',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isgangguansistem',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          <tr>
                              <th>Status epileptikus</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isepileptikus',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isepileptikus',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          
                          <tr>
                              <th>Kematian otak atau pasien yang berpotensi mati otak (brain dead) yang dengan agresif sementara menunggu status donasi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskematianotak',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskematianotak',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          
                          <tr>
                              <th>Pasien cidera kepala berat akut potensial terjadi perburukan</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isciderakepala',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isciderakepala',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          
                          <tr>
                              <th>Kejang yang tidak terkontrol</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskejang',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskejang',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                          

                          <tr>
                          <th>Kelemahan otot progresif dengan keterlibatan otot otot pernafasan</th>    
                          <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskelemahanotot',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskelemahanotot',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                        </tr>
                        
                        <tr>
                        <th>Delirium berat akut</th> 
                        <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isdelirium',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isdelirium',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                        </tr>
                      
                        <tr>
                            <th>Cidera medulla spinalis untuk pemantauan haemodinamik</th>
                            <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_ismedullaspinalis',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_ismedullaspinalis',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                        </tr>             

                          <tr>
                              <th>Setiap kondisi yang membutuhkan kraniotomi atau ventrikulostomy dengan resiko vasospasme</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskraniotomi',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_iskraniotomi',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                          </tr>
                          <tr>
                              <th>Pemantauan pasca prosedur endarterektomi karotis atau Aneurismal Coiling</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_ispemantauan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_ispemantauan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                          </tr>

                          <tr>
                              <th>Setiap kondisi yang dihubungkan dengan peningkatan tekanan inta kranial yang berhubungan dengan defek neurologis yang progresi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_istekananintakranial',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_istekananintakranial',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                          </tr>
                          
                          <tr>
                              <th colspan="2"><b>PARAMETER FISIOLOGIS/LABORATORIUM</b></th>
                              <th> <?php echo "Ya"; ?> </th>
                              <th> <?php echo "Tidak"; ?> </th>
                         
                            </tr>
                          <tr>
                              <th colspan="2">Glasgow Coma Scale < 10</th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isgcs',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'sarafpusat_isgcs',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                       
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
