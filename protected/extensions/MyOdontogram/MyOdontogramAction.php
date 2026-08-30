<?php
Yii::import('application.components.Params');
class MyOdontogramAction extends CAction
{
    protected $canvasWidth = 32;
    protected $canvasHeight = 96;//32
    protected $atas = array();
    protected $kanan = array();
    protected $bawah = array();
    protected $kiri = array();
    protected $atasV = array();
    protected $kananV = array();
    protected $bawahV = array();
    protected $kiriV = array();
    protected $lebar = 9;
    protected $tebal = 9;
	protected $tinggiCus = 32;
    
    public $code = 'wwwww';
    public $a;

    public function __construct()
    {
        $height = $this->canvasHeight;
        $width = $this->canvasWidth;
        $xCenter = $this->canvasWidth/2;
        //$yCenter = $this->canvasHeight/2;
		$yCenter = $this->canvasHeight-$this->tinggiCus;
        
        $this->atas = array(
                0,  0+$this->tinggiCus,  // Point 1 (x, y)
                $xCenter,  $yCenter-17, // Point 2 (x, y)
                $width,  0+$this->tinggiCus,  // Point 3 (x, y)
            );
        $this->kanan = array(
                $width,  0+$this->tinggiCus,  // Point 1 (x, y)
                $xCenter,  $yCenter-17, // Point 2 (x, y)
                $width,  $height-$this->tinggiCus,  // Point 3 (x, y)
            );
        $this->bawah = array(
                $width,  $height-$this->tinggiCus,  // Point 1 (x, y)
                $xCenter,  $yCenter-17, // Point 2 (x, y)
                0,  $height-$this->tinggiCus,  // Point 3 (x, y)
            );
        $this->kiri = array(
                0,  $height-$this->tinggiCus,  // Point 1 (x, y)
                $xCenter,  $yCenter-17, // Point 2 (x, y)
                0,  0+$this->tinggiCus,  // Point 3 (x, y)
            );
        
        
             
        $this->atasV = array(
                0,  0+$this->tinggiCus,  // Point 1 (x, y)
                10,  14+$this->tinggiCus, // Point 2 (x, y)
                22,  14+$this->tinggiCus,  // Point 3 (x, y)
                31,  0+$this->tinggiCus,  // Point 4 (x, y)
            );
        $this->kiriV = array(
                0,  0+$this->tinggiCus,  // Point 1 (x, y)
                10,  14+$this->tinggiCus, // Point 2 (x, y)
                10,  14+$this->tinggiCus,  // Point 3 (x, y)
                0,  32+$this->tinggiCus,  // Point 4 (x, y)                
            );        
        $this->bawahV = array(
                0,  32+$this->tinggiCus,  // Point 1 (x, y)
                10,  14+$this->tinggiCus, // Point 2 (x, y)
                22,  14+$this->tinggiCus,  // Point 3 (x, y)
                31,  32+$this->tinggiCus,  // Point 4 (x, y)
            );
        $this->kananV = array(
                31,  32+$this->tinggiCus,  // Point 1 (x, y)
                22,  14+$this->tinggiCus, // Point 2 (x, y)
                22,  14+$this->tinggiCus,  // Point 3 (x, y)
                31,  0+$this->tinggiCus,  // Point 4 (x, y)
            );
        
    }

    protected function drawBorder($im, $color, $widthCanvas, $heightCanvas,$i)
    {
        imageline($im, 0, 0, $widthCanvas, 0, $color); //border atas
        imageline($im, $widthCanvas-1, 0, $widthCanvas-1, $heightCanvas, $color); //border kanan
        imageline($im, 0, $heightCanvas-1, $widthCanvas, $heightCanvas-1, $color); //border bawah
        imageline($im, 0, $heightCanvas, 0, 0, $color); //border kiri
    }
	
	/**
	 * - digunakan untuk memberikan border pada gambar rectangle
	 * @param type $im
	 * @param type $color
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 * @param type $i
	 * @param type $min
	 */
	protected function drawBorderCustom($im, $color, $widthCanvas, $heightCanvas,$i,$min)
    {
        imageline($im, 0, 0+$min, $widthCanvas, 0+$min, $color); //border atas
        imageline($im, $widthCanvas-1, 0+$min, $widthCanvas-1, $heightCanvas, $color); //border kanan
        imageline($im, 0, $heightCanvas, $widthCanvas, $heightCanvas, $color); //border bawah
        imageline($im, 0, $heightCanvas, 0, 0+$min, $color); //border kiri
    }
    
    protected function drawKotakTengah($im,$tebal,$lebar,$widthCanvas,$heightCanvas,$color,$borderColor)
    {
        //bikin kotak di tengah
        imagefilledrectangle($im, $tebal, $lebar, $widthCanvas-$tebal, $heightCanvas-$lebar, $color);
        // bikin border kotak yg di tengah
        imagerectangle($im, $tebal, $lebar, $widthCanvas-$tebal, $heightCanvas-$lebar, $borderColor);
            
    }
	
	/**
	 * - digunakan untuk menyesuaikan gambar kota tengah dengan resolusi 32 x 32 pixels
	 * @param type $im
	 * @param type $tebal
	 * @param type $lebar
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 * @param type $color
	 * @param type $borderColor
	 */
	protected function drawKotakTengahV2($im,$tebal,$lebar,$widthCanvas,$heightCanvas,$color,$borderColor)
    {
		if (is_array($color)){
			if ($color[0] == 'arsiran'){				
				$clr = imagecolorallocate($im, 255, 255, 255);
				$clrLine = imagecolorallocate($im, 0, 0, 0);
				$ketebalan = 0;
				//bikin kotak di tengah
				imagefilledrectangle($im, $tebal, $lebar+$this->tinggiCus, $widthCanvas-$tebal, $heightCanvas-$lebar, $clr);
				// bikin border kotak yg di tengah
				imagerectangle($im, $tebal, $lebar+$this->tinggiCus, $widthCanvas-$tebal, $heightCanvas-$lebar, $borderColor);


				if ($ketebalan != 0){
					for($i=1;$i<=$ketebalan;$i++){
						//weight border
						imagefilledrectangle($im, $tebal+$i, $lebar+$this->tinggiCus+$i, $widthCanvas-$tebal-$i, $heightCanvas-$lebar-$i, $clr);
						// bikin border kotak yg di tengah
						imagerectangle($im, $tebal+$i, $lebar+$this->tinggiCus+$i, $widthCanvas-$tebal-$i, $heightCanvas-$lebar-$i, $borderColor);
					}
				}
									
				
				imageline($im, 11, 42, 11, 54, $clrLine);
				imageline($im, 14, 42, 14, 54, $clrLine);
				imageline($im, 17, 42, 17, 54, $clrLine);
				imageline($im, 20, 42, 20, 54, $clrLine);
				
			
				
			}else{
				$clr = imagecolorallocate($im, $color[0], $color[1], $color[2]);
				$ketebalan = isset($color[3])?$color[3]:0;
				
				//bikin kotak di tengah
				imagefilledrectangle($im, $tebal, $lebar+$this->tinggiCus, $widthCanvas-$tebal, $heightCanvas-$lebar, $clr);
				// bikin border kotak yg di tengah
				imagerectangle($im, $tebal, $lebar+$this->tinggiCus, $widthCanvas-$tebal, $heightCanvas-$lebar, $borderColor);


				if ($ketebalan != 0){
					for($i=1;$i<=$ketebalan;$i++){
						//weight border
						imagefilledrectangle($im, $tebal+$i, $lebar+$this->tinggiCus+$i, $widthCanvas-$tebal-$i, $heightCanvas-$lebar-$i, $clr);
						// bikin border kotak yg di tengah
						imagerectangle($im, $tebal+$i, $lebar+$this->tinggiCus+$i, $widthCanvas-$tebal-$i, $heightCanvas-$lebar-$i, $borderColor);
					}
				}
			}
			
		}else{
			$clr = $color;
			$ketebalan = 0;

				//bikin kotak di tengah
			imagefilledrectangle($im, $tebal, $lebar+$this->tinggiCus, $widthCanvas-$tebal, $heightCanvas-$lebar, $clr);
			// bikin border kotak yg di tengah
			imagerectangle($im, $tebal, $lebar+$this->tinggiCus, $widthCanvas-$tebal, $heightCanvas-$lebar, $borderColor);


			if ($ketebalan != 0){
				for($i=1;$i<=$ketebalan;$i++){
					//weight border
					imagefilledrectangle($im, $tebal+$i, $lebar+$this->tinggiCus+$i, $widthCanvas-$tebal-$i, $heightCanvas-$lebar-$i, $clr);
					// bikin border kotak yg di tengah
					imagerectangle($im, $tebal+$i, $lebar+$this->tinggiCus+$i, $widthCanvas-$tebal-$i, $heightCanvas-$lebar-$i, $borderColor);
				}
			}
		}
        
            
    }
    
    protected function drawSegitiga($im, $points, $numPoints, $color,$posisi='')
    {
		if (is_array($color)){
			if ($color[0] == 'arsiran'){				
				$clr = imagecolorallocate($im, 255, 255, 255);
				$clrLine = imagecolorallocate($im, 0, 0, 0);
				
				imagefilledpolygon($im, $points, $numPoints, $clr);
				
				if ($posisi == 'atas'){				
					imageline($im, 2, 32, 2, 40, $clrLine);
					imageline($im, 5, 32, 5, 40, $clrLine);
					imageline($im, 8, 32, 8, 46, $clrLine);
					imageline($im, 11, 32, 11, 46, $clrLine);
					imageline($im, 14, 32, 14, 46, $clrLine);
					imageline($im, 17, 32, 17, 46, $clrLine);
					imageline($im, 20, 32, 20, 46, $clrLine);
					imageline($im, 23, 32, 23, 46, $clrLine);
					imageline($im, 26, 32, 26, 46, $clrLine);
					imageline($im, 29, 32, 29, 46, $clrLine);
				}elseif ($posisi == 'kiri'){
					imageline($im, 2, 35, 2, 60, $clrLine);
					imageline($im, 5, 37, 5, 58, $clrLine);
					imageline($im, 8, 39, 8, 54, $clrLine);					
				}elseif  ($posisi == 'bawah'){
					imageline($im, 2, 50, 2, 64, $clrLine);
					imageline($im, 5, 50, 5, 64, $clrLine);
					imageline($im, 8, 50, 8, 64, $clrLine);
					imageline($im, 11, 50, 11, 64, $clrLine);
					imageline($im, 14, 50, 14, 64, $clrLine);
					imageline($im, 17, 52, 17, 64, $clrLine);
					imageline($im, 20, 54, 20, 64, $clrLine);
					imageline($im, 23, 56, 23, 64, $clrLine);
					imageline($im, 26, 58, 26, 64, $clrLine);
					imageline($im, 29, 60, 29, 64, $clrLine);
				}elseif  ($posisi == 'kanan'){
					imageline($im, 20, 41, 20, 50, $clrLine);
					imageline($im, 23, 39, 23, 54, $clrLine);
					imageline($im, 26, 37, 26, 58, $clrLine);
					imageline($im, 29, 35, 29, 60, $clrLine);
				}
				
			}else{
				$clr = imagecolorallocate($im, $color[0], $color[1], $color[2]);
				imagefilledpolygon($im, $points, $numPoints, $clr);
			}
		}else{
			$clr = $color;
			imagefilledpolygon($im, $points, $numPoints, $clr);
		}
		
        
		
		
		
    }
    
    /**
     * - digunakna untuk menandai gambar gigi baru bagian tengah
     * @param type $im
     * @param type $points
     * @param type $numPoints
     * @param type $color
     */
    protected function drawSegitigaV($im, $points, $numPoints, $color,$posisi='')
    {   	
		
		if (is_array($color)){
			if ($color[0] == 'arsiran'){
				$clr = imagecolorallocate($im, 255, 255, 255);
				$clrLine = imagecolorallocate($im, 0, 0, 0);
				
				imagefilledpolygon($im, $points, $numPoints, $clr);
				
				if ($posisi == 'atas'){				
					imageline($im, 2, 32, 2, 40, $clrLine);
					imageline($im, 5, 32, 5, 40, $clrLine);
					imageline($im, 8, 32, 8, 46, $clrLine);
					imageline($im, 11, 32, 11, 46, $clrLine);
					imageline($im, 14, 32, 14, 46, $clrLine);
					imageline($im, 17, 32, 17, 46, $clrLine);
					imageline($im, 20, 32, 20, 46, $clrLine);
					imageline($im, 23, 32, 23, 46, $clrLine);
					imageline($im, 26, 32, 26, 46, $clrLine);
					imageline($im, 29, 32, 29, 46, $clrLine);
				}elseif ($posisi == 'kiri'){
					imageline($im, 2, 35, 2, 60, $clrLine);
					imageline($im, 5, 37, 5, 56, $clrLine);
					imageline($im, 8, 42, 8, 50, $clrLine);					
				}elseif  ($posisi == 'bawah'){
					imageline($im, 2, 50, 2, 64, $clrLine);
					imageline($im, 5, 50, 5, 64, $clrLine);
					imageline($im, 8, 50, 8, 64, $clrLine);
					imageline($im, 11, 46, 11, 64, $clrLine);
					imageline($im, 14, 46, 14, 64, $clrLine);
					imageline($im, 17, 46, 17, 64, $clrLine);
					imageline($im, 20, 46, 20, 64, $clrLine);
					imageline($im, 23, 50, 23, 64, $clrLine);
					imageline($im, 26, 50, 26, 64, $clrLine);
					imageline($im, 29, 50, 29, 64, $clrLine);
				}elseif  ($posisi == 'kanan'){										
					imageline($im, 26, 39, 26, 56, $clrLine);
					imageline($im, 29, 35, 29, 60, $clrLine);
				}								
			}else{
				$clr = imagecolorallocate($im, $color[0], $color[1], $color[2]);
				 imagefilledpolygon($im, $points, $numPoints, $clr);
			}
		}else{
			$clr = $color;
			 imagefilledpolygon($im, $points, $numPoints, $clr);
		}
		
       
        
    }
    
    protected function drawBorderSilang($im, $x1, $y1, $x2, $y2, $widthCanvas, $heightCanvas, $color)
    {
            // bikin border silang
            imageline($im, 0, 0, $x2, $y2, $color);
            imageline($im, $widthCanvas-1, $y1, $x2-1, $y2, $color);
            imageline($im, $x1, $heightCanvas-1, $x2, $y2-1, $color);
            imageline($im, $widthCanvas, $heightCanvas, $x2, $y2, $color);
    }
	
	/**
	 * - digunakan untuk mengambar border dengan maksimum tinggi 32px dan lbar 32px
	 * @param type $im
	 * @param type $x1
	 * @param type $y1
	 * @param type $x2
	 * @param type $y2
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 * @param type $color
	 */
	protected function drawBorderSilangV2($im, $x1, $y1, $x2, $y2, $widthCanvas, $heightCanvas, $color)
    {
            // bikin border silang
            imageline($im, 0, 0+$this->tinggiCus, $x2, $y2, $color); //diagonal kiri atas
            imageline($im, $widthCanvas-1, $y1+$this->tinggiCus, $x2-1, $y2, $color); // diagonal kanan atas
            imageline($im, $x1, $heightCanvas-1, $x2, $y2-1, $color); // diagonal bawah kanan
            imageline($im, $widthCanvas, $heightCanvas, $x2, $y2, $color); //diagonal bawah kiri
    }
    
    /**
     * - digunakan untuk menggambar image baru gigi bagian tengah
     * @param type $im
     * @param type $x1
     * @param type $y1
     * @param type $x2
     * @param type $y2
     * @param type $widthCanvas
     * @param type $heightCanvas
     * @param type $color
     */
    protected function drawBorderSegitiga($im, $x1, $y1, $x2, $y2, $widthCanvas, $heightCanvas, $color)
    {            
            //imageline($im, 0, 0, 10, 15, $color);
            //imageline($im, 20, 15, 10, 15, $color);
            //imageline($im, 20, 15, 30, 0, $color);
            
            //imageline($im, 0, 0, 10, 15, $color);
            //imageline($im, 20, 15, 10, 15, $color);
            //imageline($im, 20, 15, 30, 0, $color);
       
        
        $titik[0]=0;
        $titik[1]=0+$this->tinggiCus;
        $titik[2]=10;
        $titik[3]=14+$this->tinggiCus;
        $titik[4]=22;
        $titik[5]=14+$this->tinggiCus;        
        $titik[6]=31;
        $titik[7]=0+$this->tinggiCus;                
        ImagePolygon($im,$titik,4,$color);
        
        $titik[0]=0;
        $titik[1]=32+$this->tinggiCus;
        $titik[2]=10;
        $titik[3]=14+$this->tinggiCus;
        $titik[4]=22;
        $titik[5]=14+$this->tinggiCus;        
        $titik[6]=31;
        $titik[7]=32+$this->tinggiCus;                
        ImagePolygon($im,$titik,4,$color);
    }
    
    protected function drawGigiHilang($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,0xff,0x00,0x00);
            $gray    = ImageColorAllocate($img,193,193,193);
            $black   = ImageColorAllocate($img,0x00,0x00,0x00);
            // bikin kanvas (kotak besar)
            imagefilledrectangle($img, 0, 0, $widthCanvas, $heightCanvas, $gray);
            $this->drawKotakTengah($img, $this->tebal, $this->lebar, $widthCanvas, $heightCanvas, $gray, $black);
            $this->drawBorder($img, $black, $widthCanvas, $heightCanvas,$i);
            
            // bikin border silang
            imageline($img, 0, 0, $widthCanvas, $heightCanvas, $color);
            imageline($img, $widthCanvas, 0, 0, $heightCanvas, $color);
            
            imageline($img, 1, 0, $widthCanvas, $heightCanvas-1, $color);
            imageline($img, $widthCanvas-1, 0, 0, $heightCanvas-1, $color);
            
            imageline($img, 0, 1, $widthCanvas-1, $heightCanvas, $color);
            imageline($img, $widthCanvas-2, 0, 0, $heightCanvas-2, $color);
    }
	
	/**
	 * - digunakan untuk menggambar partial denture
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawPartialDenture($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,3,3,3);
            // bikin border silang
            imageline($img, 6, 20, $widthCanvas-8, $heightCanvas-20, $color);
            imageline($img, $widthCanvas-6, 20, 8, $heightCanvas-20, $color);
            
            imageline($img, 7, 21, $widthCanvas-7, $heightCanvas-21, $color);
            imageline($img, $widthCanvas-7, 21, 7, $heightCanvas-21, $color);
            
            imageline($img, 8, 22, $widthCanvas-6, $heightCanvas-22, $color);
            imageline($img, $widthCanvas-8, 22, 6, $heightCanvas-22, $color);
			
			$this->drawPRD($img,7 ,$heightCanvas-($this->tinggiCus*2));
    }
	
	/**
	 * - digunakan untuk menggambar full denture
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawFullDenture($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,3,3,3);
            // bikin border silang
            imageline($img, 6, 20, $widthCanvas-8, $heightCanvas-20, $color);
            imageline($img, $widthCanvas-6, 20, 8, $heightCanvas-20, $color);
            
            imageline($img, 7, 21, $widthCanvas-7, $heightCanvas-21, $color);
            imageline($img, $widthCanvas-7, 21, 7, $heightCanvas-21, $color);
            
            imageline($img, 8, 22, $widthCanvas-6, $heightCanvas-22, $color);
            imageline($img, $widthCanvas-8, 22, 6, $heightCanvas-22, $color);
			
			$this->drawFLD($img,7 ,$heightCanvas-($this->tinggiCus*2));
    }
	
	/**
	 * - 
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawGigiHilangV2($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,3,3,3);
                      
            // bikin border silang
            imageline($img, 6, 20, $widthCanvas-8, $heightCanvas-20, $color);
            imageline($img, $widthCanvas-6, 20, 8, $heightCanvas-20, $color);
            
            imageline($img, 7, 21, $widthCanvas-7, $heightCanvas-21, $color);
            imageline($img, $widthCanvas-7, 21, 7, $heightCanvas-21, $color);
            
            imageline($img, 8, 22, $widthCanvas-6, $heightCanvas-22, $color);
            imageline($img, $widthCanvas-8, 22, 6, $heightCanvas-22, $color);
    }
    
    protected function drawGigiTiruanLepas($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,255,255,0);
            imageline($img, 5, $heightCanvas-10, $widthCanvas-5, $heightCanvas-10, $color);
            imageline($img, 5, $heightCanvas-9, $widthCanvas-5, $heightCanvas-9, $color);
            imageline($img, 5, $heightCanvas-8, $widthCanvas-5, $heightCanvas-8, $color);
    }
    
    protected function drawNonVital($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,0xff,0x00,0x00);
            imageline($img, $widthCanvas, 0, $widthCanvas-10, 0, $color);
            imageline($img, $widthCanvas-10, 0, 10, $heightCanvas, $color);
            imageline($img, 0, $heightCanvas, 10, $heightCanvas, $color);
            
            imageline($img, $widthCanvas, 1, $widthCanvas-10, 1, $color);
            imageline($img, $widthCanvas-10, 1, 11, $heightCanvas, $color);
            imageline($img, 0, $heightCanvas-1, 10, $heightCanvas-1, $color);
            imageline($img, 0, $heightCanvas-2, 10, $heightCanvas-2, $color);
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawNonVitalV2($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,3,3,3);                 
			
			$titik[0]=8;
			$titik[1]=0+($this->tinggiCus*2);
			$titik[2]=16;
			$titik[3]=20+($this->tinggiCus*2);
			$titik[4]=24;
			$titik[5]=0+($this->tinggiCus*2);        
			
			ImagePolygon($img,$titik,3,$color);         
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawPerawatanAkar($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,3,3,3);                 
			
			$titik[0]=8;
			$titik[1]=0+($this->tinggiCus*2);
			$titik[2]=16;
			$titik[3]=20+($this->tinggiCus*2);
			$titik[4]=24;
			$titik[5]=0+($this->tinggiCus*2);        
			
			//ImagePolygon($img,$titik,3,$color);         
			imagefilledpolygon($img, $titik, 3, $color);
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawAmalgamNonVital($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,3,3,3);                 
			
			$titik[0]=8;
			$titik[1]=0+($this->tinggiCus*2);
			$titik[2]=16;
			$titik[3]=20+($this->tinggiCus*2);
			$titik[4]=24;
			$titik[5]=0+($this->tinggiCus*2);        
			
			//ImagePolygon($img,$titik,3,$color);         
			imagefilledpolygon($img, $titik, 3, $color);
			
			
			//
			$this->drawKotakTengahV2($img, $this->tebal, $this->lebar, $this->canvasWidth, $this->canvasHeight-$this->tinggiCus, $color, $color);
			
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawFullMetalVital($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		$black   = ImageColorAllocate($img,0x00,0x00,0x00);
		for ($i=1;$i<=3;$i++){
			imageline($img, 0, 0+$min+$i, $widthCanvas, 0+$min+$i, $black); //border atas			
			imageline($img, 0, $heightCanvas-$min-$i, $widthCanvas, $heightCanvas-$min-$i, $black); //border bawah
			
		}
		
		for ($i=1;$i<=2;$i++){
			imageline($img, $widthCanvas-1-$i, 0+$min+2, $widthCanvas-1-$i, $heightCanvas-$min-2, $black); //border kanan
			imageline($img, 0+$i, $heightCanvas-$min-2, 0+$i, 0+$min+2, $black); //border kiri
		}										
        
			
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawFullMetalNonVital($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		$black   = ImageColorAllocate($img,0x00,0x00,0x00);
		for ($i=1;$i<=3;$i++){
			imageline($img, 0, 0+$min+$i, $widthCanvas, 0+$min+$i, $black); //border atas			
			imageline($img, 0, $heightCanvas-$min-$i, $widthCanvas, $heightCanvas-$min-$i, $black); //border bawah
			
		}
		
		for ($i=1;$i<=2;$i++){
			imageline($img, $widthCanvas-1-$i, 0+$min+2, $widthCanvas-1-$i, $heightCanvas-$min-2, $black); //border kanan
			imageline($img, 0+$i, $heightCanvas-$min-2, 0+$i, 0+$min+2, $black); //border kiri
		}			              
			
		$titik[0]=8;
		$titik[1]=0+($this->tinggiCus*2);
		$titik[2]=16;
		$titik[3]=20+($this->tinggiCus*2);
		$titik[4]=24;
		$titik[5]=0+($this->tinggiCus*2);        

		//ImagePolygon($img,$titik,3,$color);         
		imagefilledpolygon($img, $titik, 3, $black);
		
		
		/*
			$blue   = imagecolorallocatealpha($img, 3, 3, 3, 95);
		//bikin kotak di tengah
			imagefilledrectangle($img, 0, 32, 32, 64, $blue);
		 * 
		 */
		
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawPorcelainCrownVital($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("K");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 4, 32, 0, 0, 32, 32);
		
		$abu   = imagecolorallocatealpha($img,3,3,3,95);
				
		imagefilledrectangle($img, 0, 32, 32, 64, $abu);
		
		$black   = ImageColorAllocate($img,0x00,0x00,0x00);
		for ($i=1;$i<=3;$i++){
			imageline($img, 0, 0+$min+$i, $widthCanvas, 0+$min+$i, $black); //border atas			
			imageline($img, 0, $heightCanvas-$min-$i, $widthCanvas, $heightCanvas-$min-$i, $black); //border bawah
			
		}
		
		for ($i=1;$i<=2;$i++){
			imageline($img, $widthCanvas-1-$i, 0+$min+2, $widthCanvas-1-$i, $heightCanvas-$min-2, $black); //border kanan
			imageline($img, 0+$i, $heightCanvas-$min-2, 0+$i, 0+$min+2, $black); //border kiri
		}
		
	
		
		//$blue   = imagecolorallocatealpha($img, 3, 3, 3, 95);
		//bikin kotak di tengah
       // imagefilledrectangle($img, 0, 32, 32, 32, $blue);
			
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawImplantPorcelain($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("K");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 4, 32, 0, 0, 32, 32);
		
		$abu   = imagecolorallocatealpha($img,3,3,3,95);
				
		imagefilledrectangle($img, 0, 32, 32, 64, $abu);
		
		$black   = ImageColorAllocate($img,0x00,0x00,0x00);
		for ($i=1;$i<=3;$i++){
			imageline($img, 0, 0+$min+$i, $widthCanvas, 0+$min+$i, $black); //border atas			
			imageline($img, 0, $heightCanvas-$min-$i, $widthCanvas, $heightCanvas-$min-$i, $black); //border bawah
			
		}
		
		for ($i=1;$i<=2;$i++){
			imageline($img, $widthCanvas-1-$i, 0+$min+2, $widthCanvas-1-$i, $heightCanvas-$min-2, $black); //border kanan
			imageline($img, 0+$i, $heightCanvas-$min-2, 0+$i, 0+$min+2, $black); //border kiri
		}
		
	
		$this->drawImplant($img,7 ,$heightCanvas-($this->tinggiCus*2));
    }
	
	/**
	 * - digunakan untuk menyessuaikan gambar pada 32 x 32 px
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawPorcelainCrownNonVital($img, $widthCanvas, $heightCanvas)
    {         
		$file = $this->gambarFromCode("K");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 4, 32, 0, 0, 32, 32);
		
		$min=30;
		$black   = ImageColorAllocate($img,0x00,0x00,0x00);
		for ($i=1;$i<=3;$i++){
			imageline($img, 0, 0+$min+$i, $widthCanvas, 0+$min+$i, $black); //border atas			
			imageline($img, 0, $heightCanvas-$min-$i, $widthCanvas, $heightCanvas-$min-$i, $black); //border bawah
			
		}
		
		for ($i=1;$i<=2;$i++){
			imageline($img, $widthCanvas-1-$i, 0+$min+2, $widthCanvas-1-$i, $heightCanvas-$min-2, $black); //border kanan
			imageline($img, 0+$i, $heightCanvas-$min-2, 0+$i, 0+$min+2, $black); //border kiri
		}			              
			
		$titik[0]=8;
		$titik[1]=0+($this->tinggiCus*2);
		$titik[2]=16;
		$titik[3]=20+($this->tinggiCus*2);
		$titik[4]=24;
		$titik[5]=0+($this->tinggiCus*2);        

		//ImagePolygon($img,$titik,3,$color);         
		imagefilledpolygon($img, $titik, 3, $black);
		
		$blue   = imagecolorallocatealpha($img, 3, 3, 3, 95);
		//bikin kotak di tengah
        imagefilledrectangle($img, 0, 32, 32, 64, $blue);
			
    }
    
    protected function drawJembatan($img, $widthCanvas, $heightCanvas)
    {
            $color = Imagecolorallocate($img, 48, 128, 20);
            imageline($img, 5, 11, $widthCanvas-5, 11, $color);
            imageline($img, 5, 10, $widthCanvas-5, 10, $color);
            imageline($img, 5, 9, $widthCanvas-5, 9, $color);
    }
    
    protected function drawSisaAkar($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,0x00,0x00,0xff);
            imageline($img, 0, $heightCanvas/2, $widthCanvas/2, $heightCanvas, $color);
            imageline($img, $widthCanvas/2, $heightCanvas, $widthCanvas, 0, $color);
            
            imageline($img, 0, ($heightCanvas/2)-1, ($widthCanvas/2)+1, $heightCanvas, $color);
            imageline($img, ($widthCanvas/2)+1, $heightCanvas, $widthCanvas+1, 0, $color);
            
            imageline($img, 0, ($heightCanvas/2)+1, ($widthCanvas/2)-1, $heightCanvas, $color);
            imageline($img, ($widthCanvas/2)-1, $heightCanvas, $widthCanvas-1, 0, $color);
    }
	
	protected function drawSisaAkarV2($img, $widthCanvas, $heightCanvas)
    {		
		$color = ImageColorAllocate($img,3,3,3);
		imageline($img, 0, ($heightCanvas/2)-30, $widthCanvas/2, $heightCanvas-20, $color);
		imageline($img, $widthCanvas/2, $heightCanvas-20, $widthCanvas, 0, $color);

		imageline($img, 0, ($heightCanvas/2)-31, ($widthCanvas/2)+1, $heightCanvas-20, $color);
		imageline($img, ($widthCanvas/2)+1, $heightCanvas-20, $widthCanvas+1, 0, $color);

		imageline($img, 0, ($heightCanvas/2)-29, ($widthCanvas/2)-1, $heightCanvas-20, $color);
		imageline($img, ($widthCanvas/2)-1, $heightCanvas-20, $widthCanvas-1, 0, $color);
		
    }
	
	/**
	 * - digunakan untuk meload file migrasikiri.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawMigrasiKiri($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("Q");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 7, 21, 0, 0, 20, 6);				
    }
	
	/**
	 * - digunakan untuk meload file migrasikanan.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawMigrasiKanan($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("W");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 7, 21, 0, 0, 20, 6);								
    }
	
	/**
	 * - digunakan untuk meload file migrasikiri.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawRotasiKiri($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("U");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 7, 70, 0, 0, 20, 20);				
    }
	
	/**
	 * - digunakan untuk meload file migrasikanan.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawRotasiKanan($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("C");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 7, 5, 0, 0, 20, 20);								
    }
	
	/**
	 * - digunakan untuk meload file bridgetengah.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawBridgeTengah($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("J");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 0, 12, 0, 0, 32, 20);				
    }
	
	/**
	 * - digunakan untuk meload file bridgetengah.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawBridgeKiri($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("D");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 10, 12, 0, 0, 22, 20);				
    }
	
	/**
	 * - digunakan untuk meload file bridgetengah.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawBridgeKanan($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode("I");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 0, 12, 0, 0, 22, 20);				
    }
	
	/**
	 * - digunakan untuk meload file migrasikiri.png
	 * @param type $img
	 * @param type $widthCanvas
	 * @param type $heightCanvas
	 */
	protected function drawArsiran($img, $widthCanvas, $heightCanvas)
    {         
		$min=30;
		
		$file = $this->gambarFromCode(">");
		$src = imagecreatefrompng($file);
		imagecopy( $img, $src, 7, 70, 0, 0, 20, 20);				
    }
    
    protected function drawBelumErupsi($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 0, 104, 139);
			//$color = Imagecolorallocate($img, 3, 3, 3);
            $fontSize = 12;
            $angle = 0;
            //imagettftext($img, $fontSize, $angle, $x, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'UNE');
			imagettftext($img, $fontSize, $angle, 1, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'UNE');
    }
    
    /**
     * - digunakan untuk menampilkan gambar tidak ada gigi
     * @param type $img
     * @param type $x
     * @param type $y
     */
    protected function drawNON($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 3, 3, 3);
            $fontSize = 11;
            $angle = 0;
            imagettftext($img, $fontSize, $angle, 1, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'NON');
    }
    
    /**
     * - digunakan untuk menampilkan gambar fracture
     * @param type $img
     * @param type $x
     * @param type $y
     */
    protected function drawFracture($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 3, 3, 3);
            $fontSize = 25;
            $angle = 0;
			imagettftext($img, $fontSize, $angle, 5, $y-25, $color, dirname(__FILE__) . '/NOTTB___.TTF', '#');            
    }
	
	 /**
     * - digunakan untuk menampilkan gambar imlant IPX
     * @param type $img
     * @param type $x
     * @param type $y
     */
    protected function drawImplant($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 3, 3, 3);
            $fontSize = 12;
            $angle = 0;
			imagettftext($img, $fontSize, $angle, 5, $y+45, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'IPX');            
    }
	
	/**
     * - digunakan untuk menampilkan gambar tulisan PRD
     * @param type $img
     * @param type $x
     * @param type $y
     */
    protected function drawPRD($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 3, 3, 3);
            $fontSize = 12;
            $angle = 0;
			imagettftext($img, $fontSize, $angle, 5, $y+59, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'FRD');            
    }
	
	/**
     * - digunakan untuk menampilkan gambar tulisan FLD
     * @param type $img
     * @param type $x
     * @param type $y
     */
    protected function drawFLD($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 3, 3, 3);
            $fontSize = 12;
            $angle = 0;
			imagettftext($img, $fontSize, $angle, 5, $y+59, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'FLD');            
    }
    
    protected function drawErupsiSebagian($img,$x,$y)
    {
            $color = ImageColorAllocate($img,0x00,0x00,0xff);
            $fontSize = 12;
            $angle = 0;
            //imagettftext($img, $fontSize, $angle, $x, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'PE');
			imagettftext($img, $fontSize, $angle, 1, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'PRE');
    }
    
    protected function drawAnomaliBentuk($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 0, 205, 0);
            $fontSize = 12;
            $angle = 0;
            imagettftext($img, $fontSize, $angle, 1, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'ANO');
    }
    
    protected function drawFromCode($img, $widthCanvas, $heightCanvas, $code)
    {                        
            switch ($code) {
				case 'A': // sisa akar
                    $this->drawSisaAkarV2($img, $widthCanvas, $heightCanvas); 
                    break;
                case 'B': // anomali bentuk
                    $this->drawAnomaliBentuk($img, 7, $heightCanvas-($this->tinggiCus*2)); 
                    break;
				case 'C': // rotasi kanan
                    $this->drawRotasiKanan($img, $widthCanvas, $heightCanvas);
                    break;
				case 'D': // bridge kiri
                    $this->drawBridgeKiri($img, $widthCanvas, $heightCanvas);
                    break;
                case 'E': // belum erupsi
                    $this->drawBelumErupsi($img, 7, $heightCanvas-($this->tinggiCus*2));
                    break;
				case 'F': // fracture
                    $this->drawFracture($img, 7, ($heightCanvas-10));
                    break;
				case 'G': // Full metal crown pada gigi non vital
                    $this->drawFullMetalNonVital($img, $widthCanvas, $heightCanvas);
                    break;
                case 'H': // gigi hilang
                    $this->drawGigiHilangV2($img, $widthCanvas, $heightCanvas);
                    break;
				case 'I': // gigi hilang
                    $this->drawBridgeKanan($img, $widthCanvas, $heightCanvas);
                    break;
                case 'J': // jembatan
                    $this->drawBridgeTengah($img, $widthCanvas, $heightCanvas);
                    break;
				case 'L': // gigi tiruan lepas
                    $this->drawGigiTiruanLepas($img, $widthCanvas, $heightCanvas);
                    break;
				case 'M': // full metal crown pada gigi non vital
                     $this->drawFullMetalVital($img, $widthCanvas, $heightCanvas);
                    break;
                case 'N': // gigi tidak ada
                    $this->drawNON($img, 7, $heightCanvas-($this->tinggiCus*2));
                    break;
				case 'O': // porcelain crown pada gigi non vital
                     $this->drawPorcelainCrownNonVital($img, $widthCanvas, $heightCanvas);
                    break;
				case 'P': // porcelain crown pada gigi vital
                     $this->drawPorcelainCrownVital($img, $widthCanvas, $heightCanvas);
                    break;	
				case 'Q': // Migrasi
                    $this->drawMigrasiKiri($img, $widthCanvas, $heightCanvas);
                    break;
				case 'R': // perawatan saluran akar
                     $this->drawPerawatanAkar($img, $widthCanvas, $heightCanvas);
                    break;
                case 'S': // erupsi sebagian
                    $this->drawErupsiSebagian($img, 7, $heightCanvas-($this->tinggiCus*2));
                    break;
				case 'T': // perawatan saluran akar
                     $this->drawAmalgamNonVital($img, $widthCanvas, $heightCanvas);
                    break;
				case 'U': // rotasikiri
                     $this->drawRotasiKiri($img, $widthCanvas, $heightCanvas);
                    break;
                case 'V': // non vital
                    $this->drawNonVitalV2($img, $widthCanvas, $heightCanvas);
                    break;        
				case 'W': // Rotasi
                    $this->drawMigrasiKanan($img, $widthCanvas, $heightCanvas);
                    break;
				case 'X': // implant
                    $this->drawImplantPorcelain($img, $widthCanvas, $heightCanvas);
                    break;  
				case 'Y': // Partial Denture
                    $this->drawPartialDenture($img, $widthCanvas, $heightCanvas);
                    break;
				case 'Z': // Full Denture
                    $this->drawFullDenture($img, $widthCanvas, $heightCanvas);
                    break;
				//case '>': // arsiran
                  //  $this->drawArsiran($img, $widthCanvas, $heightCanvas);
                   // break;
				
				//case 'K': // gigi tiruan lepas
                  //  $this->drawKaries($img, $widthCanvas, $heightCanvas);
                  //  break;                               												
                default:
                    break;
            }
    }
    
    protected function warnaFromCode($code)
    {            
            switch ($code) {
                case 'w':$warna = 'white';
                    break;
                case 'r':$warna = 'maroon';         // Tambalan logam
                    break;
                case 'n':$warna = 'turquoise';      // Tambalan no logam
                    break;
                case 'g':$warna = 'green';          // Mahkota Logam
                    break;
                case 'b':$warna = 'lightblue';      // Mahkota non logam
                    break;
                case 'k':$warna = array(
									0 => 255,
					                1 => 255,
					                2 => 255,
									3 => 1,
						);           // Karies
                    break;
                case 'N':$warna = 'black';           // NON
                    break;
                case 'F':$warna = 'black';           // fracture
                    break;
                default:$warna = 'white';
                    break;
				case 'a':$warna = 'black';
                    break;
				case 'c':$warna = 'green';
                    break;
				case 'p':$warna = array(
									0 => 188,
					                1 => 132,
					                2 => 67
						);
					 break;
				case 's':$warna = array(
						0 => 'arsiran',
						1 => 'arsiran',
						2 => 'arsiran'
					
					);
					break;
            }

            return $warna;
    }
    
    protected function gambarFromCode($code)
    {            
            switch ($code) {
                case 'E': // belum erupsi
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/erupsi.png';
                    break;
                case 'S': // erupsi sebagian
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/erupsisebagian.png';
                    break;
                case 'B': // anomali bentuk
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/anomalibentuk.png'; 
                    break;
                case 'V': // non vital
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/nonvital.png';
                    break;
                case 'A': // sisa akar
                     $gambar = Yii::getPathOfAlias('webroot.css').'/sisa_akar.png';
                    break;
                case 'H': // gigi hilang
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/gigihilang.png';
                    break;
                case 'J': // jembatan
                    $gambar = Yii::getPathOfAlias('webroot.css').'/bridgetengah.png';
                    break;
                case 'L': // gigi tiruan lepas
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/gigilepas.png';
                    break;
				case 'D': // bridge kiri
                    $gambar = Yii::getPathOfAlias('webroot.css').'/bridgekiri.png';
                    break;
				case 'I': // bridge kanan
                    $gambar = Yii::getPathOfAlias('webroot.css').'/bridgekanan.png';
                    break;
				case 'Q': // migrasi
                    $gambar = Yii::getPathOfAlias('webroot.css').'/migrasikiri.png';
                    break;
				case 'W': // rotasi
                    $gambar = Yii::getPathOfAlias('webroot.css').'/migrasikanan.png';
                    break;
				case 'U': // rotasi
                    $gambar = Yii::getPathOfAlias('webroot.css').'/rotasikiri.png';
                    break;
				case 'K': // rotasi
                    $gambar = Yii::getPathOfAlias('webroot.css').'/arsiran32x32.png';
                    break;
				case 'C': // rotasi
                    $gambar = Yii::getPathOfAlias('webroot.css').'/rotasikanan.png';
                    break;
				case '>': // rotasi
                    $gambar = Yii::getPathOfAlias('webroot.css').'/rotasikanan.png';
                    break;
                default:$gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/smile.png';
                    break;
            }

            return $gambar;
    }

    public function run()
    {
            if(!empty($_GET['code']))
                $this->code = $_GET['code'];
                $this->a = $_GET['a'];
            
            $this->renderImage($this->code,$this->a);
            Yii::app()->end();
    }
    
    protected function renderImage($code,$a)
    {
            $image   = imagecreatetruecolor($this->canvasWidth, $this->canvasHeight);
            $black   = ImageColorAllocate($image,0x00,0x00,0x00);
            $white   = ImageColorAllocate($image,0xff,0xff,0xff);
            $red     = ImageColorAllocate($image,0xff,0x00,0x00);
            $green   = ImageColorAllocate($image,0x00,0xff,0x00);
            $blue    = ImageColorAllocate($image,0x00,0x00,0xff);
            
            $maroon  = ImageColorAllocate($image,255,52,179);
            $gray    = ImageColorAllocate($image,193,193,193);
            $skyblue = ImageColorAllocate($image,135,206,235);
            $lightblue = ImageColorAllocate($image,173,216,230);
            $turquoise = ImageColorAllocate($image,0,254,255);
            $sapgreen = imagecolorallocate($image, 48, 128, 20);
            $green3 = imagecolorallocate($image, 0, 205, 0);
            $yellow = imagecolorallocate($image, 255, 255, 0);
            $deepskyblue = imagecolorallocate($image, 0, 104, 139);

            $xCenter = $this->canvasWidth / 2;
            $yCenter = $this->canvasHeight / 2;            
            
            $warnaAtas = $this->warnaFromCode($this->code[0]);
            $warnaKanan = $this->warnaFromCode($this->code[1]);
            $warnaBawah = $this->warnaFromCode($this->code[2]);
            $warnaKiri = $this->warnaFromCode($this->code[3]);
            $warnaTengah = $this->warnaFromCode($this->code[4]);
            // bikin kanvas (kotak besar)
            imagefilledrectangle($image, 0, 0, $this->canvasWidth, $this->canvasHeight, $white);
           
          //  $this->drawSegitiga($image, $this->kiri, 3, $warnaKiri);
            
            if (!empty(Params::getChangeOdontogram($a))){                
				if (is_array($warnaAtas)){
					$this->drawSegitigaV($image, $this->atasV, 4, $warnaAtas, 'atas');    
				}else{
					$this->drawSegitigaV($image, $this->atasV, 4, $$warnaAtas, 'atas');  
				}
				
				if (is_array($warnaBawah)){
					$this->drawSegitigaV($image, $this->bawahV, 4, $warnaBawah, 'bawah');    
				}else{
					$this->drawSegitigaV($image, $this->bawahV, 4, $$warnaBawah, 'bawah');
				}                  
				
				if (is_array($warnaKanan)){
					$this->drawSegitigaV($image, $this->kananV, 4, $warnaKanan, 'kanan');     
				}else{
					$this->drawSegitigaV($image, $this->kananV, 4, $$warnaKanan, 'kanan');     
				}                
				
				if (is_array($warnaKiri)){
					$this->drawSegitigaV($image, $this->kiriV, 4, $warnaKiri, 'kiri');
				}else{
					$this->drawSegitigaV($image, $this->kiriV, 4, $$warnaKiri, 'kiri');
				}
                
                $this->drawBorderSegitiga($image, 0, 0, $xCenter, $yCenter, $this->canvasWidth, $this->canvasHeight-$this->tinggiCus, $black);
            }else{                
                 // bikin segitiga atas
				if (is_array($warnaAtas)){
					$this->drawSegitiga($image, $this->atas, 3, $warnaAtas, 'atas');
				}else{
					$this->drawSegitiga($image, $this->atas, 3, $$warnaAtas, 'atas');
				}
                
                // bikin segitiga kanan
				if (is_array($warnaKanan)){
					$this->drawSegitiga($image, $this->kanan, 3, $warnaKanan, 'kanan');
				}else{
					$this->drawSegitiga($image, $this->kanan, 3, $$warnaKanan, 'kanan');
				}
                
                // bikin segitiga bawah
				if (is_array($warnaBawah)){
					$this->drawSegitiga($image, $this->bawah, 3, $warnaBawah, 'bawah');
				}else{
					$this->drawSegitiga($image, $this->bawah, 3, $$warnaBawah, 'bawah');
				}
                
                // bikin segitiga kiri
				if (is_array($warnaKiri)){
					$this->drawSegitiga($image, $this->kiri, 3, $warnaKiri, 'kiri');
				}else{
					$this->drawSegitiga($image, $this->kiri, 3, $$warnaKiri, 'kiri');
				}
                
                $this->drawBorderSilangV2($image, 0, 0, $xCenter, $yCenter, $this->canvasWidth, $this->canvasHeight-$this->tinggiCus, $black);
				
				if (is_array($warnaTengah)){
					$this->drawKotakTengahV2($image, $this->tebal, $this->lebar, $this->canvasWidth, $this->canvasHeight-$this->tinggiCus, $warnaTengah, $black);
				}else{
					$this->drawKotakTengahV2($image, $this->tebal, $this->lebar, $this->canvasWidth, $this->canvasHeight-$this->tinggiCus, $$warnaTengah, $black);
				}
                
            }

                        
            

            $i = null;
            $this->drawBorderCustom($image, $black, $this->canvasWidth, $this->canvasHeight-$this->tinggiCus,$i,$this->tinggiCus);
            
            $lengthCode = strlen($this->code);
            if($lengthCode > 5 && !empty($this->code[($lengthCode-1)])) {
               // $file = $this->gambarFromCode("D");
               // $src = imagecreatefrompng($file);
               // imagecopy( $image, $src, 0, 0, 0, 0, 15, 15);
                for($r=5;$r<$lengthCode;$r++){
                    $code = $this->code[$r];
                    $this->drawFromCode($image, $this->canvasWidth, $this->canvasHeight, $code);
                }
            }
			
			
            
           
            
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Transfer-Encoding: binary');
            header("Content-type: image/png");
            imagepng($image);									
            imagedestroy($image);
			
			
    }
        
}
?>
