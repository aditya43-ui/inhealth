<div class="col-md-6">
    <div class="control-group">
        <div class="controls">
        <?php echo CHtml::label("Persiapan Pengadaan <span class='required'>*</span> ", 'persiapanpengadaan_id', array('class' => 'control-label')) ?>
            <?php
//                $cri = new CDbCriteria();
//                $cri->select = "t.persiapanpengadaan_id, informasipersiapanpengadaan_v.nama_pekerjaan, informasipersiapanpengadaan_v.persiapanpengadaan_nomor";
//                $cri->addCondition('t.supplier_id = '.$model->supplier_id);
////                $cri->addCondition('penawaranpenyedia_t.penawaranpenyedia_id IS NULL');
//                $cri->addCondition('penawaranpenyedia_t.isbatal is false');
//                $cri->addCondition('penawaranpenyedia_t.isaddendum is true');
//                $cri->join = "LEFT JOIN informasipersiapanpengadaan_v ON t.persiapanpengadaan_id = informasipersiapanpengadaan_v.persiapanpengadaan_id "
//                            ."LEFT JOIN penawaranpenyedia_t ON t.persiapanpengadaan_id = penawaranpenyedia_t.persiapanpengadaan_id AND t.supplier_id = penawaranpenyedia_t.supplier_id";
//                $list = InfoumumpengadaanT::model()->findAll($cri);
//                $listData = CHtml::listData(InfoumumpengadaanT::model()->findAll($cri), 'persiapanpengadaan_id', 'persiapanpengadaan_nomor');
//                $listOption = array();
//                foreach($list as $item){
//                    $listOption[$item->persiapanpengadaan_id] = array(
//                        'data-nama' => $item->nama_pekerjaan,
//                    );
//                }
                $criteria = new CDbCriteria();
                $criteria->addCondition('t.isbatal is false');
                $criteria->addCondition('t.isaddendum is true');
                $cekpenawaran = PenawaranpenyediaT::model()->findAll($criteria);
                $id_persiapanpengadaan = array();
                foreach($cekpenawaran as $item){
                    $id_persiapanpengadaan[] = $item->persiapanpengadaan_id;
                }
                
                $criteria2 = new CDbCriteria();
                $criteria2->select = 't.*, infoumumpengadaan_t.supplier_id';
                $criteria2->addCondition('infoumumpengadaan_t.supplier_id = '.$model->supplier_id);
                $criteria2->addNotInCondition('t.persiapanpengadaan_id', $id_persiapanpengadaan);
                $criteria2->join = 'LEFT JOIN infoumumpengadaan_t ON infoumumpengadaan_t.persiapanpengadaan_id = t.persiapanpengadaan_id';
                
                $list = InformasipersiapanpengadaanV::model()->findAll($criteria2);
                $listData = CHtml::listData(InformasipersiapanpengadaanV::model()->findAll($criteria2), 'persiapanpengadaan_id', 'persiapanpengadaan_nomor');
                $listOption = array();
                foreach($list as $item){
                    $listOption[$item->persiapanpengadaan_id] = array(
                        'data-nama' => $item->nama_pekerjaan,
                    );
                }
                echo $form->dropDownList($modPenawaran,'persiapanpengadaan_id',$listData,array('empty'=>'-- Pilih --','class'=>'span4 required','onchange' => 'selectPersiapan(this)' ,
                'onkeypress'=>'return $(this).focusNextInputField(event)', 'options'=>$listOption)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pekerjaan", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($modPenawaran, 'nama_pekerjaan', array('readonly' => true,'class' => 'span4')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Penawaran <span class='required'>*</span>", 'penawaranpenyedia_tanggal', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modPenawaran,
                'attribute' => 'penawaranpenyedia_tanggal',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nomor Surat Penawaran <span class='required'>*</span>", 'penawaranpenyedia_nomorsurat', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_nomorsurat', array('class' => 'span4 required')) ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("File Surat Penawaran <span class='required'>*</span>", 'penawaranpenyedia_file', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->fileField($modPenawaran, 'penawaranpenyedia_file', array('class' => 'required', 'Hint' => 'Isi Jika Akan Menambahkan File lampiran')); ?>
            <p style="color: red">Hanya file dengan ekstensi PDF, Max 3Mb.</p>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Total Harga yang ditawarkan (Rp) <span class='required'>*</span>", 'penawaranpenyedia_harga', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($modPenawaran, 'penawaranpenyedia_harga', array('class' => 'span4 integer2 required')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Keterangan", 'penawaranpenyedia_keterangan', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textArea($modPenawaran, 'penawaranpenyedia_keterangan', array('class' => 'span4')) ?>
        </div>
    </div>
</div>