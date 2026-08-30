
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
        border-spacing: 0;
        padding: 0;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table>
                        <tr>
                            <td>&nbsp; No. RM </td>
                            <td>: &nbsp;<?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp; Nama </td>
                            <td>: &nbsp;<?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp; Tgl. Lahir & Umur</td>
                            <td>: &nbsp;<?php echo date('d M Y', strtotime($modPendaftaran->pasien->tanggal_lahir)) . '/' . $modPendaftaran->umur; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp; Jenis Kelamin </td>
                            <td>: &nbsp;<?php echo $modPendaftaran->pasien->jeniskelamin; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp; Alamat </td>
                            <td>: &nbsp;<?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp; Tgl. Daftar </td>
                            <td>: &nbsp;<?php echo date('d M Y', strtotime($modPendaftaran->tgl_pendaftaran)); ?></td>
                        </tr>
                    </table>
                </div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">

    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>   
