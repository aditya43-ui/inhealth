<?php 
echo $this->renderPartial('application.views.headerReport.headerBeritaAcara');



$lokasiasal = LokasiasetM::model()->findByPk($modMutasi->lokasiasal_id);
$lokasitujuan = LokasiasetM::model()->findByPk($modMutasi->lokasitujuan_id);
?>
<style>
    
    .border th, .border td{
        border:1px solid #000;
    }
    
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
        border-spacing:0px;
        padding:0px;
    }
    .table{
        font-size: 12px; 
        font-family: Arial;
        
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<table width="100%" style="margin-top: 30px;">
    <tr>
        <td>
            <table id="tableObatAlkes" class="table border" border="1" width="100%">
                <tr>
                    <th style="text-align: center; vertical-align: middle;" width="10%"> No. </th>
                    <th style="text-align: center; vertical-align: middle;" width="20%"> Jenis Peralatan </th>
                    <th style="text-align: center; vertical-align: middle;" width="30%"> Nomor Aset </th>
                    <th style="text-align: center; vertical-align: middle;" width="10%"> Nomor Seri </th>
                    <th style="text-align: center; vertical-align: middle;" width="10%"> Keadaan </th>
                </tr>
                <?php
                $no = 1;
                foreach ($modDetailMutasi as $item) {

                    $barang = InvperalatanT::model()->findByPk($item->invperalatan_id);
                    ?>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $no; ?></td>                        
                        <td style="text-align: center; vertical-align: middle;"><?php echo $barang->invperalatan_namabrg; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $barang->invperalatan_kode ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $barang->peralatan_noseri ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $barang->invperalatan_keadaan ?></td>
                    </tr>

                    <?php $no ++;
                }
                ?>
            </table>
        </td>
    </tr>
</table>
<table style="margin-top: 50px; font-size: 12px; font-family: Arial;">
    <tr>
        <td width="20%"> Lokasi Asal </td>
        <td width="20%" colspan="2"> : <?php echo CHtml::encode(!empty($lokasiasal)?$lokasiasal->ruangan->ruangan_nama.' - '.$lokasiasal->lokasiaset_namalokasi:'') ?> </td>
        <td width="10%"> </td>
        <td width="20%" colspan="2"> Surabaya </td>
        <td width="25%"> <?php echo MyFormatter::FormatDateTimeForUser($modMutasi->tglmutasiaset); ?> </td>
    </tr>
    <tr>
        <td width="20%"> Tanggal </td>
        <td width="20%" colspan="2"> : <?php echo MyFormatter::FormatDateTimeForUser($modMutasi->tglmutasiaset); ?> </td>
        <td width="10%"> </td>        
    </tr>
    <tr>
        <td width="20%"> Lokasi Tujuan </td>
        <td width="20%" colspan="2"> : <?php echo CHtml::encode(!empty($lokasitujuan)?$lokasitujuan->ruangan->ruangan_nama.' - '.$lokasitujuan->lokasiaset_namalokasi:'') ?> </td>
        <td width="15%"> </td>

    </tr>
    <tr>
        <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center">Pegawai Menyerahkan</td>
        <td></td>
        <td colspan="3" align="center">Pegawai Penerima</td>
    </tr>
    <tr>
        <td width="20%"> Tanda Tangan </td>
        <td width="27%" height="80px" colspan="2"> : </td>
        <td width="6%"> </td>
        <td width="20%"> Tanda Tangan </td>
        <td width="27%" height="80px" colspan="2"> : </td>
    </tr>
    <tr>
        <td width="20%"> Nama </td>
        <td width="20%" colspan="2"> : <?php echo !empty($modPegSerah) ? CHtml::encode($modPegSerah->namaLengkap) : ""; ?> </td>
        <td width="10%"> </td>
        <td width="15%"> Nama </td>
        <td width="25%" colspan="2"> : <?php echo !empty($modPegTerima) ? $modPegTerima->namaLengkap : ""; ?> </td>
    </tr>
    <tr>
        <td width="20%"> NIP </td>
        <td width="20%" colspan="2"> : <?php echo !empty($modPegSerah->nomorindukpegawai) ? $modPegSerah->nomorindukpegawai : ""; ?> </td>
        <td width="10%"> </td>
        <td width="15%"> NIP </td>
        <td width="25%" colspan="2"> : <?php echo !empty($modPegTerima->nomorindukpegawai) ? $modPegTerima->nomorindukpegawai : ""; ?> </td>
    </tr>
    <tr>
        <td width="20%"> Pangkat / Gol.  </td>
        <td width="20%" colspan="2"> 
            :
            <?php
            $pangkat = '-';
            $golonganpegawai = '-';
            if (!empty($modPegSerah->pangkat_id)) {
                $pangkat = $modPegSerah->pangkat->pangkat_nama;
            }
            if (!empty($modPegSerah->golonganpegawai_id)) {
                $golonganpegawai = $modPegSerah->golonganpegawai->golonganpegawai_nama;
            }

            echo $pangkat . '/' . $golonganpegawai;
            ?>
        </td>
        <td width="10%"> </td>
        <td width="15%"> Pangkat / Gol.  </td>
        <td width="25%" colspan="2"> 
            :
            <?php
            $pangkat = '-';
            $golonganpegawai = '-';
            if (!empty($modPegTerima->pangkat_id)) {
                $pangkat = $modPegTerima->pangkat->pangkat_nama;
            }
            if (!empty($modPegTerima->golonganpegawai_id)) {
                $golonganpegawai = $modPegTerima->golonganpegawai->golonganpegawai_nama;
            }

            echo $pangkat . '/' . $golonganpegawai;
            ?>
        </td>
    </tr>
</table>
<?php
    $unit = LookupM::model()->find(" lookup_type = 'jabatanttdaset' AND lookup_value = 'ttd 1' ");
    $unitkepala = UnitkerjaM::model()->findByPk(ParamsConst::UNITKERJA_ID_SUB_BAGIAN_PERLENGKAPAN_ASET);
    $pegKepala = PegawaiM::model()->findByPk(!empty($unitkepala)?$unitkepala->kepalaunitpeg_id:null);
?>
<table width="60%" align="center" style="margin-top: 30px;  font-size: 12px; font-family: Arial;">
    <tr>
        <td colspan="3" style="text-align: center"> Mengetahui</td>
    </tr>
    <tr> 
        <td colspan="3" style="text-align: center"> <?= !empty($unit)?$unit->lookup_name:'Kepala Sub Bag. Perlengkapan & Aset' ?></td>
    </tr>
    <tr> 
        <td width="25%"> Tanda Tangan </td>
        <td width="35%" style="height: 100px" colspan="2"> : </td>
    </tr>
    <tr> 
        <td width="25%"> Nama </td>
        <td width="35%" colspan="2"> : <?php echo!empty($pegKepala) ? $pegKepala->namaLengkap : ""; ?> </td>
    </tr>
    <tr> 
        <td width="25%"> N I P </td>
        <td width="35%" colspan="2"> : <?php echo!empty($pegKepala->nomorindukpegawai) ? $pegKepala->nomorindukpegawai : ""; ?> </td>
    </tr>
    <tr> 
        <td width="25%"> Pangkat / Gol </td>
        <td width="35%" colspan="2">
            :
            <?php
            $pangkat = '-';
            $golonganpegawai = '-';
            if (!empty($pegKepala->pangkat_id)) {
                $pangkat = $pegKepala->pangkat->pangkat_nama;
            }
            if (!empty($pegKepala->golonganpegawai_id)) {
                $golonganpegawai = $pegKepala->golonganpegawai->golonganpegawai_nama;
            }

            echo $pangkat . '/' . $golonganpegawai;
            ?> 
        </td>
    </tr>

</table>
