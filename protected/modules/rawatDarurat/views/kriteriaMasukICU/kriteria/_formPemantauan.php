<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success">
          <div class="panel-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                      <table class="items table table-bordered table-striped table-condensed" >
                         <thead>
                              <tr >
                                  <th colspan="3" >Pemantauan sebelum dan sesudah pembedahan</th>
                              </tr>
                              <tr >
                                  <th>Diagnosis/Kondisi Klinis</th>
                                  <th>Ya</th>
                                  <th>Tidak</th>
                              </tr>
                              
                          </thead>
                          <tr>
                              <th>Pasien sebelum atau sesudah pembedahan yang memerlukan monitoring ketat (terutama hemodinamik / bantuan ventilasi mekanin) atau perawatan intensif</th>
                              <th><?php echo CHtml::activeRadioButton($model,'pembedahan_ismonitoring',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'pembedahan_ismonitoring',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
             
                          </tr>
                          <tr>
                              <th>Pasien perioperative dengan resiko tinggi (kondisi sebelum/pasca beda yang umumnya membutuhkan pemantauan dan tindakan invasif antara lain, seperti: Bedah Jantung terbuka, Bedah Thoraks Kardiovaskuler,Bedah Syaraf,Bedah THT-Kraniofasial-Jalan nafas, Bedah Orthopedi dan
                                  Tulang belakang servial, Transplantasi Organ, Bedah Anak,Bedah Urologi dengan komplikasi, Bedah Obsteri dan Ginekologi dengan gangguan pernafasan dan hemodinamik dan Bedah Digestif/umum/lainnya dengan gangguan respirasi dan hemodinamik atau pembedahan dengan kehilangan darah dalam jumlah besar serta waktu yang lama (> 6 jam).
                              </th>
                              <th><?php echo CHtml::activeRadioButton($model,'pembedahan_isperioperative',array('value'=> '1' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                              <th><?php echo CHtml::activeRadioButton($model,'pembedahan_isperioperative',array('value'=> '0' ,'class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            
                          </tr>
                        
                      </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
</div>
