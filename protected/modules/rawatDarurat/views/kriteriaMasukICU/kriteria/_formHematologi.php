<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                     <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Sistem Hematologi</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Adanya hemolisis aktif dengan penurunan hematokrit</th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_ishemolisis',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_ishemolisis',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           
                          </tr>
                          <tr>
                              <th colspan="2"><b>PARAMETER FISIOLOGIS/LABORATORIUM</b></th>
                              <th> <?php echo "Ya"; ?> </th>
                              <th> <?php echo "Tidak"; ?> </th>
                         
                            </tr>
                          <tr>
                              <th colspan="2">Trombositopenia (platelete < 70.000) dengan bukti perdarahan aktif</th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_istrombositopenia',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_istrombositopenia',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           
                        </tr>
                        <tr>
                              <th colspan="2">Koagulopati (INR > 2.5 atau Active partial tromboplastin time [aPTT] > 40 - 50 detik) dengan bukti perdarahan aktif</th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_iskoagulopati',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_iskoagulopati',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                        <tr>
                              <th colspan="2">Leukosit > 100.000 / l dan terutama dengan bukti disfungsi organ targe</th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_isleukosit',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'hematologi_isleukosit',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             </tr>
                            
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
