<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Uraian Pekerjaan</th>
                    <th> Satuan </th>
                    <th> Volume </th>
                    <th> Harga Satuan <br> (Rp) </th>
                    <th> Jumlah Harga <br> (Rp) </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $modDetail = BaserahterimadetT::model()->findAllByAttributes(array('baserahterima_id'=>$model->baserahterima_id));
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modDetail)) {
                    foreach ($modDetail as $key => $value) {
                        echo "
                        <tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $value->nama_barang . "</td>
                            <td>" . $value->satuan_barang . "</td>
                            <td style=\"text-align: right\">" . $value->jumlah_barang . "</td>
                           
                            <td style=\"text-align: right\">" . number_format((float)$value->harga_satuan,2,",",".") . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->jumlah_barang * $value->harga_satuan,2,",",".") . "</td>
                        </tr>
                        ";
                        
                    }
                }

                $jumlah = $model->jumlah_harga;
                $ppn = $model->jumlah_pajak;
                
                $split = explode('.', $model->total_pembayaran);
                $terbilang_koma = '';           
                if (isset($split[1])){
                    $terbilang_koma = ' koma '.MyFormatter::kataTerbilang($split[1]);
                }
                ?>
            </tbody>
             <tfoot>
                <tr>
                    <td colspan="4" rowspan="5"> Terbilang : <?php echo !empty($model->total_pembayaran) ? ucwords(MyFormatter::kataTerbilang($model->total_pembayaran).$terbilang_koma). ' rupiah' : 'Nol rupiah'; ?></td> 
                    <td  style="text-align: right"> Jumlah: </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$model->jumlah_harga,2,",",".") 
                        ?>
                    </td>
                </tr>
                <tr>
                    
                    <td  style="text-align: right"> PPN 10% :  </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$model->jumlah_pajak,2,",",".") 
                        ?>
                    </td>
                </tr>
                <tr>
                    
                    <td  style="text-align: right"> Total :  </td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$model->total_harga,2,",",".")
                       
                        ?>
                    </td>
                </tr>
                <tr>
                    <td  style="text-align: right">Dibulatkan :</td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)round($model->total_dibulatkan),2,",","."); 
                        ?>
                    </td>
                </tr>
                <?php
               
                if (!empty($modSurat->istermin)) {
                ?>
                    
                
                <tr>
                    
                    <td  style="text-align: right"><?php echo "Termin ".$model->terminke." (".$model->termin_persen."%) :"?></td>
                    <td style="text-align: right">
                        <?php
                         echo  number_format((float)$model->total_pembayaran,2,",",".");
                        
                        ?>
                    </td>
                </tr>
                <?php } ?>
            </tfoot>
        </table>
    </div>
</div>