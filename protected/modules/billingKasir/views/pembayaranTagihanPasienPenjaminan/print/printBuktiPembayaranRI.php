<style>
    @page {
        font-size: 12pt !important;
        margin: 0;
    }

    @media print {

        html,
        body {
            margin: 1cm;
            font-family: "Arial" !important;
            font-size: 12pt;
        }

        div.footer {
            position: fixed;
            bottom: 0;
        }

        .page-break {
            display: block;
            page-break-before: always;
        }
    }

    table.footer {
        position: fixed;
        bottom: 0;
    }

    @media all {
        .page-break {
            display: none;
        }
    }
</style>
<?php
$trans = isset($_GET['trans'])?$_GET['trans']:null;
$data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$konfig = KonfigsystemK::model()->find();

$sisa = $sisauangmuka = $tagihan_pasien = 0;
if (!empty($modUangMuka)) {
    $sisa = $modTandaBukti->jmlpembayaran - $modUangMuka->totaluangmuka;
    $sisauangmuka = $modUangMuka->totaluangmuka - $modUangMuka->pemakaianuangmuka;
} 

?>

<body>
    <table width="100%">
        <tr>
            <td>
                <?php
                echo $this->renderPartial('application.views.headerReport._headerRadiologi', array());
                ?>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="1.5" cellspacing="1">
        <tr>
            <td colspan="3"> Kuitansi No. <?= $modTandaBukti->nobuktibayar ?> </td>
        </tr>
        <tr>
            <td> 
                <br>
            </td>
        </tr>
        <tr>
            <td width="20%"> Terima Dari </td>
            <td width="80%" colspan="2"> : <?= $modPasien->nama_pasien ?> </td>
        </tr>
        <tr>
            <td> No RM </td>
            <td colspan="2"> : <?= $modPasien->no_rekam_medik ?> </td>
        </tr>
        <tr>
            <td> Nama Pasien </td>
            <td colspan="2"> : <?= $modPasien->nama_pasien ?> </td>
        </tr>
        <tr>
            <td> Alamat </td>
            <td colspan="2"> : <?= $modPasien->alamat_pasien ?> </td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
            </td>
        </tr>
        <tr>
            <td> Total Tagihan </td>
            <td colspan="2"> : Rp. <?= MyFormatter::formatNumberForPrint($modTandaBukti->jmlpembayaran, 2) ?></td>
        </tr>
        <tr>
            <td> Terbilang </td>
            <td colspan="2"> : <?= ucwords(MyFormatter::formatNumberTerbilang($modTandaBukti->jmlpembayaran)) ?> Rupiah </td>
        </tr>
        <?php if ($modUangMuka->pemakaianuangmuka > 0) : ?>
            <tr>
                <td> Uang Muka </td>
                <td colspan="2"> : <?= MyFormatter::formatUang($modUangMuka->totaluangmuka, "Rp.", 2) ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td> Potongan </td>
            <td colspan="2"> : <?= MyFormatter::formatUang($modPembayaran->totaldiscount, "Rp.", 2) ?></td>
        </tr>
        <?php if ($modUangMuka->pemakaianuangmuka > 0) : ?>
            <tr>
                <td> Sisa Tagihan </td>
                <td colspan="2"> : <?= MyFormatter::formatUang($sisa, "Rp.", 2) ?></td>
            </tr>
        <?php endif; ?>
        <?php 
            $modPiutang = BKPiutangasuransiT::model()->findAllByAttributes(['pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id]);
            if (!empty($modPiutang)) {
                ?>
                <tr>
                    <td valign="top"> Dibayar  </td>
                    <td valign="top" colspan="2"> 
                        <p style="float: left"> : </p>
                        
                    <?php foreach ($modPiutang as $key => $det) { ?>
                        <table width="80%" style="vertical-align: top;">
                            <tr>
                                <td width="40%">&nbsp; Credit : 
                                    <?= MyFormatter::formatUang($det->jmlpiutangasuransi)?>    
                                </td>
                                <td>
                                    <?php 
                                        echo " (".$det->carabayar->carabayar_nama." - ".$det->penjamin->penjamin_nama.") ";
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <?php }?>

                    </td>
                </tr>
            <?php }
        ?>
        <?php 
        $dibayar_ina = 0;
        if ($modPembayaran->total_inacbg > 0) :
            $dibayar_ina = $modTandaBukti->jmlpembayaran - $modPembayaran->selisihuntungrugibpjs + $modTandaBukti->jmlpembulatanasuransi;   
            $tagihan_pasien = $modTandaBukti->jmlpembayaran - $dibayar_ina;     
            ?>
            <tr>
                <td> Dibayar </td>
                <td> : Credit
                    <?= MyFormatter::formatUang($dibayar_ina, "Rp.", 2) ?>
                </td>
            </tr>
        <?php endif; ?>
        
        <?php if (empty($modPiutang)) : ?>
            <?php if ($modPembayaran->totalsubsidiasuransi > 0) : 
                $tagihan_pasien = $modTandaBukti->jmlpembayaran - $modPembayaran->totalsubsidiasuransi;
            ?>
            <tr>
                    <td> Dibayar </td>
                    <td> : Credit
                        <?= MyFormatter::formatUang($modPembayaran->totalsubsidiasuransi, "Rp.", 2) ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($modTandaBukti->uangditerima > 0) : ?>
            <tr>
                <td> Dibayar </td>
                <td> : Cash
                    <?= MyFormatter::formatUang($modTandaBukti->uangditerima, "Rp.", 2) ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ($sisauangmuka > 0 ) : ?> 
            <tr>
                <td> Pengembalian Uang Muka </td>
                <td> 
                   : <?= MyFormatter::formatUang($sisauangmuka, "Rp.", 2) ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if (!empty($modTandaBukti->uangkembalian) > 0) : ?>
            <tr class="">
                <td>Uang Kembalian</td>
                <td> : <?php echo MyFormatter::formatNumberForPrint($modTandaBukti->uangkembalian, 2); ?></td>
            </tr>
        <?php endif; ?>

        <?php
        $jenis = "";
        $jenispembayaran = JenispembayaranT::model()->findAllByAttributes(['tandabuktibayar_id' => $modTandaBukti->tandabuktibayar_id]);

        $bank = "";
        if (!empty($jenispembayaran)) {
            $i = 1;
            $hasil = count($jenispembayaran);

            foreach ($jenispembayaran as $key => $val_jenis) { ?>
                <tr>
                    <td> <?php echo ($i == 1) ? "Dibayar " : "" ?> </td>
                    <td> : <?= $val_jenis->jnspembayar->jnspembayar_nama ?> : <?= MyFormatter::formatNumberForPrint($val_jenis->jumlahpembayaran, 2); ?></td>
                    <?php if ($val_jenis->biayacharge > 0) {  ?>
                        <td align="left"> Charge : <?= MyFormatter::formatNumberForPrint($val_jenis->biayacharge, 2) ?> </td>
                    <?php } else { ?>
                        <td> </td>
                    <?php } ?>
                </tr>
        <?php
                if ($i > 1) {
                    if ($i > 1 && $hasil != $i) {
                        $bank .= ", ";
                    }
                }
                $i++;
            }
        }

        $jenis = $bank;
        ?>
        <tr>
            <td colspan="3" style="border-top: 1.5px solid black">
        <br>
            </td>
        </tr>
        <tr>
            <td class="tandatangan" colspan="3">
                <?= Yii::app()->user->getState('kabupaten_nama') ?>,  <?php echo date('d-m-Y', strtotime($modTandaBukti->create_time)); ?>
                <br><br>
                <?php
                        $modPegawai = LoginpemakaiK::pegawaiLoginPemakai();
                        $modCari = PegawaiM::statusTTDDigital($modPegawai->pegawai_id);
                        $url = '';
                        if ($modCari == 1) {
                            if (!empty($modPegawai->ttd_pegawai)) {
                                $url = Params::urlPegawaiDirectory() . $modPegawai->ttd_pegawai;
                        ?>
                                <img src="<?= $url ?>" width="45mm" height="25mm">
                        <?php  }
                        }  ?>
                                <br><br>
                <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                <b> (<?php echo $pegawai->namaLengkap; ?>)</b>


            </td>
        </tr>
    </table>
</body>


<?php
    if ($trans == 'pasien-sudah-bayar'){
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        
        $modPiutang = 
        $sql = "SELECT *
				FROM piutangasuransi_t
				WHERE pembayaranpelayanan_id = ".$modPembayaran->pembayaranpelayanan_id;
        $query= Yii::app()->db->createCommand($sql)->queryAll();

        $button = [];
        $btn_default = array(
            'label' => 'PDF',
            'icon' => 'icon-bookmark',
            'url' => "javascript:void(0);",
            'itemOptions' => array(
                'onclick' => "printKlaim('PDF');",
                "rel" => "tooltip",
                "title" => "Klik untuk print kuitansi klaim",
            )
        );


        if (!empty($query)) {
            foreach ($query as $key => $det) {
                $i = 1;
                $button_penjamin[$key] = [];
                $modCarabayar = CarabayarM::model()->findByPk($det['carabayar_id']);

                $button_penjamin[$key] = [
                        'label' => 'Print '.$modCarabayar->carabayar_nama,
                        'icon' => 'icon-bookmark',
                        'url' => "javascript:void(0);",
                        'itemOptions' => array(
                        'onclick' => "printPiutang(". $det['piutangasuransi_id'].");",
                        "rel" => "tooltip",
                        "title" => "Klik untuk print kuitansi klaim",
                    )
                ];
                $button = array_merge($button_penjamin);
                $i++;
            }
        }
        $button[] = $btn_default;

            

        $items = $arr = [];

        if (!empty($button)) {
            // var_dump("tes");
            foreach ($button as $key => $det) {
                $arr[] = $det;
            }
        }

        asort($arr);

        
        if (!in_array($modPembayaran->carabayar_id, array(Params::CARABAYAR_ID_MEMBAYAR))) {
            $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type' => 'primary',
                'buttons' => array(
                    array(
                        'label' => 'Kuitansi Klaim',
                        'icon' => 'entypo-print',
                        'url' => "javascript:void(0);",
                        'htmlOptions' =>
                        array(
                            'onclick' => 'javascript:void(0);',
                            'onclick' => "printKlaim('PRINT');",
                            'class' => 'btn-blue',
                        )
                    ),
                    array(
                        'items' => $arr,
                        'htmlOptions' =>
                        array(
                            'class' => 'btn-blue',
                        )
                    ),
                ),
            ));      
        }


        
        if ($tagihan_pasien > 0 && $modPembayaran->carabayar_id !== Params::CARABAYAR_ID_MEMBAYAR) {
            $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type' => 'primary',
                'buttons' => array(
                    array(
                        'label' => 'Kuitansi Pasien',
                        'icon' => 'entypo-print',
                        'url' => "javascript:void(0);",
                        'htmlOptions' =>
                        array(
                            'onclick' => 'javascript:void(0);',
                            'onclick' => "printKuitansiPasien('PRINT');",
                            'class' => 'btn-blue',
                        )
                    ),
                    array(
                        'label' => '',
                        'items' => array(
                            array(
                                'label' => 'PDF',
                                'icon' => 'icon-bookmark',
                                'url' => "javascript:void(0);",
                                'itemOptions' => array(
                                    'onclick' => "printKuitansiPasien('PDF');",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk print kuitansi pasien",
                                )
                            ),
                        ),
                        'htmlOptions' =>
                        array(
                            'class' => 'btn-blue',
                        )
                    ),
                ),
            ));    
        }
    }

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printBuktiPembayaranRI');
    $urlUpdateDN =  Yii::app()->createAbsoluteUrl($module . '/kwitansi/updateDN');
    $urlPrintKlaim =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printKuitansiKlaim');
    $urlPrintPasien =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printKuitansiPasien');
    $urlPrintPiutang =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPiutang');
    $pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $idTandaBuktiBayar = $modPembayaran->tandabuktibayar_id;
    $idPasienadmisi = ((isset($modPembayaran->pasienadmisi_id)) ? $modPembayaran->pasienadmisi_id : null);
    $idPembayaranPelayanan = $modPembayaran->pembayaranpelayanan_id;
    $bkm = $modTandaBukti->darinama_bkm;
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&pembayaranpelayanan_id=${idPembayaranPelayanan}&caraPrint="+caraPrint,"", 'location=_new, width=1024px');
}

function printKlaim(caraPrint)
{
    window.open("${urlPrintKlaim}&pembayaranpelayanan_id=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
function printKuitansiPasien(caraPrint)
{
    window.open("${urlPrintPasien}&pembayaranpelayanan_id=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
function printPiutang(id)
{
    window.open("${urlPrintPiutang}&id="+id,"",'location=_new, width=1100px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
     ?>
<div class="page-break"> </div>
