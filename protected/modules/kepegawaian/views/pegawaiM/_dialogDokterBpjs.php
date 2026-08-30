<div class="row-fluid form-horizontal">
    <div class="span6">    
        <div class="control-group ">
            <?php echo CHtml::label('Nama Dokter','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nama_dokterbpjs','',array('class'=>'span3','placeholder'=>'Ketikan nama Dokter')); ?>
                <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                        array('onclick'=>'cariDataDokter();return false;',
                                  'class'=>'btn btn-mini btn-primary btn-katakunci',
                                  'onkeypress'=>"cariDataDokter();return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Dokter")); ?>
            </div>
        </div>
</div>
</div>
<div class="block-tabel">
	<table class="items table table-striped table-condensed" id="table-dokter">
		<thead>
			<tr>
                <th style="width: 20px;">Pilih</th>
				<th>Kode</th>
				<th>Nama</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>	
<script type="text/javascript">
    function cariDataDokter() {
        var value = $('#nama_dokterbpjs').val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        if (value == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        }
        $("#table-dokter").find('tbody').addClass("animation-loading");
        $("#table-dokter").find('tbody').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('kepegawaian/pegawaiM/SetFormDokterBpjs'); ?>',
            data: {query: value}, //
            dataType: "json",
            success: function (data) {
                if(data.sukses == 1){
                    $("#table-dokter").find('tbody').html(data.html);
                }else{
                    myAlert(data.pesan);
                }
                
                $("#table-dokter").find('tbody').removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                $("#table-dokter").find('tbody').removeClass("animation-loading");
            }
        });
    }

    function setDokterBpjs(value){
        $('#<?php echo CHtml::activeId($model,'kodedokter_bpjs'); ?>').val(value);
        $("#dialogDokterBpjs").dialog("close");
        
    }

    
 $(document).ready(function(){
    $('#nama_dokterbpjs').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
           cariDataDokter();
           return false;
        }
    });
 })
</script>