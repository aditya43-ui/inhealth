<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<style>
    .table th {
        border: 1px solid;
        padding: 2px;
        background-color: none;
        text-align: center;
        border: 1px solid black !important;
    }
    .table td{
        border: 1px solid;
        padding: 2px;
        background-color: none;
        border: 1px solid black !important;
    }
    
    .table {
        width: 100%;
        border: none;
        box-shadow: none;
        border-collapse: collapse;
    }
</style>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="text-align:center;" align="center"><b>Pembayaran Jasa Medis</b></td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="150">Telah Bayar Kepada</td>
                        <td>:&nbsp;<?php echo $modBuktiKeluar->namapenerima; ?></td>
                        <td>No. BKK</td>
                        <td width="25%">: &nbsp;<?php echo $modBuktiKeluar->nokaskeluar; ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<?php echo MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar);?></td>
                        <td>Tanggal BKK</td>
                        <td>: &nbsp;<?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>:<i>&nbsp;<?php echo MyFormatter::formatNumberTerbilang($modBuktiKeluar->jmlkaskeluar); ?> Rupiah</i></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Uraian</th>
                            <th width="70" style="text-align:center;">Volume</th>
                            <th width="100" style="text-align:center;">Satuan</th>
                            <th width="150" style="text-align:center;">Harga</th>
                            <th width="150" style="text-align:center;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $rows = '';
                            $total = 0;
							$modUraian = UraiankeluarumumT::model()->findAllByAttributes(array('pengeluaranumum_id'=>$modBuktiKeluar->pengeluaranumum_id));
                            if(count((array)$modUraian) > 0){
                                $rows = '';
                                foreach($modUraian as $val)
                                {
                                    $total += $val->totalharga;
                                    $rows .= '<tr>';
                                    $rows .= '<td>'.$val->uraiantransaksi.'</td>';
                                    $rows .= '<td style="text-align: right;">'.$val->volume.'</td>';
                                    $rows .= '<td>'.$val->satuanvol.'</td>';
                                    $rows .= '<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val->hargasatuan).'</td>';
                                    $rows .= '<td style="text-align: right;">'.MyFormatter::formatNumberForPrint($val->totalharga).'</td>';
                                    $rows .= '</tr>';                                    
                                }
                            }else{
                                $rows .= '<tr>';
                                $rows .= '<td colspan="3">data kosong</td>';
                                $rows .= '</tr>';
                            }
                            echo $rows;
                        ?>              
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align: right;">Total Keseluruhan</td>
                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
