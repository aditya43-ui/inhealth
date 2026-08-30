<?php

/**
 * - digunakan untuk menampilkan inputan penandaan operasi
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 * awal penandaan operasi 
 */
?>
<style>
    .ui-autocomplete {
        z-index: 10000 !important;
    }
</style>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Penandaan Operasi
        </div>
    </div>
    <div class="panel-body">
        <?php if (empty($modKunjungan->pasienadmisi_id)) { ?>
            Formulir penandaan akan tampil jika pasien berasal dari rawat inap.
        <?php } else { ?>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Prosedur Operasi", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modAreaOperasi, 'proseduroperasi') ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">

                    <div class="control-group">
                        <?php echo $form->labelEx($modAreaOperasi, 'pegawai_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                            echo $form->hiddenField($modAreaOperasi, 'pegawai_id', array('readonly' => true, 'class' => ''));

                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modAreaOperasi,
                                'attribute' => 'pegawai_nama',
                                'source' => 'js: function(request, response) {
										$.ajax({
										url: "' . $this->createUrl('/ActionAutoComplete/dropDokterRuangan') . '",
										dataType: "json",
										data: {
											term: request.term,
											ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
										},
										success: function (data) {
											response(data);
										}
									})
								}',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 0,
                                    'focus' => 'js:function( event, ui ) {
										 $(this).val( ui.item.label);
										 return false;
									 }',
                                    'select' => 'js:function( event, ui ) {
										 $("#' . CHtml::ActiveId($modAreaOperasi, 'pegawai_id') . '").val(ui.item.value); 
										 return false;
									 }',
                                ),
                                'htmlOptions' => array('class' => 'span3')
                            ));

                            ?>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body" style="width:880px !important;">
                    <?php
                $i = 1;
                $gbrTubuh = $modGambarTubuh->AllDataGambarAnatomi;
                foreach ($gbrTubuh as $tbh) {
                    if($tbh->jeniskelamin != $modKunjungan->jeniskelamin) {
                        continue;
                    }
                    if ($i == 1) {
                        $css = " 
								#imgtag" . $tbh->gambartubuh_id . "
								{
										position: relative;
										min-width: 300px;
										min-height: 300px;
										float: none;
										border: 3px solid #FFF;
										cursor: crosshair;
										text-align: center;
										z-index:10 !important;
								}
								#tagit" . $tbh->gambartubuh_id . "
								{
										position: absolute;
										top: 0;
										left: 0;
										width: 300px;
										border: 1px solid #D7C7C7;
										z-index: 10;
								}
								#tagit" . $tbh->gambartubuh_id . " .name
								{
										/*float: left;*/
										background-color: #FFF;
										width: 295px;
										/*height: 92px;*/
										/*padding: 5px;*/
										font-size: 10pt;
										margin:0 auto;
										margin-bottom: 0 auto;
								}
								#tagit" . $tbh->gambartubuh_id . " DIV.text
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
								{
										width: 110px;
								}";
                ?>
                        
                        <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                            
                            <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" data-id="<?php echo $tbh->gambartubuh_id ?>" />
                            <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                        </div>
                        <!--  -->
                            <?php
                            } else {

                             //   if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD ||  Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
                                $css .= " 
									#imgtag" . $tbh->gambartubuh_id . "
									{
											position: relative;
											min-width: 300px;
											min-height: 300px;
											float: none;
											border: 3px solid #FFF;
											cursor: crosshair;
											text-align: center;
											z-index:10 !important;
									}
									#tagit" . $tbh->gambartubuh_id . "
									{
											position: absolute;
											top: 0;
											left: 0;
											width: 300px;
											border: 1px solid #D7C7C7;
											z-index: 10;
									}
									#tagit" . $tbh->gambartubuh_id . " .name
									{
											/*float: left;*/
											background-color: #FFF;
											width: 295px;
											/*height: 92px;*/
											/*padding: 5px;*/
											font-size: 10pt;
											margin:0 auto;
											margin-bottom: 0 auto;
									}
									#tagit" . $tbh->gambartubuh_id . " DIV.text
									{
											margin-bottom: 5px;
									}
									#tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
									{
											margin-bottom: 5px;
									}
									#tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
									{
											width: 110px;
									}";
                            ?>
                              

                                <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                            
                            <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" data-id="<?php echo $tbh->gambartubuh_id ?>" />
                            <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                        </div>
                        <?php
                            }
                             //  }
                            $i++;
                        }
                        Yii::app()->clientScript->registerCss('anatomi', $css);
                        ?>
                        <?php /*
						<div align="center" id="imgtag">
							<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
							<div id="tagbox"></div>
						</div>
						 * 
						 */ ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class='block-tabel'>
                            <table class="items table table-bordered table-striped table-condensed" id="table-bagtubuh">
                                <thead>
                                    <tr>
                                        <th width='30'>No.</th>
                                        <th>Bagian Tubuh</th>
                                        <th>Keterangan</th>
                                        <th width='80'>Batal / Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count((array)$modAreaDetOp) > 0) {
                                        $i = 1;
                                        $a = 0;
                                        foreach ($modAreaDetOp as $ii => $vv) {
                                            $vv->namabagtubuh = $vv->bagiantubuh->namabagtubuh ?? '';
                                            $vv->kordinat_tubuh_x = number_format($vv->kordinat_tubuh_x, 7);

                                            //var_dump($vv->kordinat_tubuh_y);
                                            echo $this->renderPartial("_rowDetail", array('modPemeriksaanGbr' => $vv, 'i' => $i, 'a' => $a), true);
                                            $i++;
                                            $a++;
                                        }
                                    }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
<?php
/**
 * akhir penandaan operasi
 */
?>

<script>
    function batalTambahBagianTubuh(obj) {
        var conf = confirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini ?");

        //myConfirm("Apakah Anda akan membatalkan pemilihan pemeriksaan ini?","Perhatian!",
        // function(r){
        if (conf) {
            var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
            var gambartubuh_id = $(obj).parents('tr').find('input[name$="[gambartubuh_id]"]').val();
            var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
            var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
            var areaoperasidet_ket = $(obj).parents('tr').find('.areaoperasidet_ket').val();

            kordinat_tubuh_x = kordinat_tubuh_x.replace(/\./g, '_');
            kordinat_tubuh_y = kordinat_tubuh_y.replace(/\./g, '_');

            $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="' + bagiantubuh_id + '"]').each(function() {
                //$(obj).parents('tbody').find('input[name$="[gambartubuh_id]"][value="'+gambartubuh_id+'"]').each(function(){
                //alert($(this).attr('delete'));
                if ($(this).data('delete') == gambartubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y) {
                    $(this).parents('tr').detach();
                }
                //})
                //$(this).parents('tr').detach();
            });
            $("#imgtag" + gambartubuh_id).find('#titik_' + bagiantubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y).detach();
            renameInputRow($('#table-bagtubuh'));
        }
        // }); 
    }

    function hapusBagianTubuh(obj) {

        var bagiantubuh_id = $(obj).parents('tr').find('.bagiantubuh_id').val();
        var areaoperasidet_id = $(obj).parents('tr').find('.areaoperasidet_id').val();
        var gambartubuh_id = $(obj).parents('tr').find('.gambartubuh_id').val();
        var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
        var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
        var areaoperasidet_ket = $(obj).parents('tr').find('.areaoperasidet_ket').val();
        var pasienmasukpenunjang_id = <?php echo !empty($modKunjungan->pasienmasukpenunjang_id) ? $modKunjungan->pasienmasukpenunjang_id : "''"; ?>;


        var koor_tubuh_x = kordinat_tubuh_x.replace(/\./g, '_');
        var koor_tubuh_y = kordinat_tubuh_y.replace(/\./g, '_');

        var conf = confirm("Apakah Anda yakin akan menghapus pemeriksaan ini ?");

        //myConfirm("Apakah Anda akan menghapus pemeriksaan ini?","Perhatian!",
        //function(r){
        if (conf) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('HapusBagianTubuh') ?>",
                data: "bagiantubuh_id=" + bagiantubuh_id + "&areaoperasidet_id=" + areaoperasidet_id + "&gambartubuh_id=" + gambartubuh_id + "&kordinat_tubuh_x=" + kordinat_tubuh_x + "&kordinat_tubuh_y=" + kordinat_tubuh_y + "&areaoperasidet_ket=" + areaoperasidet_ket + "&pasienmasukpenunjang_id=" + pasienmasukpenunjang_id,
                dataType: "json",
                success: function(data) {
                    if (data.ok == 0) {
                        myAlert(data.pesan);
                    } else {


                        $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="' + bagiantubuh_id + '"]').each(function() {
                            if ($(this).data('delete') == gambartubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y) {
                                $(this).parents('tr').detach();
                            }
                        });
                        $("#imgtag" + gambartubuh_id).find('#titikbiru_' + bagiantubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y).detach();
                        renameInputRow($('#table-bagtubuh'));

                        alert(data.pesan);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
        //}); 
    }

    function titikSebelumSimpan(ptitikX, ptitikY, bagiantubuh_id, img) {
        var titikX = Math.round(ptitikX) - 10;
        var titikY = Math.round(ptitikY) - 10;
        var color = 'rgba(219, 50, 92, 0.9)';
        var size = '1px';

        var xtitik = ptitikX.replace(/\./g, '_');
        var ytitik = ptitikY.replace(/\./g, '_');


        $(img).append(
            $('<div id="titik_' + bagiantubuh_id + '_' + xtitik + '_' + ytitik + '"></div>')
            .css('position', 'absolute')
            .css('top', titikY + 'px')
            .css('left', titikX + 'px')
            .css('width', size)
            .css('height', size)
            .css('background-color', color)
            .css('cursor', 'pointer')
            .css('display', 'block')
            .css('padding', '5px')
            .css('-webkit-border-radius', '50%')
            .css('-moz-border-radius', '50%')
            .css('border-radius', '50%')
        );
    }

    function titikSesudahSimpan(titikX, titikY, urutan, bagiantubuh_id, img) {
        var x_titik = titikX.toFixed(7);
        var y_titik = titikY.toFixed(7);

        var titikX = titikX - 15;
        var titikY = titikY - 15;
        var nomor = urutan + 1;
        var color = 'rgba(0, 128, 255, 0.8)';
        var size = '5px';

        x_titik = x_titik.replace(/\./g, '_');
        y_titik = y_titik.replace(/\./g, '_');

        $(img).append(
            $('<div id="titikbiru_' + bagiantubuh_id + '_' + x_titik + '_' + y_titik + '"><strong style="position:absolute;top:0;left:7px;color:#fff;">' + nomor + '</b></div>')
            .css('position', 'absolute')
            .css('top', titikY + 'px')
            .css('left', titikX + 'px')
            .css('width', size)
            .css('height', size)
            .css('background-color', color)
            .css('cursor', 'pointer')
            .css('display', 'block')
            .css('padding', '10px')
            .css('-webkit-border-radius', '50%')
            .css('-moz-border-radius', '50%')
            .css('border-radius', '50%')
            .css('vertical-align', 'middle')
        );
    }

    function loadTitikSesudahSimpan() {
        <?php if (!empty($modAreaDetOp)) {
            $j = 1;
            foreach ($modAreaDetOp as $i => $v) { ?>
                titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i . ',' . $v->bagiantubuh_id ?>, '#imgtag<?php echo $v->gambartubuh_id; ?>');

        <?php $j++;
            }
        } ?>
    }

        function pilihSimbol(obj,no_img,mouseX,mouseY){
            if($(obj).val() == 2){
                
                 $('#titikklik' + no_img).remove();
                 
               $("#imgtag" + no_img).append(
                $('<div id="titikklik' + no_img + '"></div>')
                .css('position', 'absolute')
                .css('top', Math.round(mouseY) - 10 + 'px')
                .css('left', Math.round(mouseX) - 10 + 'px')
                .css('width', '5px')
                .css('height', '5px')
                .css('background-color', 'rgba(219, 50, 92, 0.5)')
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '5px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
            );
            }else{
                   $("#imgtag" + no_img).append(
                $('<div id="titikklik' + no_img + '"></div>')
                .css('position', 'absolute')
                .css('top', Math.round(mouseY) - 45 + 'px')
                .css('left', Math.round(mouseX) - 30 + 'px')
                .css('width', '100px')
                .css('height', '100px')
        .css('border', '2px solid rgba(219, 50, 92, 0.5)')
//        border:1px solid red;
                .css('background-color', 'rgba(0,0,0,0)')
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '5px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
            );
            }
        }
    $(document).ready(function() {

        loadTitikSesudahSimpan();


        var counter = 0;
        var mouseX = 0;
        var mouseY = 0;

        $("[id^=imgtag] img").click(function(e) { // make sure the image is click				
            var imgtag = $(this).parent(); // get the div to append the tagging list
            var no_img = $(this).attr('img-no');
            var gambartubuh_id = $(this).attr('alt');
            mouseX = (e.pageX - $(imgtag).offset().left); // x and y axis
            mouseY = (e.pageY - $(imgtag).offset().top);

            $('#titikklik' + no_img).remove(); // menghapus titik lain selain titik current klik

     $("#imgtag" + no_img).append(
                $('<div id="titikklik' + no_img + '"></div>')
                .css('position', 'absolute')
                .css('top', Math.round(mouseY) - 45 + 'px')
                .css('left', Math.round(mouseX) - 30 + 'px')
                .css('width', '100px')
                .css('height', '100px')
        .css('border', '2px solid rgba(219, 50, 92, 0.5)')
//        border:1px solid red;
                .css('background-color', 'rgba(0,0,0,0)')
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '5px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
            );
            var html = '<div id="tagit' + no_img + '">\n\
				<div class="name"  style="padding:10px;"><br>\n\
					<div class="text"><b>Data Pemeriksaan</b></div>\n\
					<table>\n\
						<tr>\n\
							<td>Simbol Penanda : </td>\n\
							<td>\n\
<select id="bagiantubuh_id' + no_img + '" name="jenis_simbol" onchange="pilihSimbol(this,'+no_img+','+mouseX+','+mouseY+')" class="span2">\n\
<option value="1">Lingkaran</option>\n\
<option value="2">Titik</option>\n\
								\n\
							</select>\n\
							</td>\n\
						</tr>\n\
<tr>\n\
							<td>Bagian Tubuh : </td>\n\
							<td>\n\
								<input type="hidden" id="gambartubuh_id' + no_img + '" value="' + gambartubuh_id + '">\n\
								<select id="bagiantubuh_id' + no_img + '" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
								<option value="">-- Pilih --</option>\n\
								<?php foreach ($modBagianTubuh->BagianTubuh as $key => $value) { ?>\n\
									<option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
								<?php } ?>\n\
							</select>\n\
							</td>\n\
						</tr>\n\
						<tr>\n\
							<td>Nama Bag Tubuh : </td>\n\
							<td><textarea id ="namabagtubuh' + no_img + '" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                                                                                                                                            ?><br>\n\</td>\n\
						</tr>\n\
                        <tr>\n\
							<td>Keterangan : </td>\n\
							<td><textarea id ="keterangan' + no_img + '" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                                                                                                                                            ?><br>\n\</td>\n\
						</tr>\n\
					</table>\n\
						<input img-no="' + no_img + '" type="button" name="btnsave" value="Tambah" id="btnsave' + no_img + '" />\n\
						<input img-no="' + no_img + '" type="button" name="btncancel" value="Cancel" id="btncancel' + no_img + '" /><br><br>\n\
					</div>\n\
				</div>';

            $('#tagit' + no_img).remove(); // remove any tagit div first
            $(imgtag).append(html);
            $('#tagit' + no_img).css({
                top: mouseY,
                left: mouseX
            });

            $('#tagname' + no_img).focus();


            mouseY = mouseY.toFixed(7);
            mouseX = mouseX.toFixed(7);
        });
        

        //$("#tagit1 #btnsave1").click(function(){ 
        $(document).on('click', '[id^=tagit] [id^=btnsave]', function() {
            var no_img = $(this).attr('img-no');
            var bagiantubuh_id = $('#bagiantubuh_id' + no_img).val();
            var keterangan = $('#keterangan' + no_img).val();
            var namabagtubuh = $('#namabagtubuh' + no_img).val();
            var gambartubuh_id = $('#gambartubuh_id' + no_img).val();
            var img = $('#imgtag' + no_img).find('img');
            var id = $(img).attr('id');
            //var koorX = $( img ).attr( 'mousex' );
            //var koorY = $( img ).attr( 'mousey' );
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('tambahBagianTubuh') ?>",
                data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&namabagtubuh=" + namabagtubuh + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert" + "&gambartubuh_id=" + gambartubuh_id,
                dataType: "json",
                success: function(data) {
                    if (data.pesan != "") {
                        myAlert(data.pesan);
                    } else {
                        $('#table-bagtubuh > tbody').append(data.form);
                        renameInputRow($('#table-bagtubuh'));
                        titikSebelumSimpan(data.axis['x'], data.axis['y'], data.bagiantubuh_id, '#imgtag' + no_img);
                    }
                    //          viewtag( id );
                    $('#tagit' + no_img).fadeOut();
                    $('#titikklik' + no_img).remove();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        });

        // Cancel the tag box.
        $(document).on('click', '[id^=tagit] [id^=btncancel]', function() {
            var no_img = $(this).attr('img-no');
            $('#tagit' + no_img).fadeOut();
            $('#titikklik' + no_img).remove();
        });

        // mouseover the taglist 
        $('#taglist').on('mouseover', 'li', function() {
            id = $(this).attr("id");
            $('#view_' + id).css({
                opacity: 1.0
            });
        }).on('mouseout', 'li', function() {
            $('#view_' + id).css({
                opacity: 0.0
            });
        });

        // mouseover the tagboxes that is already there but opacity is 0.
        $('#tagbox').on('mouseover', '.tagview', function() {
            var pos = $(this).position();
            $(this).css({
                opacity: 1.0
            }); // div appears when opacity is set to 1.
        }).on('mouseout', '.tagview', function() {
            $(this).css({
                opacity: 0.0
            }); // hide the div by setting opacity to 0.
        });

        // Remove tags.
        $('#taglist').on('click', '.remove', function() {
            id = $(this).parent().attr("id");
            // Remove the tag
            $.ajax({
                type: "POST",
                url: "savetag.php",
                data: "tag_id=" + id + "&type=remove",
                success: function(data) {
                    var img = $('#imgtag').find('img');
                    var id = $(img).attr('id');
                    //get tags if present
                    viewtag(id);
                }
            });
        });

        // load the tags for the image when page loads.
        var img = $('#imgtag').find('img');
        var id = $(img).attr('id');

    });
</script>