<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang / Jasa </th>
                    <th>Jumlah </th>
                    <th>Satuan</th>
                    <th style="text-align: right">Harga Satuan (Rp)</th>
                    <th style="text-align: right">Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_perintah = $sisa_pembayaran = 0;
                $model->jumlah_harga = MyFormatter::formatNumberForPrint($model->jumlah_harga, 2);
                $model->jumlah_pajak = MyFormatter::formatNumberForPrint($model->jumlah_pajak, 2);
                $model->total_harga = MyFormatter::formatNumberForPrint($model->total_harga, 2);
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
                
                $sisa_pembayaran = $model->total_kontrak - $total_perintah;
                $model->total_spp_sebelumnya = MyFormatter::formatNumberForPrint($total_perintah, 2);;
                $model->sisa_pembayaran = MyFormatter::formatNumberForPrint($sisa_pembayaran, 2);
                $model->total_kontrak = MyFormatter::formatNumberForPrint($model->total_kontrak , 2);
                
                $modRincian = PerintahpengirimandetT::model()->findAllByAttributes(array('perintahpengiriman_id' => $model->perintahpengiriman_id));
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modRincian)) {
                    $i = 1;
                    foreach ($modRincian as $key => $value) {
                        ?>
                        <tr>
                            <td style="text-align: center"> <?php echo $i++; ?></td>
                            <td> <?php echo $value['barang_nama'] ?></td>
                            <td style="text-align: center"> <?php echo $value['barang_jumlah'] ?></td>
                            <td style="text-align: center"> <?php echo $value['barang_satuan'] ?></td>
                            <td style="text-align: right"> <?php echo MyFormatter::formatUang($value['harga_satuan'], "Rp.", 2) ?></td>
                            <td style="text-align: right"> <?php echo MyFormatter::formatUang($value['jumlah_harga'], "Rp.", 2) ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
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