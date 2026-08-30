<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed">
                       <thead>
                              <tr >
                                  <th colspan="3" >Gangguan Sistem Gastrointestina</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Perdarahan gastrointestinal yang mengancam nyawa sampai terjadi hipotensi, angina, perdarahan yang berlanjut, atau terdapat penyakit penyerta</th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_ispendarahan',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_ispendarahan',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                          </tr>
                           <tr>
                              <th>Kegagalan hati fulminant</th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_iskegagalanhati',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_iskegagalanhati',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                            </tr>
                           <tr>
                              <th>Pankreatitis berat</th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_ispankreatitis',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_ispankreatitis',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              </tr>
                           <tr>
                              <th>Perforasi esophageal</th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_isperforasi',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_isperforasi',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               </tr>
                           <tr>
                              <th>Obtruksi intestinal akut karena gangguan mobilitas usus</th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_isobstruksi',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_isobstruksi',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                             
                           </tr>
                           <tr>
                              <th>Abdomen yang tegang dengan pertimbangan adanya hipertensi intra abdomen atau sindroma kompartemen abdomen dan perlu pemantauan ketat tekanan intra abdome</th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_isabdomen',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'gastrointestinal_isabdomen',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              
                           </tr>
                          
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
