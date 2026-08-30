<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);


$format = new MyFormatter();
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$judulLaporan = 'SURAT KETERANGAN KELAYAKAN VAKSINASI COVID-19';

if (!empty($_GET['suratketerangan_id'])) {
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}


?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p {
        text-indent: 50px;
        text-align: justify;
    }

    .add-on {
        border: #ddd 1px solid;
        padding: 6px;
        border-radius: 5px;
    }

    .table-checklist {
        border: #000 1px solid;
        padding: 6px;
    }

    .table-checklist tr>td {
        padding: 6px;
    }

    .table-checklist .btm {
        padding: 6px;
        border-bottom: #000 1px solid;
    }

    .table-checklist .bord {
        border-left: #000 1px solid;
        border-right: #000 1px solid;
        text-align: center;
        padding: 6px;
    }

    #txt_tanggal .input-append {
        display: inline-block;
    }
</style>
<div>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultSuratKeterangan'); ?>
</div>
<div class="content">
    <TABLE ALIGN="CENTER">
        <tr>
            <td ALIGN=CENTER VALIGN=MIDDLE>
                <div class="judulcontent"> <B><span SIZE=4><?php echo $model->judulsurat; ?></span></B></div>
            </td>
        </tr>
        
    </TABLE>
    </br><br />
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>    
    <table width="100%" style="width:500px;margin-left:50px;">
        <tr>
            <td width="180">Pegawai pemeriksa</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    echo $model->mengetahui_surat;
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <p align="justify">
        Menerangkan bahwa :
    </p>  
    <table width="100%" style="width:500px;margin-left:50px;">
        <tr>
            <td width="180">Nama</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    echo $modPasien->nama_pasien;
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td width="180">Tanggal Lahir</td>
            <td width="10">:</td>
            <td>
                <div class="controls">
                    <?php
                    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
                    echo $modPasien->tanggal_lahir; 
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <br />    
    <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
        Setelah dilakukan pengkajian yang komprehensi 
        <?php
        if($model->islayak == 0){
            echo "<b>layak /<span style='text-decoration: line-through;'>tidak Layak</span>*</b>";
        } else{
            echo "<b><span style='text-decoration: line-through;'>layak</span>/tidak Layak*</b>";
        }
        ;?> mendapatkan vaksinasi covid
    </div></br>
    <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
        Demikian surat keterangan ini dibuat untuk digunakan dengan semestinya
    </div>   
</div><br><br><br><br><br>
<div class="">
    <div class="">
        <label class="font-13px" style="width:100%">
            <table class="tabel-surat">
                <tr style="text-align: center;">
                    <td width="30%">
                  
                    </td>
                    <td width="40%">
                    </td>
                    <td width="30%">
                        <?php $date = date('Y-m-d'); ?>
                        <?php echo $data->kabupaten->kabupaten_nama; ?>, <?php echo ($format->formatDateTimeForUser(date('Y-m-d'))); 
                                                                                        ?><br>
                        <!-- <?php //echo strtoupper($data->nama_rumahsakit);
                                ?>, -->
                        <!-- Dokter Pemeriksa -->
                        <br><br><br><br><br>

                        <?php

                        echo $model->mengetahui_surat;
                        echo CHtml::activeCheckBox($model, 'islayak',['id'=>'cb-layak', 'class'=>'hide']);
                        ?>

                    </td>
                </tr>
                <tr>
                    <td width="80%" colspan="2">
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
        </label>
    </div>
</div>
</TABLE>

<script>
    function pilihFisik(obj) {
        var val = $(obj).attr('val');

        $("[id^=fisik]").each(function() {
            if ($(this).attr('val') != val) {
                $(this).addClass('line-words');
            } else {
                $(this).removeClass('line-words');
                $("#<?php echo CHtml::activeId($model, 'kelayakan_jiwa') ?>").val(val);
            }
        });
    }

    function setPenandaTangan() {
        var opt = $("#RKSuratketeranganR_mengetahui_surat :selected");

        $("#nama_pegawai").val($(opt).data('nama'));
        $("#sip").val($(opt).data('sip'));
        $("#jabatan").val($(opt).data('jabatan'));
        $("#instansi").val($(opt).data('instansi'));
    }

    function setInstansiDiri() {
        var nilai = $('#permintaandari').val();

        if (nilai == 'Instansi') {
            $('#instansidiri').show();
        } else {
            $('#instansidiri').hide();
        }
    }
    const cekLayak = (jenis, obj) => {
        const active = $(obj).hasClass("active");
        $(".st-layak").removeClass("active");
        $(".st-layak").removeClass("strike");
        $("#cb-layak").prop("checked", false);
        
        if (jenis == 'layak' && !active){
            $(obj).addClass('active');
            $(obj).addClass('strike');
            $("#cb-layak").prop("checked", true);
        }else if (jenis == 'tidak-layak' && !active){
            $(obj).addClass('strike');
            $(obj).addClass('active');
        }
    }
    
    $(document).ready(function(){        
        <?php if ($model->islayak === true){ ?>
                cekLayak('tidak-layak', $("#tidaklayak"));                
        <?php }else{ ?>
                cekLayak('layak', $("#layak"));
        <?php } ?>
    })
</script>