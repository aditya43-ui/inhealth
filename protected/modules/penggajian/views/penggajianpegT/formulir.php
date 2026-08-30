<style type="text/css">
    table.utama tr td {
        padding: 5px;
    }

    table.anak tr td {
        padding: 0;
    }

    table.pph21 tr td {
        border: 1px solid #000;
    }

    .simbol {
        font-size: 18px;
    }

    tr td .add-on,
    tr td label,
    tr td input {
        margin: 0 !important;
    }
</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'formulir_1721',
    'type' => 'horizontal',
    'focus' => '',
));
?>
<table width="100%" class="utama">
    <tr>
        <td width="30%" rowspan="2" style="text-align: center; border-right: 1px solid #000;">
            <img src="<?php echo Params::urlProfilRSDirectory() . 'logo_menkeu.png'; ?> " style="max-width: 70px; width:70px;" />
            <p>
                <b>KEMENTERIAN KEUANGAN RI<br>
                    DIREKTORAT JENDRAL PAJAK</b>
            </p>
        </td>
        <td width="35%" style="text-align: center; border-right: 1px solid #000; vertical-align:top;">
            <b>BUKTI PEMOTONGAN PAJAK PENGHASILAN<br>
                PASAL 21 BAGI PEGAWAI TETAP ATAU<br>
                PENERIMA PENSIUN ATAU TUNJANGAN HARI<br>
                TUA ATAU JAMINAN HARI TUA BERKALA<br>
            </b>
        </td>
        <td style="vertical-align:top;">
            <h4 style="text-align:right;">FORMULIR 1721 - A1</h4>
            Lembar ke-1 : untuk Penerima Penghasilan<br>
            Lembar ke-2 : untuk Pemotong<br>
            <p style="margin: 0; text-align: center;">
                <b>MASA PEROLEHAN<br>
                    PENGHASILAN (mm - mm)</b>
            </p>

        </td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000; border-right: 1px solid #000;">
            <?php
            $masaPjk = substr($modelpeg->periodegaji, 5, 2);
            $thnPjk = substr($modelpeg->periodegaji, 2, 2);
            $noGaji = '000000' . substr($modelpeg->nopenggajian, 10, 3);

            $tahunPajak = substr($modelpeg->periodegaji, 0, 4);
            ?>
            <b>NOMOR : 1 . 1 - <?php echo $masaPjk . ' - ' . $thnPjk . ' - ' . $noGaji; ?></b>
        </td>
        <td>
            <p style="margin: 0; text-align: center;">
                <?php echo $masaPjk . " - " . $masaPjk; ?>
                <!--01 - 12-->
                <?php /* echo CHtml::dropDownList('masa_1', $masaPjk, array(
                '01'=>'01',
                '02'=>'02',
                '03'=>'03',
                '04'=>'04',
                '05'=>'05',
                '06'=>'06',
                '07'=>'07',
                '08'=>'08',
                '09'=>'09',
                '10'=>'10',
                '11'=>'11',
                '12'=>'12',
            ), array('style'=>'width:50px;','class'=>'span1', 'onchange'=>'loadPenghasilan();')); ?>
            - 
            <?php echo CHtml::dropDownList('masa_2', $masaPjk, array(
                '01'=>'01',
                '02'=>'02',
                '03'=>'03',
                '04'=>'04',
                '05'=>'05',
                '06'=>'06',
                '07'=>'07',
                '08'=>'08',
                '09'=>'09',
                '10'=>'10',
                '11'=>'11',
                '12'=>'12',
            ), array('style'=>'width:50px;','class'=>'span1', 'onchange'=>'loadPenghasilan();')); 
             * 
             */ ?>
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">

            <table width="100%" class="anak">
                <tr>
                    <td width="150"><b>NPWP PEMOTONG</b></td>
                    <td style="vertical-align: bottom;">: <?php echo $profil->npwp; ?></td>
                </tr>
                <tr>
                    <td><b>NAMA PEMOTONG</b></td>
                    <td style="vertical-align: bottom;">: <?php echo $profil->nama_rumahsakit; ?></td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td colspan="3">
            <b>A. IDENTITAS PENERIMA PENGHASILAN YANG DIPOTONG</b>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">

            <table style="width: 100%; border: none;">
                <tr>
                    <td width="150"><b>1.NPWP</b></td>
                    <td>: <?php echo $modelpeg->pegawai->npwp; ?></td>

                    <td colspan="2" width="50%"><b>6.STATUS / JUMLAH TANGGUNGAN KELUARGA UNTUK PTKP</b> : </td>
                </tr>
                <tr>
                    <td><b>2.NIK / NO.PASPORT</b></td>
                    <td>: <?php echo $modelpeg->pegawai->noidentitas; ?></td>

                    <td colspan="2">
                        <?php
                        echo $modelpeg->pegawai->getStatusKodePtkp();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>3.NAMA</b></td>
                    <td>: <?php echo $modelpeg->pegawai->NamaLengkap; ?></td>

                    <td colspan="2"><b>7.NAMA JABATAN </b>:
                        <?php echo $modelpeg->pegawai->getJabatanNama(); ?>
                    </td>
                </tr>
                <tr>
                    <td><b>4.ALAMAT</b></td>
                    <td>: <?php echo $modelpeg->pegawai->alamat_pegawai; ?></td>

                    <td colspan="2"><b>8.KARYAWAN ASING</b> :
                        <?php
                        if ($modelpeg->pegawai->warganegara_pegawai == 'INDONESIA') {
                            echo '<b class="simbol">&#9744;</b> YA';
                        } else {
                            echo '<b class="simbol">&#9746;</b> YA';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>5.JENIS KELAMIN</b> :
                        <?php
                        if ($modelpeg->pegawai->jeniskelamin == 'PEREMPUAN') {
                            echo '<b class="simbol">&#9744;</b> LAKI-LAKI &nbsp; &nbsp; &nbsp; ';
                            echo '<b class="simbol">&#9746;</b> PEREMPUAN';
                        } else {
                            echo '<b class="simbol">&#9746;</b> LAKI-LAKI &nbsp; &nbsp; &nbsp; ';
                            echo '<b class="simbol">&#9744;</b> PEREMPUAN';
                        }
                        ?>
                    </td>

                    <td colspan="2"><b>9.KODE NEGARA DOMISILI</b> :
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td colspan="3">
            <b>B. RINCIAN PENGHASILAN DAN PERHITUNGAN PPh PASAL 21</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">

            <table width="100%" class="pph21">
                <tr>
                    <td colspan="2" style="text-align:center;"><b>URAIAN</b></td>
                    <td style="text-align:center;"><b>JUMLAH (Rp)</b></td>
                </tr>
                <tr>
                    <td colspan="2"><b>KODE OBJEK PAJAK:
                            <?php
                            if ($modelpeg->pegawai->kode_objekpajak == '21-100-01') {
                                echo '<b class="simbol">&#9746;</b> 21-100-01 &nbsp; &nbsp; &nbsp; ';
                                echo '<b class="simbol">&#9744;</b> 21-100-02';
                            } else {
                                echo '<b class="simbol">&#9744;</b> 21-100-01 &nbsp; &nbsp; &nbsp; ';
                                echo '<b class="simbol">&#9746;</b> 21-100-02';
                            }
                            ?>
                        </b>
                    </td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENGHASILAN BRUTO:</b></td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td style="width: 20px;">1.</td>
                    <td>GAJI/PENSIUN ATAU THT/JHT</td>
                    <td style="text-align:right;" class="no_1">
                        <?php
                        $no1 = 0;
                        if (!empty($modelpeg->gajipokok)) {
                            $no1 = $modelpeg->gajipokok;
                            echo number_format($no1);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>TUNJANGAN PPh</td>
                    <td style="text-align:right;" class="no_2">
                        <?php
                        $no2 = 0; //$modelpeg->pph21perbulan;
                        echo number_format($no2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>TUNJANGAN LAINNYA, UANG LEMBUR DAN SEBAGAINYA</td>
                    <td style="text-align:right;" class="no_3">
                        <?php
                        //                            $no3 = ($modelpeg->fungsional($modelpeg->penggajianpeg_id) + $modelpeg->lembur($modelpeg->penggajianpeg_id)) * 12;
                        $no3 = ($modelpeg->tunjangantetap);
                        echo number_format($no3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>HONONARIUM DAN IMBALAN LAIN SEJENISNYA</td>
                    <td style="text-align:right;" class="no_4">
                        <?php
                        $no4 = ($modelpeg->honorarium);
                        echo number_format($no4);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>PREMI ASURANSI YANG DIBAYAR PEMBERI KERJA</td>
                    <td style="text-align:right;" class="no_5">
                        <?php
                        //                            $no5 = $modelpeg->premiasuransi * 12;
                        $no5 = $modelpeg->premiasuransi;
                        echo number_format($no5);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>PENERIMAAN DALAM BENTUK NATURA DAN KENIKMATAN LAINNYA YANG DIKENAKAN PEMOTONGAN PPh PASAL 21</td>
                    <td style="text-align:right;" class="no_6">
                        <?php
                        $no6 = $modelpeg->tunjanganmakan;
                        echo number_format($no6);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>TANTIEM, BONUS, GRATIFIKASI, JASA PRODUKSI DAN THR</td>
                    <td style="text-align:right;" class="no_7">
                        <?php
                        //                            $no7 = ($modelpeg->bonus($modelpeg->penggajianpeg_id) * 12) + $modelpeg->thr($modelpeg->penggajianpeg_id);
                        $no7 = ($modelpeg->tunjanganbonus);
                        echo number_format($no7);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>JUMLAH PENGHASILAN BRUTO(1 S.D. 7)</td>
                    <td style="text-align:right;" class="no_8">
                        <?php
                        $no8 = $no1 + $no2 + $no3 + $no4 + $no5 + $no6 + $no7;
                        echo number_format($no8);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENGURANGAN:</b></td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>BIAYA JABATAN/ BIAYA PENSIUN</td>
                    <td style="text-align:right;" class="no_9">
                        <?php
                        $no9 = $modelpeg->biayajabatan;
                        echo number_format($no9);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>IURAN PENSIUN ATAU IURAN THT/JHT</td>
                    <td style="text-align:right;" class="no_10">
                        <?php
                        $no10 = $modelpeg->potonganpensiun;
                        echo number_format($no10);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>JUMLAH PENGURANGAN(10 S.D. 11)</td>
                    <td style="text-align:right;" class="no_11">
                        <?php
                        $no11 = $no9 + $no10;
                        echo number_format($no11);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>PENGHITUNGAN PPh PASAL 21:</b></td>
                    <td style="background-color:#f2f2f2;"></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>JUMLAH PENGHASILAN NETTO(8 - 11)</td>
                    <td style="text-align:right;" class="no_12">
                        <?php
                        //                        $no12 = (($modelpeg->totalterima+$modelpeg->premiasuransi) * 12) - $modelpeg->biayajabatan - $modelpeg->potonganpensiun - $modelpeg->jaminanpensiun - $modelpeg->bpjskesehatan;
                        $no12 = $no8 - $no11;
                        echo number_format($no12);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>PENGHASILAN NETO MASA SEBELUMNYA</td>
                    <td style="text-align:right;" class="no_13">
                        <?php
                        $no13 = $modelpeg->netto_masasebelumnya;
                        echo number_format($no13);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>JUMLAH PENGHASILAN NETO UNTUK PERHITUNGAN PPh PASAL 21(SETAHUN/DISETAHUNKAN)</td>
                    <td style="text-align:right;" class="no_14">
                        <?php
                        $no14 = $modelpeg->penerimaanbersihpertahun;
                        echo number_format($no14);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>PENGHASILAN TIDAK KENA PAJAK(PTKP)</td>
                    <td style="text-align:right;" class="no_15">
                        <?php
                        $no15 = $modelpeg->ptkppertahun;
                        echo number_format($no15);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN(14 - 15)</td>
                    <td style="text-align:right;" class="no_16">
                        <?php

                        $no16 = $no14 - $no15;
                        if ($no16 < 0) {
                            $no16 = 0;
                        }

                        echo number_format($no16); ?>
                    </td>
                </tr>
                <tr>
                    <td>17</td>
                    <td>PPh PASAL 21 ATAS PENGHASILAN KENA PAJAK SETAHUN/DISETAHUNKAN</td>
                    <td style="text-align:right;" class="no_17">
                        <?php echo number_format($modelpeg->pph21pertahun); ?>
                    </td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>PPh PASAL 21 YANG TELAH DIPOTONG MASA SEBELUMNYA</td>
                    <td style="text-align:right;" class="no_18">
                        <?php echo number_format($modelpeg->pph21dipotong); ?>
                    </td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>PPh PASAL 21 TERUTANG</td>
                    <td style="text-align:right;" class="no_19">
                        <?php echo number_format($modelpeg->pph21terutang); ?>
                    </td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>PPh PASAL 21 DAN PPh PASAL 26 YANG TELAH DIPOTONG DAN DILUNASI</td>
                    <td style="text-align:right;" class="no_20">
                        <?php echo number_format($modelpeg->pph21telahdipotong); ?>
                    </td>
                </tr>
                <?php /*
                <tr>
                    <td>17</td>
                    <td>PPh PASAL 21 PERBULAN TERUTANG</td>
                    <td style="text-align:right;" class="no_17"> 
                        <?php echo number_format($modelpeg->pph21perbulan); ?>
                    </td>
                </tr> 
                 * 
                 */ ?>
            </table>

        </td>
    </tr>
    <tr>
        <td colspan="3"><b>C. IDENTITAS PEMOTONG</b></td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">
            <table style="width: 100%; border: none;">
                <tr>
                    <?php
                    $id_peg = $modelpeg->pemotong_id; //PHOA BING

                    if (isset($_GET['pemotong_id'])) {
                        $id_peg = $_GET['pemotong_id'];
                    }

                    $nama_peg = "";
                    $npwp_peg = "";
                    $pegPemotong = PegawaiM::model()->findByPk($id_peg);
                    if (isset($pegPemotong)) {
                        if (!empty($pegPemotong->pegawai_id)) {
                            $nama_peg = $pegPemotong->namaLengkap;
                            $npwp_peg = $pegPemotong->npwp;
                        }
                    }
                    ?>
                    <td width="50%">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td width="100px"><b>1. NPWP : </b></td>
                                <td><span id="npwppeg"><?php echo $npwp_peg; ?></span></td>
                            </tr>
                            <tr>
                                <td width="100px"><b>2. NAMA : </b></td>
                                <td>

                                    <?php echo CHtml::hiddenField('pemotong_id', $id_peg, array('readonly' => true)) ?>
                                    <?php
                                    if (isset($_GET['pemotong_id'])) {
                                        echo $nama_peg;
                                    } else {
                                        $this->widget('MyJuiAutoComplete', array(
                                            //                            'model' => $model,
                                            //                            'attribute' => 'pemotong',
                                            'id' => 'pemotong',
                                            'name' => 'pemotong',
                                            'value' => $nama_peg,
                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 4,
                                                'focus' => 'js:function( event, ui ) {
                                                $("#pemotong").val(ui.item.nama_pegawai);
                                                return false;
                                        }',
                                                'select' => 'js:function( event, ui ) {
                                        $("#pemotong").val(ui.item.nama_pegawai);
                                        $("#pemotong_id").val(ui.item.pegawai_id);
                                        $("#npwppeg").html(ui.item.npwp);
                                        return false;
                                    }',
                                            ),
                                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                                            'tombolDialog' => array('idDialog' => 'dialogPemotong', 'idTombol' => 'tombolPasienDialog'),
                                        ));
                                    }
                                    ?>

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="30%">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td width="100px"><b>3. TANGGAL & TANDA TANGAN </b></td>
                            </tr>
                            <tr>
                                <td width="100px">
                                    <p style="margin: 0; text-align: center;">
                                        <?php
                                        if (isset($_GET['tglpenggajian'])) {
                                            $tgl = MyFormatter::formatDateTimeForDb($_GET['tglpenggajian']);
                                            echo date('d - m - Y', strtotime($tgl));
                                        } else {
                                            $this->widget('MyDateTimePicker', array(
                                                //                                            'model' => $model,
                                                //                                            'attribute' => 'tglpenggajian',
                                                'id' => 'tglpenggajian',
                                                'name' => 'tglpenggajian',
                                                'value' => MyFormatter::formatDateTimeForUser($modelpeg->tglpenggajian),
                                                'mode' => 'datetime',
                                                'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => true, 'class' => 'span3 dtPicker3', 'style' => 'float: left;',  'onkeypress' => "return $(this).focusNextInputField(event)"
                                                ),
                                            ));
                                        }
                                        ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="25%" style="border:1px solid #000;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<br>
<?php $this->endWidget(); ?>

<?php
if (!isset($caraPrint)) {

?>

    <?php
    /**
     * Dialog untuk nama Pegawai
     */
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPemotong',
        'options' => array(
            'title' => 'Pegawai Pemotong',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'zIndex' => 1002,
            'resizable' => true,
        ),
    ));

    $modPegawaiRegister = new KPRegistrasifingerprint();
    if (isset($_GET['KPRegistrasifingerprint']))
        $modPegawaiRegister->attributes = $_GET['KPRegistrasifingerprint'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawaipemotong-m-grid',
        'dataProvider' => $modPegawaiRegister->search(),
        'filter' => $modPegawaiRegister,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#pemotong\").val(\"$data->nama_pegawai\");
                                                      $(\"#pemotong_id\").val(\"$data->pegawai_id\"); 
                                                      $(\"#npwppeg\").html(\"$data->npwp\"); 
                                                      $(\"#dialogPemotong\").dialog(\"close\");    
                                                      return false;
                                            "))',
            ),
            array(
                'header' => 'NIP',
                'name' => 'nomorindukpegawai',
                'value' => '$data->nomorindukpegawai',
                //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only', 'disabled'=>false))
            ),
            array(
                'header' => 'Nama Pegawai',
                'name' => 'nama_pegawai',
                'value' => '$data->namaLengkap',
                //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
            ),
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                'filter' => Chtml::activeDropDownList($modPegawaiRegister, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
            . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
            . '}',
    ));

    $this->endWidget();
    ?>


    <br>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printRincian(\'PRINT\')'));
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printRincian(\'PDF\')')); 
        ?>
    </div>

<?php
    $penggajianpeg_id = isset($_GET['penggajianpeg_id']) ? $_GET['penggajianpeg_id'] : null;

    $urlPrint = $this->createUrl('formulir', array('penggajianpeg_id' => $modelpeg->penggajianpeg_id));
    $js = <<< JSCRIPT
function printRincian(caraPrint)
{
    var masa_1 = $("#masa_1").val();
    var masa_2 = $("#masa_2").val();
    var tglpenggajian = $("#tglpenggajian").val();
    var pemotong_id = $("#pemotong_id").val();
    window.open("${urlPrint}&masa_1="+masa_1+"&masa_2="+masa_2+"&tglpenggajian="+tglpenggajian+"&pemotong_id="+pemotong_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
 
JSCRIPT;
    Yii::app()->clientScript->registerScript('printRincian', $js, CClientScript::POS_HEAD);
}
?>
<script type="text/javascript">
    function loadPenghasilan() {
        var pegawai_id = "<?php echo $modelpeg->pegawai_id; ?>";
        var tahun = "<?php echo $tahunPajak; ?>";
        var masa_1 = $("#masa_1").val();
        var masa_2 = $("#masa_2").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetFormulir'); ?>',
            data: {
                pegawai_id: pegawai_id,
                tahun: tahun,
                masa_1: masa_1,
                masa_2: masa_2
            },
            dataType: "json",
            success: function(data) {
                $(".no_1").text(formatNumber(data.no_1));
                $(".no_2").text(formatNumber(data.no_2));
                $(".no_3").text(formatNumber(data.no_3));
                $(".no_4").text(formatNumber(data.no_4));
                $(".no_5").text(formatNumber(data.no_5));
                $(".no_6").text(formatNumber(data.no_6));
                $(".no_7").text(formatNumber(data.no_7));
                $(".no_8").text(formatNumber(data.no_8));
                $(".no_9").text(formatNumber(data.no_9));
                $(".no_10").text(formatNumber(data.no_10));
                $(".no_11").text(formatNumber(data.no_11));
                $(".no_12").text(formatNumber(data.no_12));
                $(".no_13").text(formatNumber(data.no_13));
                $(".no_14").text(formatNumber(data.no_14));
                $(".no_15").text(formatNumber(data.no_15));
                $(".no_16").text(formatNumber(data.no_16));
                $(".no_17").text(formatNumber(data.no_17));
                $(".no_18").text(formatNumber(data.no_18));
                $(".no_19").text(formatNumber(data.no_19));
                $(".no_20").text(formatNumber(data.no_20));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
</script>