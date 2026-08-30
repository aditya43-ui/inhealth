<div class="row form-horizontal">
    <div class="col-sm-6">    
        <div class="control-group">
            <?php echo CHtml::label('Kata Kunci (Kode / Nama)','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('katakunci_poli','',array('class'=>'span3','placeholder'=>'Ketikan Kata Kunci')); ?>
                <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                        array('onclick'=>'searchDataKodeBpjs();return false;',
                                  'class'=>'btn btn-mini btn-primary btn-katakunci',
                                  'onkeypress'=>"searchDataKodeBpjs();return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Ruangan Inhealth",)); ?>
            </div>
        </div>
</div>
</div>
<div class="block-tabel">
	<table class="items table table-striped table-condensed" id="table-inhealthruangan">
		<thead>
			<tr>
                <th style="width: 20px;">Pilih</th>
                <!-- <th style="width: 40px;">No.</th> -->
                <th>Kode Poli</th>
                <th>Nama Poli</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>	
<script type="text/javascript">
    function searchDataKodeBpjs() {
        var search = $('#katakunci_poli').val();
        if ("<?php echo Yii::app()->user->getState('isbridging'); ?>" == true) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        // if (search == "") {
        //     myAlert('Silahkan Nama Ruangan !');
        //     return false;
        // }
        $("#table-inhealthruangan").addClass("animation-loading");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetKodeBpjs'); ?>',
            data: {query: search},
            dataType: "json",
            success: function (data) {
                $("#table-inhealthruangan").removeClass("animation-loading");
                $('#table-inhealthruangan').find('tbody').html(data.form);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#table-inhealthruangan").removeClass("animation-loading");
                console.log(errorThrown);
            }
        });
    }

    function getNamaPoli(value){
        $('#<?php echo CHtml::activeId($model,'kode_bpjs') ?>').val(value);
        $("#dialogKodeBpjs").dialog("close");
    }

    $(document).ready(function(){
        setTimeout(function(){
            searchDataKodeBpjs();
        },300);
    });

    function cariDataPoli() {
        var katakunci = $('#katakunci_poli').val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }

        if (isi == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#table-inhealthruangan").addClass("animation-loading");
            },
            success: function(data) {
                $("#table-inhealthruangan").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                    $("#table-inhealthruangan").remove();
                }

                var list = obj.response.poli;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('setFormPoli'); ?>',
                    data: {
                        poliList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#table-inhealthruangan").remove();
                        $('#table-inhealthruangan').append(data.form);
                        renameInputRow($("#table-inhealthruangan"));
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                $("#table-inhealthruangan").removeClass("animation-loading");
                myAlert('Terjadi kesalahan saat briging');
                $("#table-inhealthruangan").remove();
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    
    
</script>