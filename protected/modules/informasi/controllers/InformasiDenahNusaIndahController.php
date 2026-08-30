<?php
/**
 * pembuatan fungsi denah Nusa Indah
 * RSST-4422
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.informasi
 * @subpackage      controllers
 * 
 */
class InformasiDenahNusaIndahController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $defaultAction = 'index';
  public $layout = '//layouts/iframe';

  /**
   * digunakan untuk menampilkan denah
   * @param integer $instalasi_id menampung instalasi id
   * @param integer $ruangan_id menampung ruangan id
   */
  public function actionIndex($instalasi_id = '', $ruangan_id = '')
  {
    $model = INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');

    $row = '';
    if ((isset($_POST['ajax'])) && (isset($_POST['ruangan']))) {
      $ruangan = $_POST['ruangan'];
      $model = INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =" . $ruangan . " and " : "") . 'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
      $row = $this->renderKamarRuangan($model);

      echo json_encode($row);
      Yii::app()->end();
    }

    $this->render('index', array(
      'model' => $model,
      'row' => $row,
      'instalasi_id' => $instalasi_id,
      'ruangan_id' => $ruangan_id,
    ));
  }

  /**
   * digunakan untuk render denah kamar
   * @param object $model menampung model yang dimaksud
   * @return string result html hasil render denah
   */
  protected function renderKamarRuangan($model)
  {
    $result = '';
    $tempRuangan = '';
    $list1 = array();
    $pasien_kamar = array();
    $jml = 0;
    foreach ($model as $i => $row) {
      if ($row->ruangan_id != $tempRuangan) {
        $tempJumlah = 0;
        $list1[$row->ruangan_id]['name'] = $row->ruangan_nama;
        $list1[$row->ruangan_id]['ruangan_id'] = $row->ruangan_id;
        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;

        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;


        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['keterangan_kamar'] = $row->keterangan_kamar;
        $tempJumlah = $row->kamarruangan_jmlbed;
        $tempRuangan = $row->ruangan_id;
      } else {
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;

        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
        if ($row->kamarruangan_jmlbed >= $tempJumlah) {
          $jml = $row->kamarruangan_jmlbed;
          $tempJumlah = $row->kamarruangan_jmlbed;
        }
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['jml'] = $jml;
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['keterangan_kamar'] = $row->keterangan_kamar;
      }
    }

    foreach ($list1 as $i => $v) {
      $result .= '<link rel="stylesheet" type="text/css" href="css/font.css" /> ';
      $result .= "<style>.contentKamar{
                            
                             width:100% !important;
                           
                        }
                        table{
                            font-size:12pt ;
                            color:white !important;
                            font-family:oswald !important;
                            font-weight: normal;
                        }
                        .backKamar{
                            
                             width:1042px !important;
                             height:695px !important;
                             border-bottom-right-radius: 15px;
                             border-top-left-radius: 15px;
                             background-repeat:no-repeat;
                             background-size: 1042px 695px;
                             
                            
                             
                        }
                        .denahketerangan{
                            background-color:#d3d3d3 !important;
                            height:85% !important;
                           
                        }
                        #tinggipasien{
                            height:695px !important;
                        }
                        .scrolpasien{
                            height:100% !important;
                            overflow:auto;
                        }
                        .scroldenah{
                            height:100%;
                            
                        }
                        #back-tutup{
                            border-bottom-right-radius: 10px;
                            border-top-left-radius: 10px;
                            background-color:#d3d3d3;
                            height:695px !important;
                            
                        }
                        #myCanvas{
                            
                            width:1042px !important;
                            height:695px !important;
                            
                             border-top-left-radius: 10px;
                             background-repeat:no-repeat;
                             background-size: 1042px 695px;
                             
                            background-image: url('" . Yii::app()->request->baseUrl . "/images/denah/" . $tempRuangan . ".png');
                             
                        }
                       
                        </style>";

      $ruangan = RuanganM::model()->findByPk($v['ruangan_id']);
      $dataRuangan = '';

      foreach ($v['kamar'] as $j => $w) {

        foreach ($w['kamar'] as $x => $y) {

          foreach ($y['bed'] as $a => $b) {
            $kamar = MasukkamarT::model()->find('kamarruangan_id = ' . $b['id'] . ' order by tglmasukkamar desc');
            //validasi bergantung tiap ruangan

            $pasien_kamar[] = array("ruangan_id" => !empty($v['ruangan_id']) ? $v['ruangan_id'] : "", "kamar" => !empty($y['name']) ? $y['name'] : "", "kelaspelayanan_nama" => !empty($w['kelaspelayanan']) ? $w['kelaspelayanan'] : "", "alamat_pasien" => !empty($kamar->admisi->pasien->alamat_pasien) ? $kamar->admisi->pasien->alamat_pasien : "", "keterangan_kamar" => !empty($b['keterangan_kamar']) ? $b['keterangan_kamar'] : "", "tanggal_lahir" => !empty($kamar->admisi->pasien->tanggal_lahir) ? $kamar->admisi->pasien->tanggal_lahir : "", "nama_pasien" => !empty($kamar->admisi->pasien->nama_pasien) ? $kamar->admisi->pasien->nama_pasien : "", "no_rekam_medik" => !empty($kamar->admisi->pasien->no_rekam_medik) ? $kamar->admisi->pasien->no_rekam_medik : "", "no_kamar" => $b['no'], "jekel" => !empty($kamar->admisi->pasien->jeniskelamin) ? $kamar->admisi->pasien->jeniskelamin : "");
          }
        }
      }
    }

    $result .= '<div class="contentKamar" align=center>';
    $result .= '<div class="row" id="back-tutup">';

    $result .= '<div class="col-md-9" style="padding:0" align=left>';
    $result .= '<div class="scroldenah">';
    $result .= '<canvas id="myCanvas"  width="1042px" height="695px" ></canvas>';
    $result .= '</div>';
    $result .= '</div>';
    $result .= '<div class="col-md-3" id="tinggipasien">';
    $result .= '<div class="col-md-12" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px; background-color:#86c23c;">';
    $result .= '<div style="color:white; font-weight: bold;font-family:oswald;font-size:18pt !important;">';
    $result .= 'INFORMASI KAMAR RUANGAN NUSA INDAH'; /* judul disesuaikan dengan nama ruangan */
    $result .= '</div>';
    $result .= '</div>';
    $result .= '<div class="denahketerangan" align="center">';
    $result .= '<div class="scrolpasien">';
    foreach ($pasien_kamar as $rowkamar) {

      $result .= '<div class="col-md-10" style="border-radius: 5px; background-color:#a5a5a5; padding:5px; padding-left:0;  margin:1px">';
      $result .= '<div class="col-md-3" style="border-radius: 5px; background-color:#646464; padding:0;">';
      $result .= '<table >';
      $result .= '<tr>';
      $result .= '<td >';
      $result .= '<div align="center">No.Bed<div>';
      $result .= '</td>';
      $result .= '</tr>';
      $result .= '<tr>';
      $result .= '<td align="center">';
      $result .= '<div style="font-weight: bold;font-family:oswald;font-size:26pt !important;">';
      $result .= !empty($rowkamar['no_kamar']) ? $rowkamar['no_kamar'] : "";
      $result .= '</div>';
      $result .= '<div style="font-weight: normal;font-family:oswald;font-size:10pt !important;">';
      $result .= 'No. Kamar &nbsp;';
      $result .= !empty($rowkamar['kamar']) ? $rowkamar['kamar'] : "";
      $result .= '</div>';
      $result .= '</td>';
      $result .= '</tr>';
      $result .= '</table>';
      $result .= '</div>';
      $result .= '<div class="col-md-9" align="left">';
      $result .= '<table >';
      $result .= '<tr>';
      $result .= '<td style="vertical-align:top">';
      $result .= 'No. RM';
      $result .= '</td>';
      $result .= '<td style="vertical-align:top">';
      $result .= '&nbsp:&nbsp;</td>';
      $result .= '<td style="vertical-align:top">';

      $result .= !empty($rowkamar['no_rekam_medik']) ? $rowkamar['no_rekam_medik'] : "";
      $result .= '</td>';
      $result .= '</tr>';

      $result .= '<tr>';
      $result .= '<td style="vertical-align:top">';
      $result .= 'Nama Pasien';
      $result .= '</td>';
      $result .= '<td style="vertical-align:top">';
      $result .= '&nbsp:&nbsp;</td>';
      $result .= '<td style="vertical-align:top">';

      $result .= !empty($rowkamar['nama_pasien']) ? $rowkamar['nama_pasien'] : "";
      $result .= '</td>';
      $result .= '</tr>';

      $result .= '<tr>';
      $result .= '<td style="vertical-align:top">';
      $result .= 'Alamat';
      $result .= '</td>';
      $result .= '<td style="vertical-align:top">';
      $result .= '&nbsp:&nbsp;</td>';
      $result .= '<td style="vertical-align:top">';

      $result .= !empty($rowkamar['alamat_pasien']) ? $rowkamar['alamat_pasien'] : "";
      $result .= '</td>';
      $result .= '</tr>';

      $result .= '<tr>';
      $result .= '<td style="vertical-align:top">';
      $result .= 'Tanggal Lahir';
      $result .= '</td>';
      $result .= '<td style="vertical-align:top">';
      $result .= '&nbsp:&nbsp;</td>';
      $result .= '<td style="vertical-align:top">';

      $result .= !empty($rowkamar['tanggal_lahir']) ? MyFormatter::formatDateTimeForUser($rowkamar['tanggal_lahir']) : "";
      $result .= '</td>';
      $result .= '</tr>';

      $result .= '<tr>';
      $result .= '<td style="vertical-align:top">';
      $result .= 'Status Kamar';
      $result .= '</td>';
      $result .= '<td style="vertical-align:top">';
      $result .= '&nbsp:&nbsp;</td>';
      $result .= '<td style="vertical-align:top">';

      $result .= !empty($rowkamar['keterangan_kamar']) ? $rowkamar['keterangan_kamar'] : "";
      $result .= '</td>';
      $result .= '</tr>';

      $result .= '<tr>';
      $result .= '<td style="vertical-align:top">';
      $result .= 'Kelas';
      $result .= '</td>';
      $result .= '<td style="vertical-align:top">';
      $result .= '&nbsp:&nbsp;</td>';
      $result .= '<td style="vertical-align:top">';

      $result .= !empty($rowkamar['kelaspelayanan_nama']) ? $rowkamar['kelaspelayanan_nama'] : "";
      $result .= '</td>';
      $result .= '</tr>';

      $result .= '</table>';
      $result .= '</div>';
      $result .= '</div>';
    }
    $result .= '</div>';
    $result .= '</div>';
    $result .= '</div">';

    $result .= "</div>";

    $result .= '</div>';

    $result .= '<script>
                       $( document ).ready(function() {
                        var canvas=document.getElementById("myCanvas");
                        var ctx=canvas.getContext("2d");
                        var cw=canvas.width;
                        var ch=canvas.height;
                        console.log("adada");
                        function reOffset(){
                          var BB=canvas.getBoundingClientRect();
                          offsetX=BB.left;
                          offsetY=BB.top;        
                        }
                        var offsetX,offsetY;
                        reOffset();
                        window.onscroll=function(e){ reOffset(); }
                        window.onresize=function(e){ reOffset(); }
                        //berikut ini adalah koordinat statis marker 
                        //untuk setiap denah berbeda korrdinat
                        var hotspots=[
                          
                          
                          {id:1,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:700,y:580,radius:30,tip:"Bed:"},
                          {id:2,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:800,y:580,radius:30,tip:"Bed:"},
                          {id:3,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:960,y:460,radius:30,tip:"Bed:"},
                          {id:4,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:600,y:580,radius:30,tip:"Bed:"},
                          {id:5,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:500,y:550,radius:30,tip:"Bed:"},
                          {id:6,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:430,y:580,radius:30,tip:"Bed:"},
                          {id:7,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:360,y:550,radius:30,tip:"Bed:"},
                          {id:8,kamarruangan_nokamar:"VIP-01",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:300,y:580,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-02",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:230,y:500,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-03",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:230,y:560,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-04",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:120,y:560,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-05",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:120,y:500,radius:30,tip:"Bed:"},
                          {id:2,kamarruangan_nokamar:"VIP-05",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:50,y:500,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-06",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:50,y:200,radius:30,tip:"Bed:"},
                          {id:2,kamarruangan_nokamar:"VIP-06",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:120,y:250,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-07",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:170,y:200,radius:30,tip:"Bed:"},
                          {id:2,kamarruangan_nokamar:"VIP-07",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:230,y:250,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-08",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:300,y:200,radius:30,tip:"Bed:"},
                          {id:2,kamarruangan_nokamar:"VIP-08",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:370,y:250,radius:30,tip:"Bed:"},
                          {id:1,kamarruangan_nokamar:"VIP-09",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:440,y:200,radius:30,tip:"Bed:"},
                          {id:2,kamarruangan_nokamar:"VIP-09",kelaspelayanan_nama:"VIP",ruangan_id:"618",uri:"",x:510,y:250,radius:30,tip:"Bed:"},
                          {id:"1",kamarruangan_nokamar:"farmasi",kelaspelayanan_nama:"",ruangan_id:"619",uri:"",x:780,y:460,radius:30,tip:"Bed:"},
                          {id:"1",kamarruangan_nokamar:"gudang",kelaspelayanan_nama:"",ruangan_id:"619",uri:"",x:880,y:460,radius:30,tip:"Bed:"},
                          {id:"1",kamarruangan_nokamar:"musola",kelaspelayanan_nama:"",ruangan_id:"619",uri:"",x:170,y:500,radius:30,tip:"Bed:"},
                        ];
                        
                         
                        // It"s better to use async image loading.
                        const loadImage = url => {
                          return new Promise((resolve, reject) => {
                            const img = new Image();
                            img.onload = () => resolve(img);
                            //img.onerror = () => reject(new Error(`load ${url} fail`));
                            img.src = url;
                          });
                        };

                        // Here, I created a function to draw image.
                        const depict = options => {

                          // And this is the key to this solution
                          // Always remember to make a copy of original object, then it just works :)
                          const myOptions = Object.assign({}, options);
                          return loadImage(myOptions.uri).then(img => {
                            ctx.font = "Bold 8pt Calibri";
                            ctx.fillStyle = "#492528";
                            ctx.fillText(myOptions.tip,(myOptions.x)-2,(myOptions.y)+52);
                            ctx.drawImage(img, myOptions.x, myOptions.y, 35, 45);
                          });
                        };
                            

                        draw();
                          //digunakan untuk tooltip  
                          //$("#myCanvas").mousemove(function(e){handleMouseMove(e);});
                          
                          // untuk set marker ke variabel hotspot
                          function draw(){
                          var pasien_kamar =' . json_encode($pasien_kamar) . ';
                          console.log(pasien_kamar);    
                          iconkosong="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-kosong.svg";
                          iconlakilaki="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-pria.svg";
                          iconperempuan="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-wanita.svg";
                          iconfarmasi="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-farmasi.svg";
                          iconrenovasi="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-renovasi.svg";
                          iconmusola="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-musola.svg";
                          icongudang="' . Yii::app()->request->baseUrl . '/images/denah/marker/icon-gudang.svg";    
                          var imgsrcs = [iconkosong, iconlakilaki,iconperempuan,iconfarmasi,iconrenovasi,iconmusola,icongudang];
                          var farmasi = [];
                          var i=0;
                          var j=0;
                          //digunakan untuk validasi ruangan berdasarkan no kamar dan jenis kelamin
                          for(i=0;i<hotspots.length;i++){
                            var h=hotspots[i];
                            for(j=0;j<pasien_kamar.length;j++){
                                    
                                    
                                if(h.id==pasien_kamar[j].no_kamar && h.ruangan_id==pasien_kamar[j].ruangan_id && h.kamarruangan_nokamar==pasien_kamar[j].kamar){
                                
                                  if(pasien_kamar[j].keterangan_kamar.toLowerCase()!="renovasi"){  
                                        if(pasien_kamar[j].jekel.toLowerCase()=="laki-laki"){//jika jenis kelamin pasien laki-laki                		  	
                                            hotspots[i].uri=iconlakilaki;
                                            hotspots[i].tip=hotspots[i].tip+pasien_kamar[j].no_kamar;
                                            hotspots[i].jekel=pasien_kamar[j].jekel;
                                        }else if (pasien_kamar[j].jekel.toLowerCase()=="perempuan"){//jika jenis kelamin pasien perempuan
                                            hotspots[i].tip=hotspots[i].tip+pasien_kamar[j].no_kamar;
                                            hotspots[i].uri=iconperempuan;
                                            hotspots[i].jekel=pasien_kamar[j].jekel;
                                        }else{//jika kamar kosong
                                            hotspots[i].tip=hotspots[i].tip+pasien_kamar[j].no_kamar;
                                            hotspots[i].uri=iconkosong;
                                            hotspots[i].jekel=pasien_kamar[j].jekel;
                                        }
                                    }else{
                                            hotspots[i].uri=iconrenovasi;
                                            hotspots[i].tip=hotspots[i].tip+pasien_kamar[j].no_kamar;
                                            hotspots[i].jekel=pasien_kamar[j].jekel;
                                    }
                                 }
                            }
                            if(h.kamarruangan_nokamar=="farmasi"){
                                        
                                        hotspots[i].uri=iconfarmasi;
                                        hotspots[i].tip="Ruang Obat";
                                        hotspots[i].jekel="";
                                    
                            }else if(h.kamarruangan_nokamar=="gudang"){
                                    hotspots[i].uri=icongudang;
                                    hotspots[i].tip="Gudang";
                                    hotspots[i].jekel="";
                            }else if(h.kamarruangan_nokamar=="musola"){
                                    hotspots[i].uri=iconmusola;
                                    hotspots[i].tip="Mushola";
                                    hotspots[i].jekel="";
                            }
                            
                        }
                        console.log(hotspots); 
                        //digunakan untuk render marker pada canvas 
                        hotspots.forEach(depict);
                        }
                        //fungsi tooltip
                        function handleMouseMove(e){

                          e.preventDefault();
                          e.stopPropagation();

                          mouseX=parseInt(e.clientX-offsetX);
                          mouseY=parseInt(e.clientY-offsetY);
                          
                          ctx.clearRect(0,0,cw,ch);
                          draw();
                          for(var i=0;i<hotspots.length;i++){
                            
                            var h=hotspots[i];
                            var dx=mouseX-h.x;
                            var dy=mouseY-h.y;
                            if(dx*dx+dy*dy<h.radius*h.radius){
                              ctx.fillText(h.tip,h.x,h.y);
                            }
                          }

                        }
                        });
                       
                    </script>';

    return $result;
  }
}
