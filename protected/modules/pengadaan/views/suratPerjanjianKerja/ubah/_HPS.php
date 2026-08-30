<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Rincian Pekerjaan </b></div>
        <span style="float:right; padding: 10px" >
            <?php echo CHtml::link("<i class='fa fa-download' style='font-size: 16px;'></i>", Yii::app()->createUrl('pengadaan/suratPerjanjianKerja/unduhExcel&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-info', 'data-placement' => 'left', "rel" => "tooltip", "title" => "Klik untuk Download Rincian Pekerjaan")); ?>
            <?php echo CHtml::link("<i class='fa fa-upload' style='font-size: 16px;'></i>", Yii::app()->createUrl('pengadaan/suratPerjanjianKerja/loadformImport&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-info', 'data-placement' => 'left', "rel" => "tooltip", "title" => "Klik untuk Upload Rincian Pekerjaan", "target" => "iframe3", "onclick" => "$('#dialogUpload').dialog('open');")); ?>
        </span>
    </div>
    <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>
    <?php
    $konfig = KonfigsystemK::model()->find();
    $total_harga = MyFormatter::formatNumberForDb($model->total_hargaseluruhnya);
    if ($total_harga < 10000000) {        
        $readonlyHPS = false;        
    } else {
        $readonlyHPS = false;
    }
    
    ?>
    <div class="panel-body">   
        <div class="overflow-x">
            <table class="table table-condensed table-bordered table-striped" id="tabel-hps">
                <thead>
                <th style="text-align: center">No.</th>        
                <th style="text-align: center">Jenis Barang/Jasa <span class="required">*</span></th>
                <th style="text-align: center">Nama SPK <span class="required">*</span> </th>
                <th style="text-align: center">Merk</th>
                <th style="text-align: center">Satuan</th>
                <th style="text-align: center">Volume<span class="required">*</span></th>
                <th style="text-align: center">Harga (Rp)<span class="required">*</span></th>
                <th style="text-align: center">Pajak (%)<span class="required">*</span></th>
                <th style="text-align: center">Ongkos Kirim </th>
                <th style="text-align: center">Jumlah Harga (Rp)<span class="required">*</span></th>
                <th style="text-align: center" class="<?php echo ($readonlyHPS == true) ? 'hide' : ''?>"> Sisa Pagu </th>
                <th style="text-align: center" class="hide <?php echo (!empty($model->persiapanpengadaan_id)) ? 'hide' : ''; ?>">Aksi</th>
                </thead>
                <tbody>
                    <?php
                    $total_pagu = 0; 
                    $cekPerjanjiankerja = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                    if (!empty($cekPerjanjiankerja)) {
                        if (!empty($modDet)) {
                            foreach ($modDet as $i => $d) {
                                
                                $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($d['dokumenpelaksanaananggarandet_id']);
                                $d->sisa_pagu = $modDPA->sisapagu_pengadaan + MyFormatter::formatNumberForDb($model->nilaikontrak,2);
                                $d->sebelum_pajak = $d->barang_harga * $d->barang_jumlah;
                                $d->pajak_persen = MyFormatter::formatNumberForPrint($d->pajak_persen, 2);
                                $d->barang_harga = MyFormatter::formatNumberForPrint($d->barang_harga, 2);
                                $d->ongkos_kirim = MyFormatter::formatNumberForPrint($d->ongkos_kirim, 2);
                                $d->barang_jumlah = MyFormatter::formatNumberForPrint($d->barang_jumlah, 2);
                                $d->barang_total = MyFormatter::formatNumberForPrint($d->barang_total, 2);
                                $d->sebelum_pajak = MyFormatter::formatNumberForPrint($d->sebelum_pajak, 2);
                                $d->jumlah_awal = $d->barang_total;
                                $d->volume_awal = $d->barang_jumlah;
                                $total_pagu += $d->sisa_pagu;
                                echo $this->renderPartial($this->path_view . 'ubah/_rowHPS2', array('model' => $d, 'i' => $i, 'readonlyHPS' => $readonlyHPS), true);
                            }
                        }
                    } else {
                        $cekNegosiasi = BanegosiasiT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id, 'isbatal' => false, 'isaddendum' => true));
                        if (!empty($cekNegosiasi)) {
                            $modPenyedia = PenawaranpenyediaT::model()->findByAttributes(array('penawaranpenyedia_id' => $cekNegosiasi->penawaranpenyedia_id, 'isbatal' => false, 'isaddendum' => true));
                            if (!empty($modPenyedia)) {
                                if (!empty($modDet)) {
                                    foreach ($modDet as $i => $d) {
                                        $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($d['dokumenpelaksanaananggarandet_id']);
                                        $d->sisa_pagu = $modDPA->sisapagu_pengadaan + $d->jumlah_negosiasi;
                                        $d->sebelum_pajak = $d->harga_negosiasi * $d->jumlah_barang;
                                        $d->jumlah_pajak = $d->pajak_negosiasi / 100 * $d->sebelum_pajak;
                                        $d->pajak_negosiasi = MyFormatter::formatNumberForPrint($d->pajak_negosiasi, 2);
                                        $d->harga_negosiasi = MyFormatter::formatNumberForPrint($d->harga_negosiasi, 2);
                                        $d->jumlah_barang = MyFormatter::formatNumberForPrint($d->jumlah_barang, 2);
                                        $d->jumlah_negosiasi = MyFormatter::formatNumberForPrint($d->jumlah_negosiasi, 2);
                                        $d->sebelum_pajak = MyFormatter::formatNumberForPrint($d->sebelum_pajak, 2);
                                        $d->jumlah_pajak = MyFormatter::formatNumberForPrint($d->jumlah_pajak, 2);
                                        $d->jumlah_awal = $d->jumlah_negosiasi;
                                        $d->volume_awal = $d->jumlah_barang;
                                        $total_pagu += $d->sisa_pagu;
                                        echo $this->renderPartial($this->path_view . 'form/_rowHPS3', array('model' => $d, 'i' => $i, 'readonlyHPS' => $readonlyHPS), true);
                                    }
                                }
                            } else {
                                if (!empty($modDet)) {
                                    foreach ($modDet as $i => $d) {
                                        $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($d['dokumenpelaksanaananggarandet_id']);
                                        $d->sisa_pagu = MyFormatter::formatNumberForPrint($d->sisa_pagu);
                                        $d->sebelum_pajak = $d->persiapanpengadaandet_volume * $d->harga_estimasi;
                                        $d->pajak_persen = MyFormatter::formatNumberForPrint($d->pajak_persen, 2);
                                        $d->harga_estimasi = MyFormatter::formatNumberForPrint($d->harga_estimasi, 2);
                                        $d->jumlah_awal = MyFormatter::formatNumberForPrint($d->jumlah_harga, 2);
                                        $d->sebelum_pajak = MyFormatter::formatNumberForPrint($d->sebelum_pajak, 2);
                                        $d->jumlah_pajak = MyFormatter::formatNumberForPrint($d->jumlah_pajak, 2);
                                        $d->volume_awal = $d->persiapanpengadaandet_volume;
                                        $total_pagu += $d->sisa_pagu;
                                        echo $this->renderPartial($this->path_view . 'form/_rowHPS', array('model' => $d, 'i' => $i, 'readonlyHPS' => $readonlyHPS), true);
                                    }
                                }
                            }
                        } else {
                            if (!empty($modDet)) {
                                foreach ($modDet as $i => $d) {
                                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($d['dokumenpelaksanaananggarandet_id']);
                                    $d->sisa_pagu = $modDPA->sisapagu_pengadaan + $d->jumlah_harga;
                                    $sisa_pagu = $d->sisa_pagu;
                                    $d->volume_awal = $d->persiapanpengadaandet_volume;
                                    $d->sebelum_pajak = $d->persiapanpengadaandet_volume * $d->harga_estimasi;
                                    $d->pajak_persen = MyFormatter::formatNumberForPrint($d->pajak_persen, 2);
                                    $d->harga_estimasi = MyFormatter::formatNumberForPrint($d->harga_estimasi, 2);
                                    $d->jumlah_harga = MyFormatter::formatNumberForPrint($d->jumlah_harga, 2);
                                    $d->jumlah_awal = $d->jumlah_harga;
                                    $d->jumlah_pajak = MyFormatter::formatNumberForPrint($d->jumlah_pajak, 2);
                                    $d->sebelum_pajak = MyFormatter::formatNumberForPrint($d->sebelum_pajak, 2);
                                    $d->sisa_pagu = MyFormatter::formatNumberForPrint($d->sisa_pagu, 2);
                                    $total_pagu += $sisa_pagu;
                                    echo $this->renderPartial($this->path_view . 'form/_rowHPS', array('model' => $d, 'i' => $i, 'readonlyHPS' => $readonlyHPS), true);
                                }
                            }
                        }
                    } 
                    $total_pagu = MyFormatter::formatNumberForPrint($total_pagu, 2);
                    ?>
                </tbody>
            </table>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls"  style="width: 125px;">
                    <label style="margin-right: 10px;"> Jumlah Harga </label>
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'jumlah_harga', array('readonly' => true, 'class' => 'span3 required integer-decimal harga'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls"  style="width: 125px;">
                    <label style="margin-right: 10px;"> Jumlah Pajak </label>
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'jumlah_pajak', array('readonly' => true, 'class' => 'span3 required integer-decimal harga'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls"  style="width: 125px;">
                    <label style="margin-right: 10px;"> Total Harga</label>
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'total_hargaseluruhnya', array('readonly' => true, 'class' => 'span3 required integer-decimal harga', 'onblur' => 'hitungTermin()'));
                    ?>
                    <?php
                    echo $form->hiddenField($model, 'total_pembulatan', array(
                        'readonly' => true,
                        'class' => 'span3 integer-decimal',
                        'value' => $model->total_pembulatan,
                        'onblur' => 'hitungTermin();',
                    ));                    
                    ?>
                </div>
            </div>
            <?php if(empty($model->suratperjanjiankerja_id)) { ?>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <label>Total Pagu</label> 
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'total_pagu', array('readonly' => true, 'value' => $total_pagu, 'class' => 'span3 required integer-decimal'));
                    ?>
                </div>
            </div>
            <?php } ?>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <?php echo $form->checkBox($model, 'isuangmuka', array('onclick' => 'setUangMuka(this)', 'class' => 'span1', 'rel' => 'tooltip', 'title' => 'Klik untuk menambahkan uang muka')) ?>
                    <label style="margin-right: 10px;"> Uang Muka </label>
                </div>
                <div class="controls uang-muka" hidden="true">
                    <?php echo $form->textField($model, 'uangmuka_persen', array('class' => 'span2 integer-decimal', 'onblur' => 'hitungUangMuka();')) ?> <label> % </label>
                </div>
                <div class="controls uang-muka" hidden="true">
                    <?php echo $form->textField($model, 'uangmuka_jumlah', array('class' => 'span3 integer-decimal', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls"  style="width: 125px;">
                    <?php echo $form->checkBox($model, 'istermin', array('onclick' => 'setJenis(this);', 'class' => 'span1', 'rel' => 'tooltip', 'title' => 'Klik untuk menambahkan termin')) ?>
                    <label> Termin </label>
                </div>
                <div class="controls">
                    <div id="jenistermin" style="display: block">
                        <?php echo CHtml::activeDropDownList($model, 'jenis_termin', CHtml::listData(LookupM::model()->findAll("lookup_type = 'jenistermin' AND lookup_aktif IS TRUE ORDER BY lookup_urutan ASC"), 'lookup_name', 'lookup_name'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => "showHideTabel(this);")); ?>
                    </div>
                </div>
                <div class="controls">
                    <div id="jumlahbaris" style="display: none">
                        <?php echo CHtml::activeTextField($modTermin2, 'jumlah_termin', array('class' => 'span1', 'onchange' => 'tambahBarisPeriodikal();')); ?> kali
                    </div>
                </div>
            </div>
            <div class="control-group" id="form-termin">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <?php $this->renderPartial($this->path_view . '_termin', array('model' => $model, 'form' => $form, 'modTermin' => $modTermin)); ?> 
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls"  style="width: 125px;"> 
                    <?php echo CHtml::label('', '', array('class' => 'span1')) ?>
                    <label> Catatan </label>  </div>
                <div class="controls"> 
                    <?php echo $form->textArea($model, 'suratperjanjiankerja_catatan', array('row' => '5', 'class' => 'span6')) ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo CHtml::hiddenField("tampung_id", '', array('readonly' => true)); ?>
</div>