<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<style>
    .grid th {
        border: 1px solid;
        padding: 2px;
        background-color: transparent;
        text-align: center;
    }
    .grid td{
        border: 1px solid;
        padding: 2px;
        background-color: transparent;
    }
</style>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="text-align:center;" align="center"><b>PENGELUARAN UMUM</b></td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                        <td style="text-align:right;" width="25%" align="right">No. BKK</td>
                        <td width="25%">: &nbsp;<?php echo $modBuktiKeluar->nokaskeluar; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right;" align="right">Tanggal BKK</td>
                        <td>: &nbsp;<?php echo $modBuktiKeluar->tglkaskeluar; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1024">
                    <tr>
                        <td width="150">Telah Bayar Kepada</td>
                        <td>:&nbsp;<?php echo $modBuktiKeluar->namapenerima; ?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<span class="currency"><?php echo MyFormatter::formatUang($modBuktiKeluar->jmlkaskeluar);?></span></td>
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
                <table width="1024" class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="150">Uraian</th>
                            <th style="text-align:center;">Volume</th>
                            <th style="text-align:center;">Satuan</th>
                            <th style="text-align:center;">Harga</th>
                            <th style="text-align:center;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $rows = '';
							$modUraian = KUUraiankeluarumumT::model()->findAllByAttributes(array('pengeluaranumum_id'=>$modBuktiKeluar->pengeluaranumum_id));
                            if(count((array)$modUraian) > 0){
                                $rows = '';
                                foreach($modUraian as $val)
                                {
                                    $rows .= '<tr>';
                                    $rows .= '<td>'.$val->uraiantransaksi.'</td>';
                                    $rows .= '<td>'.$val->volume.'</td>';
                                    $rows .= '<td>'.$val->satuanvol.'</td>';
                                    $rows .= '<td>'.MyFormatter::formatUang($val->hargasatuan).'</td>';
                                    $rows .= '<td>'.MyFormatter::formatUang($val->totalharga).'</td>';
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
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
