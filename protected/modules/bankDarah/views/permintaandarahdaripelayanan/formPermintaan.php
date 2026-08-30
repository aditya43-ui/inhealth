
<div class="row-fluid" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Formulir Permintaan','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modPermintaanDarah,'no_permintaandarah',array('readonly'=>true, 'class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->radioButtonListInlineRow($modPermintaanDarah, 'jenispermintaan', LookupM::getItems('jenispermintaan'), array('class' => 'reqPasien jenispermintaan', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label('Kadar HB','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('kadarhb','', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('PLT','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('plt','', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Jenis/Komponen Darah <span class='required'>*</span>",'komponendarah_id', array('class'=>'control-label')) ?>
            <div class = "controls"> 
                <?php echo CHtml::dropDownList('jeniskomponendarah_id','', CHtml::listData(JeniskomponendarahM::model()->findAll('jeniskantongdarah_aktif is true'),'jeniskomponendarah_id','jeniskomponenedarah_nama'),array('class'=>'span3','empty'=>'-- Pilih --')) ?>
            </div>
            <div class="controls">
            <?php
                echo CHtml::htmlButton('Tambah', 
                    array('onclick' => 'inputDetail(this);',
                        'class' => 'btn btn-primary',
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Kedalam Table",));
                ?>
            </div>
        </div>
        <div class = "control-group">
            <?php /* echo Chtml::label("Golongan Darah",'komponendarah_id', array('class'=>'control-label')) */ ?>
            <div class = "controls">
                <?php echo CHtml::hiddenField('gol_darah_detail','',array('readonly'=>true)); ?>
                <?php /* echo CHtml::hiddendropDownList('gol_darah_detail','',  array("A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"),array('empty'=>'-- Pilih --')) */?>
            </div>
        </div>
       
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jumlah(Kantong) <span class="required">*<span>','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('jumlahkantong_detail','',array('class'=>'span1 numbers-only')); ?>
            </div>
            <div class="controls">
                <?php echo CHtml::dropDownList('jenis_volume','LABU', LookupM::getItems('jenis_volume'),array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Diambil','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::numberField('diambil','',array('class'=>'span1 numbers-only')); ?>
            </div>
            <div class="controls">
                <?php echo CHtml::dropDownList('jenis_volume_diambil','LABU', LookupM::getItems('jenis_volume'),array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dititip','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::numberField('dititip','',array('class'=>'span1 numbers-only')); ?>
            </div>
            <div class="controls">
                <?php echo CHtml::dropDownList('jenis_volume_dititip','LABU', LookupM::getItems('jenis_volume'),array('class'=>'span3')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label("Indikasi <span class='required'>*<span>",'', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo CHtml::dropDownList('indikasi_detail','',  array("Anemia"=>"Anemia","Perdarahan"=>"Perdarahan","Gangguan Pembekuan darah"=>"Gangguan Pembekuan darah","Lain-lain"=>"Lain-lain"),array('empty'=>'-- Pilih --', 'class' => 'span3')) ?>
            </div>
        </div>  
    </div>
</div>

