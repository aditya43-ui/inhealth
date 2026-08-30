<div class="row-fluid">
     <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title"><strong>Skrinning Status Fungsional</strong></div>
        </div>
         <div class="panel-body">
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
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMakan_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_makan', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                        </tr>
                         <tr>
                            <th>2</th>
                            <th>Aktifitas di Toilet</th>
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnToilet_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnToilet_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_aktifitastoilet', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>3</th>
                            <th>Berpindah dari roda ke tempat tidur/ sebaliknya, termasuk duduk di tempat tidur</th>
                            <th style="text-align: center;">5-10</th>
                            <th><?php echo CHtml::htmlButton('15',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnRodaTidur_dws(15)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_berpindahkursi', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>4</th>
                            <th>Kebersihan diri, mencuci muka, menyisir rambut, menggosok gigi</th>
                            <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnGosokGigi_dws(0)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnGosokGigi_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_kebersihanmandiri', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>5</th>
                            <th>Mandi</th>
                            <th><?php echo CHtml::htmlButton('0',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMandi_dws(0)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnMandi_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_mandi', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>6</th>
                            <th>Berjalan di permukaan dasar</th>
                              <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerjalanDasar_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('15',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerjalanDasar_dws(15)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_berjalanpermukaankasar', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>7</th>
                            <th>Naik turun tangga</th>
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnNaikTangga_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnNaikTangga_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_naikturuntangga', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>8</th>
                            <th>Berpakaian</th>
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerpakaian_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerpakaian_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_berpakaian', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                         <tr>
                            <th>9</th>
                            <th>Mengontrol defekasi</th>
                            <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnDefekasi_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnDefekasi_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_mengontroldefekasi', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

                         </tr>
                        <tr>
                            <th>10</th>
                            <th>Mengontrol Berkemih</th>
                              <th><?php echo CHtml::htmlButton('5',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerkemih_dws(5)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo CHtml::htmlButton('10',array('class'=>'btn btn-default', 'type'=>'button','onclick'=>"klikBtnBerkemih_dws(10)",'style'=>'width:100%; height:100%; background-color: #d1d1d1')); ?></th>
                            <th><?php echo $form->textField($modAsesmenawalkeperawatanT, 'skrinningfungsional_skor_mengontrolberkemih', array('class' => 'span1 integer numbersOnly skinningfungsional_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup"=>'skorskrinningfungsional_dws();', 'maxlength' => 10)); ?> </th>

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
