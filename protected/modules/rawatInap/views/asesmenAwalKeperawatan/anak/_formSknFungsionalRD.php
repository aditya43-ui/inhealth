<div class="row-fluid">
    <div class="col-sm-12">
      <div class="panel panel-success panelpilih_fungsional" id="pilih_fungsional" >
          <div class="panel-heading">
              <div class="panel-title"><?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isfungsional', array('onclick' => 'pilihFungsional(this)', 'value' => 1, 'class'=>'pilih_fungsional', 'uncheckValue'=>null)); ?> Skrinning Status Fungsional</div>
          </div>
          <div class="panel-body" >
              <?php  echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT, 'jenis_statusfungsional', array('value'=>'jenis_fungsional')); ?>
              <div class="formFungsional">
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                       <table class="items table table-bordered table-striped table-condensed" id="tblInputFungsional">
                           <thead>
                               <tr>
                                   <th style="width: 10px">No</th>

                                   <th style="width: 300px">Kriteria Barthel Index</th>
                                   <th style="width: 50px">Dengan Bantuan</th>
                                   <th style="width: 50px">Mandiri</th>
                                   <th style="width: 50px">Skor</th>
                               </tr>
                          </thead>
                           <tr>
                               <th>1</th>
                               <th>Makan</th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_makan', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                           </tr>
                            <tr>
                               <th>2</th>
                               <th>Aktifitas di Toilet</th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnToilet(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnToilet(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_aktifitastoilet', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>3</th>
                               <th>Berpindah dari roda ke tempat tidur/ sebaliknya, termasuk duduk di tempat tidur</th>
                               <th style="text-align: center;">5-10</th>
                               <th><?php echo CHtml::htmlButton('15',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnRodaTidur(15)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_berpindahkursi', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>4</th>
                               <th>Kebersihan diri, mencuci muka, menyisir rambut, menggosok gigi</th>
                               <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnGosokGigi(0)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnGosokGigi(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_kebersihanmandiri', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>5</th>
                               <th>Mandi</th>
                               <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMandi(0)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMandi(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_mandi', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>6</th>
                               <th>Berjalan di permukaan dasar</th>
                                 <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerjalanDasar(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('15',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerjalanDasar(15)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_berjalanpermukaankasar', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>7</th>
                               <th>Naik turun tangga</th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnNaikTangga(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnNaikTangga(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_naikturuntangga', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>8</th>
                               <th>Berpakaian</th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerpakaian(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerpakaian(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_berpakaian', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                            <tr>
                               <th>9</th>
                               <th>Mengontrol defekasi</th>
                               <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnDefekasi(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnDefekasi(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_mengontroldefekasi', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                            </tr>
                           <tr>
                               <th>10</th>
                               <th>Mengontrol Berkemih</th>
                                 <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerkemih(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerkemih(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                               <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_mengontrolberkemih', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional();', 'maxlength' => 10)); ?> </th>

                           </tr>
                           <tr>
                               <th colspan="4">Total Score</th>
                               <th> <?php echo $form->textField($modAsesmenawalkeperawatanT,'skrinningfungsional_jumlah_skor', array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                               <th colspan="4">Keterangan Skor</th>
                               <th colspan="2"> <?php echo $form->textField($modAsesmenawalkeperawatanT,'skrinningfungsional_keterangan', array('class'=>'keterangan_skor_lansia span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                               <th colspan="4">Kategori</th>
                               <th colspan="2"> <?php echo $form->textField($modAsesmenawalkeperawatanT,'skrinningfungsional_kategori', array('class'=>'keterangan_skor_lansia span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                           </tr>
                       </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
      <div class="panel panel-success panelpilih_fungsional" id="pilih_fungsionaladl" >
          <div class="panel-heading">
              <div class="panel-title"><?php echo CHtml::activeRadioButton($modAsesmenawalkeperawatanT,'isfungsional', array('onclick' => 'pilihFungsional(this)', 'value' => 2, 'class'=>'pilih_fungsional', 'uncheckValue'=>null)); ?> Skrinning Status Fungsional ADL</div>
          </div>
          <div class="panel-body" >
              <?php  echo CHtml::activeHiddenField($modAsesmenawalkeperawatanT, 'jenis_statusfungsional', array('value'=>'jenis_fungsionaladl')); ?>
              <div class="formFungsionalAdl">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="control-group ">
                       <?php echo CHtml::label('Perawat Pengisi', 'perawat_id', array('class' => 'control-label')) ?>
                       <div class="controls">
                           <?php echo $form->dropDownList($modBarthelindex,'perawat_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState("ruangan_id")), 'pegawai_id', 'NamaLengkap'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                       </div>
                   </div>
                  </div>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <div class='block-tabel'>
                       <table class="items table table-bordered table-condensed" id="tblInputFungsionalAdl">
                           <thead>
                               <tr>
                                   <th style="width: 10px; text-align: center;">No</th>
                                   <th style="width: 250px; text-align: center;">Fungsi</th>
                                   <th style="width: 250px; text-align: center;">URAIAN</th>
                                   <th style="width: 10px; text-align: center;">Skor</th>
                                   <th style="width: 50px; text-align: center;">Nilai Skor</th>
                               </tr>
                          </thead>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">1</th>
                               <th rowspan="4" style="vertical-align: middle;">Mengendalikan Rangsang deteksi (BAB)</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_bab', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tak Terkendali/ Tak Teratur (Perlu Pencahar)</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'bab')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Kadang - kadang tak terkendali</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'bab')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'bab')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">2</th>
                               <th rowspan="4" style="vertical-align: middle;">Mengendalikan Rangsang Berkemih (BAK)</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_bak', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tak Terkendali/ Tak Teratur (Perlu Pencahar)</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'bak')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Kadang - kadang tak terkendali (1 x 24 jam)</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'bak')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'bak')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="3" style="vertical-align: middle; text-align: center;">3</th>
                               <th rowspan="3" style="vertical-align: middle;">Membersihkan diri (Cuci Muka, Sisir Rambut, Sikat Gigi)</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="3" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_kebersihanmandiri', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Butuh Pertolongan Orang Lain</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'kebersihan')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'kebersihan')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">4</th>
                               <th rowspan="4" style="vertical-align: middle;">Penggunaan Jamban, Masuk dan Keluar (Melepaskan, memakai celana, membersihkan, menyiram)</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_pengunaanjamban', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tergantung Pertolongan Orang Lain</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'penggunaanjamban')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Perlu Pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yang lain</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'penggunaanjamban')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'penggunaanjamban')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">5</th>
                               <th rowspan="4" style="vertical-align: middle;">Makan</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_makan', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tidak Mampu</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'makan')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Perlu ditolong memotong makanan</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'makan')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'makan')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">6</th>
                               <th rowspan="4" style="vertical-align: middle;">Berubah sikap dari berbaring ke duduk</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_sikap', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Perlu banyak bantuan untuk bisa duduk (2 orang)</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'sikap')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Bantung (2 Orang)</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'sikap')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'sikap')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="5" style="vertical-align: middle; text-align: center;">7</th>
                               <th rowspan="5" style="vertical-align: middle;">Berpindah / Berjalan</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="5" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_berpindah', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tidak Mampu</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'pindah')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Bisa (Pindah) dengan kursi roda</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'pindah')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Berjalan dengan bantuan 1 orang</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'pindah')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('3',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(3,'pindah')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">8</th>
                               <th rowspan="4" style="vertical-align: middle;">Memakai Baju</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_baju', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tergantung Orang Lain</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'baju')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Sebagian dibantu (Misalnya: mengancing baju)</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'baju')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'baju')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;">9</th>
                               <th rowspan="4" style="vertical-align: middle;">Naik Turun Tangga</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="4" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_naikturuntangga', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tidak Mampu</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'tangga')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Butuh Pertolongan</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'tangga')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('2',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(2,'tangga')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th rowspan="3" style="vertical-align: middle; text-align: center;">10</th>
                               <th rowspan="3" style="vertical-align: middle;">Mandi</th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th style="border-width: 0px; padding: 0px;"></th>
                               <th rowspan="3" style="vertical-align: middle; text-align: center;"><?php echo $form->textField($modBarthelindex, 'skor_mandi', array('class' => 'span1 integer numbersOnly skinningfungsionaladl_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                             <th>Tergantung Orang Lain</th>
                             <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(0,'mandi')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                             <th>Mandiri</th>
                             <th><?php echo CHtml::htmlButton('1',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnAdl(1,'mandi')",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                           </tr>
                           <tr>
                               <th colspan="3" style="text-align: center;">TOTAL SKOR</th>
                               <th colspan="2" style="text-align: center;"> <?php echo $form->textField($modAsesmenawalkeperawatanT,'skrinningfungsional_jumlah_skor', array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                           </tr>
                           <tr>
                               <th style="text-align: center;" colspan="3">KETERANGAN SKOR</th>
                               <th colspan="2" style="text-align: center;"> <?php echo $form->textField($modAsesmenawalkeperawatanT,'skrinningfungsional_keterangan', array('class'=>' span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?> </th>
                           </tr>
                       </table>
                   </div>
                </div>
              </div>
          </div>
      </div>
    </div>


</div>
