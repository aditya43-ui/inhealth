<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                    <thead>
                              <tr >
                                  <th colspan="3" >Luka Bakar</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Setiap pasien luka bakar dewasa dan anak dengan trauma inhalasi</th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_istrauma',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_istrauma',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                                 
                          </tr>
                         
                          <tr>
                              <th colspan="2"><b>PARAMETER FISIOLOGIS/LABORATORIUM</b></th>
                              <th> <?php echo "Ya"; ?> </th>
                              <th> <?php echo "Tidak"; ?> </th>
                         
                            </tr>
                          <tr>
                              <th colspan="2">Setiap pasien luka bakar dewasa > 30% dengan atau tanpa trauma inhalasi ( < 24 jam pasca trauma)</th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_istanpatraumakurang',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_istanpatraumakurang',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               
                        </tr>
                        <tr>
                              <th colspan="2">Setiap pasien luka bakar anak >10% dengan atau tanpa trauma inhalasi (>24 jam pasca trauma)</th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_istanpatraumalebih',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_istanpatraumalebih',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                        <tr>
                              <th colspan="2">Setiap pasien luka bakar dewasa >30%, > 24 jam pasca trauma dengan salah satu atau lebih gangguan saluran nafas (Airway), pernafasan(Breathing),sirukulasi(Circulation) </th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_ispascatraumabesar',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_ispascatraumabesar',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                       
                        <tr>
                              <th colspan="2">Setiap pasien luka bakar dewasa >10%, > 24 jam pasca trauma dengan salah satu atau lebih gangguan saluran nafas (Airway), pernafasan(Breathing),sirukulasi(Circulation) </th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_ispascatraumakecil',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'lukabakar_ispascatraumakecil',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                        </tr>
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
