<head>
    
    
</head>
<style>
    @page {
        /*   size: 7in 9.25in;*/
        /*   margin: 27mm 16mm 27mm 16mm;*/
        font-size: 12pt !important;
        margin-top:0;
        margin-bottom:0;
        margin-left:0;
        margin-right:0;
    }
    @media print {
        html, body {
            padding:1cm 1.5cm 1cm 1.5cm;
            font-family: "Times New Roman", Times, serif;
            font-size:12pt;
            width:  21cm;
            height: 33cm;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }
    @media all {
    .page-break { display: none; }
    }

    @media print {
    .page-break { display: block; page-break-before: always; }
    }
    h4{
       font-family: Arial, sans-serif;
       font-size: 20px !important;
    }
    .garis {
        border-top: 3px double black;
    }
     td {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    th {
        font-family: "Arial";
        color: black;
        font-size:12pt;
    }
    p {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }
    h4 {
        font-family: "Arial", Times, serif;
        font-size:14pt;
    }
    #judul{
        font-size:14pt;
    }
    u {
        font-family: "Arial", Times, serif;
        font-size:12pt;
    }

</style>
<div class="container">
    <div class="row-fluid" >
        <table width="100%">
            <tr>
                <td> 
                    <?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara'); ?>
                </td>
            </tr>
        </table>
    </div> 
    <div class="row-fluid"  id="setdasar">
        <?php echo !empty($model->dasar) ? $model->dasar : ""; ?>
    </div>
    <div class="row-fluid">
        <table width="100%">
            <tr>
                <td width="65%"> </td>
                <td width="35%"> 
                    <?php 
                        $tgl = date('d', strtotime($model->baujifungsi_tanggal));
                        $bulan = MyFormatter::getMonthId(date('n', strtotime($model->baujifungsi_tanggal)));
                        $tahun = date('Y', strtotime($model->baujifungsi_tanggal));
                    
                        echo "Surabaya, ".$tgl." ".$bulan." ".$tahun; ?> <br>
                </td>
            </tr>
        </table>
    </div>
    
        <table width="100%" >
            <tr>
                <td width="35%">
                    <table width="100%">
                        <tr>
                            <td align="center" height="35px" style="vertical-align: bottom"> 
                                Penyedia Barang <br>
                                <?php $modSurat = SuratperjanjiankerjaT::model()->findByPk($model->suratperjanjiankerja_id); ?>
                                <?php echo $modSurat->supplier->supplier_nama ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="85px">
                                
                            </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <u> <b> <?php echo $modSurat->supplier->direktursupplier;?> </b> </u> <br>
                                Direktur
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="65%">
                    <table width="100%">
                        <tr>
                            <td align="center" height="35px"> 
                                <?php 
                                    $cr = new CDbCriteria();
                                    $cr->select = "initcap(namaunitkerja) as namaunit";
                                    $cr->addCondition("t.unitkerja_id = ".$model->pegawai->unitkerja_id);
                                    $modUnit = UnitkerjaM::model()->find($cr);
                                    echo ucwords("Kepala ".$modUnit->namaunit);?>
                            </td>
                        </tr>
                        <tr>
                            <td height="85px">
                                
                            </td>
                        </tr>
                        <tr>
                            <td align="center"> 
                                <b> <u> <?php echo $model->pegawai->namaLengkap?> </u> </b>
                                <br>
                                <?php echo $model->pegawai->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <br><br><br>
    <table width="100%" >
        <tr>
            <td width="50%" style="vertical-align:top">
                    <table width="100%">
                        <tr>
                            <td align="center" height="35px"> 
                                Teknisi  <?php  echo $modSurat->supplier->supplier_nama  ?>
                                <br><br>
                                <?php
                                $modTeknisiPny = TeknisipenyediaT::model()->findAllByAttributes(array('baujifungsi_id' => $model->baujifungsi_id));
                                //$cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                                $a = '<table border="0" style="width:100%; text-align:right">';
                                $no = 1;
                                foreach ($modTeknisiPny as $panitia) {
                                    
                                    $a .= '<tr >
                                    <td width="5%">' . $no++ . '. </td>
                                    <td width="5%" width="5%" align="left">Nama </td>
                                    <td width="5%">: </td>
                                    <td align="left">' . $panitia->teknisipenyedia_nama . '</td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%" width="5%" align="left">Tanda Tangan </td>
                                    <td width="5%">: </td>
                                    <td align="left"> ............................................ </td>
                                </tr>';
                                }
                                $a .= '</table>';
                                echo $a;
                                ?>
                            </td>
                        </tr>
                        
                    </table>
                </td>
                <td width="50%" style="vertical-align:top">
                    <table width="100%">
                        <tr>
                            <td align="center" height="35px"> 
                                Tenaga Teknis Instalasi
                                <br><br>
                                <?php
                                $modTeknisi = PegtimteknisT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'baujifungsi_id' => $model->baujifungsi_id));
                                //$cekPegpphp = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id));
                                $a = '<table border="0" style="width:100%; text-align:right">';
                                $no = 1;
                                foreach ($modTeknisi as $panitia) {
                                    $cekPegawai = PegawaiM::model()->findByPk($panitia->pegawai_id);
                                    $a .= '<tr >
                                    <td width="5%">' . $no++ . '. </td>
                                    <td width="5%" width="5%" align="left">Nama </td>
                                    <td width="5%">: </td>
                                    <td align="left">' . $cekPegawai->namaLengkap . '</td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%" width="5%" align="left">Tanda Tangan </td>
                                    <td width="5%">: </td>
                                    <td align="left"> ............................................ </td>
                                </tr>';
                                }
                                $a .= '</table>';
                                echo $a;
                                ?>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
                       
                        
                    </table>
   

<script>
    $(document).ready(function () {
      
        $("h3").css("text-align", " center");
        $("#setdasar table").css("width", "70%");
        $("#setdasar table").css("margin-left", "15%");
        $("#setdasar table").css("margin-right", "15%");
        $("#setdasar table tr td").css("vertical-align", "top");
        
        $("#settabfungsi").css("margin-left", "0");
        $("#setdasar table").css("margin-right", "0");
        $("#setdasar table").css("width", "100%");
        $("table tbody").find("table").css("width", "100%");
       
    });
</script>