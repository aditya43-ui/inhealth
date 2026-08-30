<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered" id="tabel_lampiran">
            <thead>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="6" style="color: #303641 !important; font-size: 12px; font-weight: bold; text-align: center">Penawaran</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="3" style="color: #303641 !important; font-size: 12px; font-weight: bold; text-align: center">Harga Penawaran</td>
                    <td colspan="3" style="color: #303641 !important; font-size: 12px; font-weight: bold; text-align: center">Harga Setelah Negosiasi</td>
                </tr>
                <tr>
                    <th style="text-align: center; vertical-align: middle">No.</th>
                    <th style="text-align: center; vertical-align: middle">Nama Barang/Jasa</th>
                    <th style="text-align: center; vertical-align: middle">Volume</th>
                    <th style="text-align: center; vertical-align: middle">Satuan</th>
                    <th style="text-align: center; vertical-align: middle">Harga Satuan (Rp)</th>
                    <th style="text-align: center; vertical-align: middle">Pajak (%)</th>
                    <th style="text-align: center; vertical-align: middle">Jumlah Harga (Rp)</th>
                    <th style="text-align: center; vertical-align: middle">Harga Satuan (Rp)</th>
                    <th style="text-align: center; vertical-align: middle">Pajak (%)</th>
                    <th style="text-align: center; vertical-align: middle">Jumlah Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalpenawaran = 0;
                $totalnegosiasi = 0;
                $jumlahpenawaran = 0;
                $jumlahnegosiasi = 0;
                $ppnpenawaran = 0;
                if (count($modDet)) {
                    foreach ($modDet as $key => $value) {
                        $modelDetail = new PenawaranpenyediadetT;
                        if (!isset($value->penawaranpenyediadet_id)) {
                            $modelDetail->barang_id = $value->barang_id;
                            $modelDetail->jenis_barang = $value->jenis_barang;
                            $modelDetail->satuan_barang = $value->persiapanpengadaandet_satuan;
                            $modelDetail->nama_barang = $value->persiapanpengadaandet_nama;
                            $modelDetail->jumlah_barang = number_format($value->persiapanpengadaandet_volume, 2, ',', '.');
                            $modelDetail->harga_penawaran = number_format($value->harga_estimasi, 2, ",", ".");
                            $modelDetail->jumlah_penawaran = number_format($value->jumlah_harga, 2, ",", ".");
                            $modelDetail->harga_negosiasi = number_format($value->harga_estimasi, 2, ",", ".");
                            $modelDetail->jumlah_negosiasi = number_format($value->jumlah_harga, 2, ",", ".");
                            $modelDetail->pajak_penawaran = number_format($value->pajak_persen, 2, ',', '.');
                            $modelDetail->pajak_negosiasi = number_format($value->pajak_persen, 2, ',', '.');
                            $modelDetail->dokumenpelaksanaananggarandet_id = $value->dokumenpelaksanaananggarandet_id;
                        } else {
                            $modelDetail->attributes = $value->attributes;
                            $modelDetail->penawaranpenyediadet_id = $value->penawaranpenyediadet_id;
                            $modelDetail->harga_penawaran = number_format($modelDetail->harga_penawaran, 2, ",", ".");
                            $modelDetail->jumlah_penawaran = number_format($value->jumlah_penawaran, 2, ",", ".");
                            $modelDetail->harga_negosiasi = number_format($value->harga_negosiasi, 2, ",", ".");
                            $modelDetail->jumlah_barang = number_format($value->jumlah_barang, 2, ",", ".");
                            $modelDetail->jumlah_negosiasi = number_format($value->jumlah_negosiasi, 2, ",", ".");
                            $modelDetail->pajak_penawaran = number_format($value->pajak_penawaran, 2, ',', '.');
                            $modelDetail->pajak_negosiasi = number_format($value->pajak_negosiasi, 2, ',', '.');
                            $modelDetail->dokumenpelaksanaananggarandet_id = $value->dokumenpelaksanaananggarandet_id;
                        }

                        echo "
                        <tr>
                            <td>".
                                ($key+1).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']penawaranpenyediadet_id', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']barang_id', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']jenis_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']nama_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']satuan_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']jumlah_barang', array('class'=>'span3 volume integer-decimal', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']pajak_penawaran', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']pajak_negosiasi', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']dokumenpelaksanaananggarandet_id', array('class'=>'span3', 'readonly'=>true))
                            ."</td>
                            <td>".$modelDetail->nama_barang."</td>
                            <td>".$modelDetail->jumlah_barang."</td>
                            <td>".$modelDetail->satuan_barang."</td>
                            <td style='text-align: center;'>".CHtml::activeTextField($modelDetail, '['.$key.']harga_penawaran', array('class'=>'span2 integer-decimal harga_penawaran', 'onblur' =>'hitungPenawaran();'))."</td>
                            <td style='text-align: center;'>".CHtml::activeTextField($modelDetail, '['.$key.']pajak_penawaran', array('class'=>'span2 integer-decimal  pajak_penawaran', 'readonly'=>false, 'onblur' =>'hitungPenawaran(); cekPembulatan();'))."</td>
                            <td style='text-align: center;'>".CHtml::activeTextField($modelDetail, '['.$key.']jumlah_penawaran', array('class'=>'span2 integer-decimal jumlah_penawaran', 'readonly'=>false, 'onblur' => 'hitungJumlahPenawaran(this)'))."</td>
                            <td style='text-align: center;'>".CHtml::activeTextField($modelDetail, '['.$key.']harga_negosiasi', array('class'=>'span2 integer-decimal harga_negosiasi', 'onblur' =>'hitungNegosiasi();cekNegosiasi();'))."</td>
                            <td style='text-align: center;'>".CHtml::activeTextField($modelDetail, '['.$key.']pajak_negosiasi', array('class'=>'span2 integer-decimal pajak_negosiasi', 'readonly'=>false, 'onblur' =>'hitungNegosiasi(); cekNegosiasi();'))."</td>                
                            <td style='text-align: center;'>".CHtml::activeTextField($modelDetail, '['.$key.']jumlah_negosiasi', array('class'=>'span2 integer-decimal jumlah_negosiasi', 'readonly'=>false, 'onblur' => 'hitungJumlahNegosiasi(this)'))."</td>                
                        </tr>
                        ";
                    }
                }
                $modPersiapan = PersiapanpengadaanT::model()->findByPk($_GET['id']); 
                if (empty($model->total_penawaran)) {
                    $model->jumlah_penawaran = number_format($modPersiapan->total_harga, 2, ",", ".");
                    $model->jumlah_negosiasi = number_format($modPersiapan->total_harga, 2, ",", ".");
                    $model->pajak_penawaran = number_format($modPersiapan->total_pajak, 2, ",", ".");
                    $model->pajak_negosiasi = number_format($modPersiapan->total_pajak, 2, ",", ".");
                    $model->total_penawaran = number_format($modPersiapan->total_hargaseluruhnya, 2, ",", ".");
                    $model->total_negosiasi = number_format($modPersiapan->total_hargaseluruhnya, 2, ",", ".");
                    $model->pembulatan_penawaran = $model->total_penawaran;
                    $model->pembulatan_negosiasi = $model->total_negosiasi;
                    $model->harga_setelah_negosiasi = $model->pembulatan_negosiasi;                  
                } else {
                    $model->jumlah_penawaran = number_format($model->jumlah_penawaran, 2, ",", ".");
                    $model->jumlah_negosiasi = number_format($model->jumlah_negosiasi, 2, ",", ".");
                    $model->pajak_penawaran = number_format($model->pajak_penawaran, 2, ",", ".");
                    $model->pajak_negosiasi = number_format($model->pajak_negosiasi, 2, ",", ".");
                    $model->total_penawaran = number_format($model->total_penawaran, 2, ",", ".");
                    $model->total_negosiasi = number_format($model->total_negosiasi, 2, ",", ".");
                    $model->pembulatan_penawaran = number_format($model->pembulatan_penawaran, 2, ",", ".");
                    $model->pembulatan_negosiasi = number_format($model->pembulatan_negosiasi, 2, ",", ".");
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5"></th>
                    <th style="text-align: right">Jumlah Harga Sebelum Pajak </th>
                    <th style='text-align:center'><?php echo CHtml::activeTextField($model, 'jumlah_penawaran', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?></th>
                    <th></th>
                    <th style="text-align: right">Jumlah Harga Sebelum Pajak </th>
                    <th style='text-align:center'><?php echo CHtml::activeTextField($model, 'jumlah_negosiasi', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?></th>
                </tr>
                <tr>
                    <th colspan="5"></th>
                    <th style="text-align: right">Pajak</th>
                    <th style='text-align:center'><?php echo CHtml::activeTextField($model, 'pajak_penawaran', array('class' => 'span2 integer-decimal pajak_penawaran', 'readonly' => true)); ?></th>
                    <th></th>
                    <th style="text-align: right">Pajak</th>
                    <th style='text-align:center'><?php echo CHtml::activeTextField($model, 'pajak_negosiasi', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?></th>
                </tr>
                <tr>
                    <th colspan="5"></th>
                    <th style="text-align: right">Total</th>
                    <th style='text-align:center'><?php echo CHtml::activeHiddenField($model, 'pembulatan_penawaran', array('class' => 'span2 integer-decimal', 'readonly' => true, 'onblur' =>'cekPenawaran();')).
                                                             CHtml::activeTextField($model, 'total_penawaran', array('class' => 'span2 integer-decimal', 'readonly' => true)) ?></th>
                    <th></th>
                    <th style="text-align: right">Total</th>
                    <th style='text-align:center'><?php  echo CHtml::activeHiddenField($model, 'pembulatan_negosiasi', array('class' => 'span2 integer-decimal', 'readonly' => true, 'onblur' =>'cekNegosiasi();')) . 
                                                              CHtml::activeTextField($model, 'total_negosiasi', array('class' => 'span2 integer-decimal', 'readonly' => true)) ?></th>
                </tr>
            </tfoot>
        </table>
        <?php echo $form->textFieldRow($model, 'selisih_harga', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
    </div>
</div>