<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));  
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="11%" style="text-align:right;">NIP</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?>
                    </td>
                    <td width="11%" style="text-align:right;">No. Rekening</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($modelpegawai->no_rekening) ? $modelpegawai->no_rekening : "-"); ?>
                    </td>
                </tr>
                <tr> 
                    <td width="11%" style="text-align:right;">Pegawai</td><td width="2%">:</td>
                    <td width="37%">
                        <?php
                            echo CHtml::encode($modelpegawai->nama_pegawai);
                        ?>
                    </td>
                    <td width="11%" style="text-align:right;">Bank</td><td width="2%">:</td>
                    <td width="37%">
                        <?php
                            echo CHtml::encode(isset($modelpegawai->banknorekening) ? $modelpegawai->banknorekening : "-");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Tempat Lahir</td><td width="2%">:</td>
                    <td width="37%">    
                        <?php echo CHtml::encode($modelpegawai->tempatlahir_pegawai); ?>
                    </td>
                    <td width="11%" style="text-align:right;">No. Telepon</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($modelpegawai->notelp_pegawai) ? $modelpegawai->notelp_pegawai : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Tanggal Lahir</td><td width="2%">:</td>
                    <td width="37%">    
                        <?php
                            echo CHtml::encode($modelpegawai->tgl_lahirpegawai);   
                        ?>
                    </td>
                    <td width="11%" style="text-align:right;">No. Handphone</td><td width="2%">:</td>
                    <td width="37%">    
                        <?php
                            echo CHtml::encode(isset($modelpegawai->nomobile_pegawai) ? $modelpegawai->nomobile_pegawai : "-");   
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Jenis Kelamin </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($modelpegawai->jeniskelamin); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Agama</td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($modelpegawai->agama); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="11%" style="text-align:right;">Tanggal Penggajian </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($model->tglpenggajian); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Alamat </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode(!empty($modelpegawai->alamat_pegawai) ? $modelpegawai->alamat_pegawai : "-"); ?>
                    </td>
                </tr>    
                <tr>
                    <td width="11%" style="text-align:right;">No. Penggajian </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($model->nopenggajian); ?>
                    </td>
                </tr>  
                <tr>
                    <td width="11%" style="text-align:right;">Keterangan </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode(!empty($model->keterangan) ? $modelpegawai->keterangan : "-"); ?>
                    </td>
                </tr>     
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>
                Deskripsi
            </th>
            <th>
                Gaji (Rp)
            </th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($modDetail as $i => $detail){
    ?>
        <tr>
            <th><?php echo $detail->komponen->komponengaji_nama; ?></th>
            <th style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($detail->jumlah); ?></th>
        </tr>
    <?php
        }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align: right">Total Gaji</th>
            <th style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalterima)); ?>
            </th>
        </tr>
        <tr>
            <th style="text-align: right">Total Pajak</th>
            <th style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalpajak)); ?>
            </th>
        </tr>
        <tr>
            <th style="text-align: right">Penerimaan Bersih</th>
            <th style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->penerimaanbersih)); ?>
            </th>
        </tr>
    </tfoot>
</table>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $model->gelardepan." ".$model->nama_pegawai; ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo $model->gelardepan." ".$model->nama_pegawai; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>