<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Rincian Pekerjaan </b></div>
        <span style="float:right; padding: 10px" >
            <?php echo CHtml::link("<i class='fa fa-download' style='font-size: 16px;'></i>", Yii::app()->createUrl('pengadaan/suratPerjanjianKerja/unduhExcel&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-info', 'data-placement' => 'left', "rel" => "tooltip", "title" => "Klik untuk Download Rincian Pekerjaan")); ?>
            <?php echo CHtml::link("<i class='fa fa-upload' style='font-size: 16px;'></i>", Yii::app()->createUrl('pengadaan/suratPerjanjianKerja/loadformImport&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-info', 'data-placement' => 'left', "rel" => "tooltip", "title" => "Klik untuk Upload Rincian Pekerjaan", "target" => "iframe3", "onclick" => "$('#dialogUpload').dialog('open');")); ?>
        </span>
    </div>
    <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>
    <div class="panel-body">   
        <?php echo CHtml::hiddenField("noRow", "", array('readonly' => true)); ?>

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
                <th style="text-align: center">Sisa Pagu (Rp)<span class="required">*</span></th>
                <th style="text-align: center"> Aksi</th>
                </thead>
                <tbody>
                    <?php
                    $total_pagu = 0;
                    $model->jumlah_harga = MyFormatter::formatNumberForPrint($model->jumlah_harga, 2);
                    $model->jumlah_pajak = MyFormatter::formatNumberForPrint($model->jumlah_pajak, 2);
                    $model->total_hargaseluruhnya = MyFormatter::formatNumberForPrint($model->total_pembulatan, 2);
                    $model->total_pembulatan = MyFormatter::formatNumberForPrint($model->total_pembulatan, 2);
                    if (!empty($modDet)) {
                        foreach ($modDet as $i => $detail) {
                            $modSisa = SisapagukontrakV::model()->findByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'dokumenpelaksanaananggarandet_id' => $detail->dokumenpelaksanaananggarandet_id));
                            $detail->barang_jumlah = MyFormatter::formatNumberForPrint($detail->barang_jumlah, 2);
                            $detail->barang_harga = MyFormatter::formatNumberForPrint($detail->barang_harga, 2);
                            $detail->barang_total = MyFormatter::formatNumberForPrint($detail->barang_total, 2);
                            $detail->pajak_jumlah = MyFormatter::formatNumberForPrint($detail->pajak_jumlah, 2);
                            $detail->pajak_persen = MyFormatter::formatNumberForPrint($detail->pajak_persen, 2);
                            $detail->ongkos_kirim = MyFormatter::formatNumberForPrint($detail->ongkos_kirim, 2);
                            $detail->sisa_pagu = MyFormatter::formatNumberForPrint($modSisa->sisapagu_kontrak, 2);
                            $detail->sisa_volume = MyFormatter::formatNumberForPrint($modSisa->sisavolume_kontrak, 2);
                            $detail->jumlah_awal = $detail->barang_total;
                            $detail->volume_awal = $detail->barang_jumlah;
                            $total_pagu += $modSisa->sisapagu_kontrak;
                            $this->renderPartial('_rowHPS', array('model' => $detail, 'i' => $i));
                        }
                    }
                    $total_pagu = MyFormatter::formatNumberForPrint($total_pagu, 2);
                    ?>
                </tbody>
            </table>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <label>Jumlah Harga</label> 
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'jumlah_harga', array('readonly' => true, 'class' => 'span3 required integer-decimal harga'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <label>Jumlah Pajak</label> 
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'jumlah_pajak', array('readonly' => true, 'class' => 'span3 required integer-decimal harga'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <label>Total Harga</label> 
                </div>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'total_pembulatan', array(
                            'readonly' => true,
                            'class' => 'span2 integer-decimal',
                            'value' => $model->total_pembulatan,
                            'onblur' => 'hitungTermin();',
                        ));
                    ?>
                    <?php
                    echo CHtml::activeTextField($model, 'total_hargaseluruhnya', array('readonly' => true, 'class' => 'span3 required integer-decimal harga', 'onblur' => 'hitungTermin()'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <label>Total Pagu</label> 
                </div>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'total_pagu', array('value' => $total_pagu, 'readonly' => true, 'class' => 'span3 required integer-decimal'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls" style="width: 125px;">
                    <?php echo $form->checkBox($model, 'isuangmuka', array('disabled' => true, 'class' => 'span1', 'rel' => 'tooltip', 'title' => 'Klik untuk menambahkan uang muka')) ?>
                    <label style="margin-right: 10px;"> Uang Muka </label>
                </div>
                <?php if ($model->isuangmuka == true) : ?>
                    <div class="controls uang-muka">
                        <?php echo $form->textField($model, 'uangmuka_persen', array('class' => 'span2 integer-decimal', 'readonly' => true, 'onblur' => 'hitungUangMuka();')) ?> <label> % </label>
                    </div>
                    <div class="controls uang-muka">
                        <?php echo $form->textField($model, 'uangmuka_jumlah', array('class' => 'span3 integer-decimal', 'readonly' => true)) ?>
                    </div>
                <?php endif; ?>
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
                    <?php
                    if (!empty($_GET['transaksi'])) {
                        $this->renderPartial($this->path_view . '_termin', array('model' => $model, 'form' => $form, 'modTermin' => $modTermin));
                    } else {
                        ?>
                        <div id="terminKonsultasiPerencanaan" class="span8" style="width:700px; margin-left: 135px;">

                            <table id="tabel-termin"  width="100%" class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Termin&nbsp;Ke</th>
                                        <th style="text-align:center">Persen</th>
                                        <th style="text-align:center">Jumlah Pembayaran</th>
                                        <th style="text-align:center">Tanggal Awal</th>
                                        <th style="text-align:center">Tanggal Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $modCari = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                                    if (!empty($modCari)) {
                                        foreach ($modCari as $det) {
                                            ?>
                                            <tr>
                                                <td style="text-align: center"> <label> <?= $det->terminke ?> </label></td>
                                                <td style="text-align: center"> <label> <?= number_format($det->jumlah_persen, 2, ',', '.') ?> </label></td>
                                                <td style="text-align: right"> <label> <?= number_format($det->jumlah_harga, 2, ',', '.') ?> </label></td>
                                                <td> <label> <?= MyFormatter::formatDateTimeForUser($det->termintanggal_awal) ?> </label></td>
                                                <td> <label> <?= MyFormatter::formatDateTimeForUser($det->termintanggal_akhir) ?> </label></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    <?php } ?> 
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
</div>