<style>
    body {
        color: black;
    }

    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr td,
    .table tbody tr th {
        background-color: none;
    }

    .table {
        box-shadow: none;
    }

    .judulcontent {
        text-align: center;
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
?>

<div class="judulcontent">
    <h4><b>DETAIL PENCATATAN SURAT INTERNAL</b></h4>
</div>
<table class='table' style="border: 0;">
    <tr>
        <td width="50%">
            <table class='table' style="border: 0;">
                <tr>
                    <td width="180px"> Jenis Surat </td>
                    <td>
                        : <?php echo $model->jenissurat; ?>
                    </td>
                </tr>
                <tr>
                    <td> Tanggal Surat</td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($model->tglsurat); ?>
                    </td>
                </tr>
                <?php if($model->jenissurat == 'Surat Keluar'){ ?>
                <tr>
                    <td> Tipe Surat </td>
                    <td>
                        : <?php echo $model->tipesurat; ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td> Nomor Surat </td>
                    <td>
                    : <?php echo $model->nomorsurat; ?>
                    </td>
                </tr>
                <?php if($model->jenissurat == 'Surat Masuk'){ ?>
                <tr>
                    <td> Asal Surat </td>
                    <td>
                    : <?php echo $model->asalsurat; ?>
                    </td>
                </tr>
                <?php } ?>
                <?php if($model->jenissurat == 'MoU' || $model->jenissurat == 'Perizinan'){ ?>
                <tr>
                    <td> Tanggal Mulai Berlaku </td>
                    <td>
                        : <?php echo (!empty($model->tglsurat) ? MyFormatter::formatDateTimeForUser($model->tglsurat) :""); ?>
                    </td>
                </tr>
                <tr>
                    <td> Tanggal Akhir Berlaku </td>
                    <td>
                        : <?php echo (!empty($model->tglsurat) ? MyFormatter::formatDateTimeForUser($model->tglsurat) :""); ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </td>
        <td width="50%">
            <table class='table' style="border: 0;">
            <?php if($model->jenissurat == 'Surat Keluar'){ ?>
                <tr>
                    <td width="150px"> Tujuan </td>
                    <td>
                        : <?php echo $model->tujuansurat; ?>
                    </td>
                </tr>
                <?php } ?>
                <?php if($model->jenissurat == 'Surat Keluar' || $model->jenissurat == 'Surat Masuk'){ ?>
                <tr>
                    <td width="150px"> Perihal </td>
                    <td>
                    : <?php echo $model->perihal; ?>
                    </td>
                </tr>
                <?php } ?>
                <?php if($model->jenissurat == 'Surat Keluar'){ ?>
                <tr>
                    <td> Jenis distribusi  </td>
                    <td>
                    : <?php echo $model->jenisdistribusi; ?>
                    </td>
                </tr>
                <?php } ?>
                <?php if($model->jenissurat == 'Surat Masuk'){ ?>
                <tr>
                    <td> Tanggal Disposisi </td>
                    <td>
                    : <?php echo (!empty($model->tgldisposisi) ? MyFormatter::formatDateTimeForUser($model->tgldisposisi) :""); ?>
                    </td>
                </tr>
                
                <tr>
                    <td valign="top"> Tujuan Disposisi </td>
                    <td style="margin: 0px; padding:0px">
                        <table width="100%">
                            <tbody>
                                <?php 
                                    if(!empty($modDetail)){
                                        foreach($modDetail as $detail){
                                            $namaPeg = "";
                                            if(!empty($detail->pegawai_id)){
                                                $peg = PegawaiM::model()->findByPk($detail->pegawai_id);
                                                $namaPeg = $peg->namaLengkap;
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                   <?php echo $namaPeg; ?> 
                                                </td>
                                            </tr>
                                            <?php 
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php } ?>
                <?php if($model->jenissurat == 'MoU' || $model->jenissurat == 'Perizinan'){ ?>
                <tr>
                    <td> Judul </td>
                    <td>
                    : <?php echo $model->judul; ?>
                    </td>
                </tr>
                <tr>
                    <td> Pihak 1</td>
                    <td>
                    : <?php echo $model->pihak1; ?>
                    </td>
                </tr>
                <tr>
                    <td> Pihak 2</td>
                    <td>
                    : <?php echo $model->pihak2; ?>
                    </td>
                </tr>
                <tr>
                    <td> Unit Kerja Penanggung Jawab</td>
                    <td>
                    : <?php echo $model->unitkerja_penanggungjawab_nama; ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td> Dokumentasi Kegiatan</td>
                    <td>
                    : <?php 
                        if(!empty($model->dokumen)){
                            echo CHtml::link($model->dokumen, Yii::app()->createUrl('kepegawaian/InformasiSuratInternal/download', array("suratinternal_id"=>$model->suratinternal_id)), array("id" => $model->suratinternal_id));
                        } 
                    ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>