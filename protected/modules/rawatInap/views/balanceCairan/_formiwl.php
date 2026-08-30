<div class="panel panel-primary panel-success">
  <div class="panel-heading">
      <div class="panel-title">Perhitungan IWL (Insensible Water Loss)</div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-12">
          <div class="control-group ">
              <?php echo CHtml::label('Waktu Pemberian', 'waktu_pemberian_iwl', array('class' => 'control-label')); ?>
              <div class="controls">
                <div class="form-inline">
                    <?php echo CHtml::radioButtonList('waktu_pemberian_iwl','',array("Pagi"=>"Pagi","Siang"=>"Siang","Malam"=>"Malam"), array('class'=>'waktu_pemberian_iwl','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                </div>
              </div>
          </div>
          <div class="control-group ">
              <?php echo CHtml::label('Jam Pemeriksaan', 'jampemeriksaan', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'id' => 'jampemeriksaan',
                    'name' => 'jampemeriksaan',
                    'mode' => 'time',
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class'=>'span3',
                    ),
                ));
                ?>
              </div>
          </div>
          <div class="control-group ">
              <div class="controls">
                <div class="form-inline">
                    <?php echo CHtml::radioButtonList('chpoiseIWL','',array("Dewasa"=>"Dewasa","Anak"=>"Anak","Neonatus"=>"Neonatus"), array('class'=>'chpoiseIWL','onchange'=>'changeIwl()','onkeyup'=>"return $(this).focusNextInputField(event)",'separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                </div>
              </div>
          </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-12">
        <br/>
        <div class="panel panel-darkk" style="width: 50%">
            <span class="group-title">
                Perhitungan IWL
            </span>
            <div class="panel-body">
              <div class="control-group konstanta_dewasa">
                  <?php echo CHtml::label('Konstanta', 'konstanta', array('class' => 'control-label')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('konstanta', '',array('class'=>'span2 integer2','readonly'=>true)); ?>
                  </div>
              </div>
              <div class="control-group iwlanak">
                  <?php echo CHtml::label('Usia Anak', 'usia_anak', array('class' => 'control-label')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('usia_anak', '',array('class'=>'span2 integer2','onblur'=>'hitungIwl();')); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo CHtml::label('Berat Badan', 'beratbadan_kg', array('class' => 'control-label')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('beratbadan_kg', '',array('class'=>'span2 integer-decimal-3','onblur'=>'hitungIwl();')); ?>
                  </div>
              </div>
              <div class="control-group konstanta_neonatus">
                  <?php echo CHtml::label('Konstanta', 'konstanta_neonatus', array('class' => 'control-label')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('konstanta_neonatus', '0',array('class'=>'span2 integer2','readonly'=>true,'onblur'=>'hitungIwl();')); ?>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo CHtml::label('IWL per jam', 'iwlperjam_normal', array('class' => 'control-label')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('iwlperjam_normal', '',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?>
                    <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam iwldewasa"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<center>Perhitungan IWL per jam Normal pada Dewasa: <br/> IWL per jam = (15 x BB) / 24 jam <br/> dengan <br/> 15 = Konstanta IWL Normal Dewasa <br/> BB = Berat Badan (Kg)</center>" data-html="true"></i>
                    <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam iwlanak"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<center>Perhitungan IWL per jam Normal pada anak: <br/> IWL per jam = {30 - Usia Anak Tahun) x BB} / 24 jam <br/> dengan <br/> 30 = Konstanta IWL Normal Anak <br/> BB = Berat Badan (Kg) <br/> Usia Anak = Usia dalam Tahun</center>" data-html="true"></i>
                    <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam iwneonatus" data-toggle="tooltip" data-placement="top" title="" data-original-title="<center>Perhitungan IWL per jam Normal pada Neonatus: <br/> IWL per jam = (Konstanta IWL sesuai BB x BB) / 24 jam <br/> dengan <br/> BB = Berat Badan (Kg)</center><br/> Tabel Konstanta IWL: <br/><table border='1'><thead><tr><td>Berat Badan (Kg)</td><td>Konstanta IWL</td></tr></thead><tbody><tr><td>0.750 sampai 1.000</td><td>64</td></tr><tr><td>1.001 sampai 1.250</td><td>56</td></tr><tr><td>1.251 sampai 1.500</td><td>38</td></tr><tr><td>1.501 sampai 1.750</td><td>23</td></tr><tr><td>1.751 sampai 3.500</td><td>20</td></tr></tbody></table>" data-html="true"></i>
                  </div>
              </div>
              <div class="control-group ">
                  <div class="controls">
                      <?php echo CHtml::checkBox('isterjadikenaikansuhu', false,array('onchange'=>'changeTerjadiSuhu()')); ?> <label>Terjadi Kenaikan Suhu</label>
                  </div>
              </div>
              <br/>
              <div class="panel panel-darkk" id="pnlkenaikansuhu">
                  <span class="group-title">
                      IWL dengan Kenaikan Suhu
                  </span>
                  <div class="panel-body">
                    <div class="control-group ">
                        <?php echo CHtml::label('Konstanta Suhu', 'konstantasuhu', array('class' => 'control-label')); ?>
                        <div class="controls">
                          <?php echo CHtml::textField('konstantasuhu', '10',array('class'=>'span2 integer2','readonly'=>true)); ?> <label>%</label>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Total Cairan Masuk', 'cairanmasuk_total', array('class' => 'control-label')); ?>
                        <div class="controls">
                          <?php echo CHtml::textField('cairanmasuk_total', '',array('class'=>'span2 integer-decimal-3','onblur'=>'hitungIwlKenaikanSuhu();')); ?> <label>cc</label>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Jumlah Kenaikan Suhu', 'konstanta', array('class' => 'control-label')); ?>
                        <div class="controls">
                          <?php echo CHtml::textField('kenaikansuhutubuh_jml', '',array('class'=>'span2 float2','onblur'=>'hitungIwlKenaikanSuhu();')); ?> <label>&#176; C</label>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Nilai IWL per jam', 'iwlperjam_kenaikansuhu', array('class' => 'control-label')); ?>
                        <div class="controls">
                          <?php echo CHtml::textField('iwlperjam_kenaikansuhu', '',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?> <label>cc/jam</label>
                          <i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<center>Perhitungan IWL per jam saat terjadi kenaikan suhu : <br/> IWL per jam = [{(10% x Cairan Masuk) x Jumlah Kenaikan Suhu} / (24 Jam)] + IWL Normal per jam<br/> dengan : <br/> 10% = Konstanta Kenaikan Suhu</center>" data-html="true"></i>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo CHtml::label('Nilai IWL x Jumlah Jam Perhitungan', 'jmljamiwl_perhitungan', array('class' => 'control-label','style'=>'width: 200px')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('jmljamiwl_perhitungan', '',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?>
                    <label>cc/jam</label>
                  </div>
                  <?php echo CHtml::label('x', 'jmljam_pemeriksaan', array('class' => 'control-label','style'=>'width: 10px')); ?>
                  <div class="controls">
                    <?php echo CHtml::dropDownList('jmljam_pemeriksaan', '',LookupM::getItems('jmljam_iwl'),array('class'=>'span1','onchange'=>'changeJamPemeriksaan()')); ?>
                    <label>Jam</label>
                  </div>
              </div>
              <div class="control-group ">
                  <?php echo CHtml::label('Nilai Akhir IWL', 'iwl_nilaiakhir', array('class' => 'control-label','style'=>'width: 200px')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('iwl_nilaiakhir', '',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?>
                  </div>
                  <div class="controls">
                    <?php echo CHtml::dropDownList('satuan_nilaiakhir', '',array('cc'=>'cc'),array('class'=>'span1')); ?>
                    <label>Jam</label>
                  </div>
                  <?php echo CHtml::label('per', 'perjam', array('class' => 'control-label','style'=>'width: 30px')); ?>
                  <div class="controls">
                    <?php echo CHtml::textField('nilaiperjam', '',array('class'=>'span1 integer2','readonly'=>true)); ?>
                    <label>Jam</label>
                  </div>
              </div>
            </div>
          </div>


      </div>
    </div>
    <div class="row-fluid">
      <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah',
              array('onclick'=>'tambahIwl(this);return false;',
                    'class'=>'btn btn-primary',
                    'id'=>'tomboltambah',
                    'onkeypress'=>"tambahIwl(this);return false;",
                    'rel'=>"tooltip",
                    'title'=>"Klik untuk menambahkan ke tabel Perhitungan IWL (Insensible Water Loss)")); ?>
    </div>
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tbliwl">
        <thead>
          <tr>
              <th style="width:30px">No</th>
              <th style="width:100px">Waktu Pemeriksaan</th>
              <th style="width:80px">Jam</th>
              <th style="width:100px">Kelompok Umur Pasien</th>
              <th style="width:100px">Berat Badan (Kg)</th>
              <th style="width:100px" class="iwlanak">Usia Anak (Tahun)</th>
              <th style="width:100px">IWL / jam <br/>(cc/jam)</th>
              <th style="width:100px">Terjadi Kenaikan Suhu</th>
              <th style="width:150px">IWL Disertai Kenaikan Suhu</th>
              <th style="width:100px">Jumlah Jam Perhitungan IWL</th>
              <th style="width:100px">Nilai Akhir IWL</th>
              <th style="width:50px">Aksi</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>
