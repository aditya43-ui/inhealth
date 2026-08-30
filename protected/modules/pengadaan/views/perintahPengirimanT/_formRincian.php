<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered" id="tabelRincian">
            <thead>
                <tr>
                    <th style="text-align: center">No.</th>
                    <th style="text-align: center" width="30%">Nama Barang / Jasa </th>
                    <th style="text-align: center">Jumlah </th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Harga Satuan (Rp)</th>
                    <th style="text-align: center">Pajak (Rp)</th>
                    <th style="text-align: center">Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $model->total_kontrak  = 0;
                $total_perintah = $sisa_pembayaran = 0;
                $modSPK = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id);
                if (!empty($modSPK)) {
                    $model->total_kontrak = $modSPK->nilaikontrak;
                    $crit = new CDbCriteria();
                    if (!empty($model->perintahpengiriman_id)) {
                        $crit->addCondition('perintahpengiriman_id != '.$model->perintahpengiriman_id);
                    }
                    $crit->addCondition('suratperjanjiankerja_id = '.$model->suratperjanjiankerja_id);
                    $modPerintah = PerintahpengirimanT::model()->findAll($crit);
                    if(!empty($modPerintah)){
                        foreach($modPerintah as $data){
                            $total_perintah += $data['total_harga'];
                        }
                    }
                }
                
                $model->jumlah_harga = !empty($model->jumlah_harga) ? MyFormatter::formatNumberForPrint($model->jumlah_harga, 2) : "0";
                $model->jumlah_pajak = !empty($model->jumlah_pajak) ? MyFormatter::formatNumberForPrint($model->jumlah_pajak, 2) : "0";
                $model->total_harga = !empty($model->total_harga) ? MyFormatter::formatNumberForPrint($model->total_harga, 2) : "0";
                $model->total_dibulatkan = !empty($model->total_dibulatkan) ? MyFormatter::formatUang($model->total_dibulatkan, 2) : "0";
                
                $sisa_pembayaran = $model->total_kontrak - $total_perintah;
                $model->total_spp_sebelumnya = MyFormatter::formatNumberForPrint($total_perintah, 2);;
                $model->sisa_pembayaran = MyFormatter::formatNumberForPrint($sisa_pembayaran, 2);
                $model->total_kontrak = MyFormatter::formatNumberForPrint($model->total_kontrak , 2);
                
                if (!empty($model->perintahpengiriman_id)) {
                    $modRincian = PerintahpengirimandetT::model()->findAllByAttributes(array('perintahpengiriman_id' => $model->perintahpengiriman_id));
                } else {
                    $modRincian = SuratperjanjiankerjarincianT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                }
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modRincian)) {
                    $i = 1;
                    foreach ($modRincian as $key => $value) {
                        if (!empty($value['perintahpengirimandet_id'])) {
                            $modelDetail = PerintahpengirimandetT::model()->findByPk($value['perintahpengirimandet_id']);
                        } else {
                            $modelDetail = new PerintahpengirimandetT();
                            $modelDetail->harga_satuan = $value->barang_harga;
                            $modelDetail->jumlah_harga = $value->barang_total;
                            $modelDetail->jumlah_pajak = $value->pajak_jumlah;
                            $modelDetail->barang_jumlah = $value->barang_jumlah;
                            $modelDetail->pajak_persen = $value->pajak_persen;
                            $modelDetail->jumlah_pajak = $value->pajak_jumlah;
                        }
                        $modelDetail->barang_nama = $value->barang_nama;
                        $modelDetail->jenis_barang = $value->jenis_barang;
                        $modelDetail->barang_satuan = $value->barang_satuan;
                        $modelDetail->barang_id = $value->barang_id;
                        $modelDetail->suratperjanjiankerjarincian_id = $value->suratperjanjiankerjarincian_id;
                        $sebelum_pajak = $harga_satuan = $barang_jumlah = 0;
                        $harga_satuan = $modelDetail->harga_satuan;
                        $barang_jumlah = $modelDetail->barang_jumlah;
                        $sebelum_pajak = $harga_satuan * $barang_jumlah;
                        $modelDetail->harga_satuan = MyFormatter::formatNumberForPrint($modelDetail->harga_satuan, 2);
                        $modelDetail->jumlah_harga = MyFormatter::formatNumberForPrint($modelDetail->jumlah_harga, 2);
                        $modelDetail->jumlah_pajak = MyFormatter::formatNumberForPrint($modelDetail->jumlah_pajak, 2);
                        $modelDetail->barang_jumlah = MyFormatter::formatNumberForPrint($modelDetail->barang_jumlah, 2);
                        $modelDetail->pajak_persen = MyFormatter::formatNumberForPrint($modelDetail->pajak_persen, 2);
                        $modelDetail->sebelum_pajak = MyFormatter::formatNumberForPrint($sebelum_pajak, 2);
                        ?>
                        <tr>
                            <td style="text-align: center"> <label> <?php echo $i++; ?>.</label></td>
                            <td> <label> <?php echo $value['barang_nama'] ?> </label>
                                <?php
                                echo CHtml::activeHiddenField($modelDetail, '[0]barang_nama', array('class' => 'span2')) .
                                CHtml::activeHiddenField($modelDetail, '[0]jenis_barang', array('class' => 'span2')) .
                                CHtml::activeHiddenField($modelDetail, '[0]barang_id', array('class' => 'span2')) .
                                CHtml::activeHiddenField($modelDetail, '[0]perintahpengirimandet_id', array('class' => 'span2')) .
                                CHtml::activeHiddenField($modelDetail, '[0]suratperjanjiankerjarincian_id', array('class' => 'span2'))
                                ?>
                            </td>
                            <td> <?php echo CHtml::activeTextField($modelDetail, '[0]barang_jumlah', array('onblur' => 'hitungJumlahBaris(this)', 'class' => 'span2 barang_jumlah integer-decimal', 'readonly' => false)) ?></td>
                            <td> <?php echo CHtml::activeTextField($modelDetail, '[0]barang_satuan', array('class' => 'span2 barang_satuan', 'readonly' => true)) ?></td>
                            <td> <?php echo CHtml::activeTextField($modelDetail, '[0]harga_satuan', array('onblur' => 'hitungJumlahBaris(this)', 'class' => 'span2 harga_satuan integer-decimal', 'readonly' => false)) ?></td>
                            <td> <?php
                                echo CHtml::activeTextField($modelDetail, '[0]pajak_persen', array('onblur' => 'hitungJumlahBaris(this)', 'class' => 'span2 pajak_persen integer-decimal', 'readonly' => false)) .
                                CHtml::activeHiddenField($modelDetail, '[0]jumlah_pajak', array('class' => 'span2 jumlah_pajak integer-decimal', 'readonly' => false));
                                ?></td>
                            <td> <?php
                                echo CHtml::activeTextField($modelDetail, '[0]jumlah_harga', array('onblur' => 'hitungHargaBaris(this)', 'class' => 'span3 jumlah_harga integer-decimal', 'readonly' => false)) .
                                CHtml::activeHiddenField($modelDetail, '[0]sebelum_pajak', array('class' => 'span3 sebelum_pajak integer-decimal', 'readonly' => false))
                                ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="col-md-6">
            <?php
            echo $form->textFieldRow($model, 'jumlah_harga', array('class' => 'jumlah_harga span3 integer-decimal', 'readonly' => true));
            echo $form->textFieldRow($model, 'jumlah_pajak', array('class' => 'jumlah_pajak span3 integer-decimal', 'readonly' => true));
            echo $form->textFieldRow($model, 'total_harga', array('class' => 'total_harga span3 integer-decimal', 'readonly' => true));
            ?>
            <?php
            $model->total_pembayaran = MyFormatter::formatNumberForPrint($model->total_pembayaran, 2);
            if (!empty($model->terminke)) {
                $modSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id']));
                $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id, 'terminke' => $model->terminke));
                if (!empty($modTermin) && $modTermin->jumlah_persen != 100) {
                    $model->total_pembayaran = $modTermin->jumlah_persen * $modSPK->total_pembulatan / 100;
                    $model->total_pembayaran = MyFormatter::formatNumberForPrint($model->total_pembayaran, 2);
                    ?>
                    <div class="control-group">
                        <label class="control-label">  <b> Termin <?php echo $modTermin->terminke . " (" . $modTermin->jumlah_persen . " %)"; ?></b>  </label>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'total_pembayaran', array('class' => 'total_pembayaran span3 integer-decimal', 'readonly' => true)); ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php echo CHtml::activeHiddenField($model, 'total_pembayaran', array('class' => 'total_pembayaran span3 integer-decimal', 'readonly' => true)); ?>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div class="control-group">
                <label class="control-label"> Total Kontrak </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'total_kontrak', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> Total SPP Sebelumnya </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'total_spp_sebelumnya', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> Sisa Pembayaran </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'sisa_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>