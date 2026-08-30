<?php

/**
 * This is the model class for table "shift_m".
 *
 * The followings are the available columns in table 'shift_m':
 * @property integer $shift_id
 * @property string $shift_nama
 * @property string $shift_namalainnya
 * @property string $shift_jamawal
 * @property string $shift_jamakhir
 * @property boolean $shift_aktif
 */
class ShiftM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shift_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_nama, shift_jamawal, shift_jamakhir, shift_aktif', 'required'),
			array('shift_nama, shift_namalainnya', 'length', 'max'=>50),
			array('shift_bedatanggal','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('shift_id, shift_nama, shift_namalainnya, shift_jamawal, shift_jamakhir, shift_aktif', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shift_id' => 'Shift',
			'shift_nama' => 'Nama Shift',
			'shift_namalainnya' => 'Nama Lain Shift',
			'shift_jamawal' => 'Jam Awal Shift',
			'shift_jamakhir' => 'Jam Akhir Shift',
			'shift_aktif' => 'Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$criteria=new CDbCriteria;
		
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_namalainnya)',strtolower($this->shift_namalainnya),true);

		if((!empty($this->shift_jamawal))&&(strlen($this->shift_jamawal)>3)){
			$criteria->addCondition("shift_jamawal = '".$this->shift_jamawal."'");
		}
		if((!empty($this->shift_jamakhir))&&(strlen($this->shift_jamakhir)>3)){
			$criteria->addCondition("shift_jamakhir = '".$this->shift_jamakhir."'");
		}
		$criteria->compare('shift_aktif',isset($this->shift_aktif)?$this->shift_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_namalainnya)',strtolower($this->shift_namalainnya),true);

		if((!empty($this->shift_jamawal))&&(strlen($this->shift_jamawal)>3)){
			$criteria->addCondition("shift_jamawal = '".$this->shift_jamawal."'");
		}
		if((!empty($this->shift_jamakhir))&&(strlen($this->shift_jamakhir)>3)){
			$criteria->addCondition("shift_jamakhir = '".$this->shift_jamakhir."'");
		}
		$criteria->compare('shift_aktif',isset($this->shift_aktif)?$this->shift_aktif:true);
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->shift_nama = ucwords(strtolower($this->shift_nama));
            $this->shift_namalainnya = strtoupper($this->shift_namalainnya);
            return parent::beforeSave();
        }
        
        public function getJam($shift_id, $get = null){
            $get = $this->findByPk($shift_id);
            $jam = '';
            if (count((array)$get)>0){
                $jam = $get->shift_nama." / ".$get->shift_jamawal.' s/d '.$get->shift_jamakhir;
            }else{
                $jam =  '-';
            }
            
            if ($get != null){
                if ($jam != '-'){
                    if ($jam != '-'){
                        $pecah = explode(' / ', $jam);
                        $pecah2 = explode(' s/d ', $pecah[1]);

                        if ($get == 1){
                            return $pecah2[0];
                        }else{
                            return $pecah2[1];
                        }                    
                    }
                }
            }else{
                return $jam;
            }
        }
        
        public function getShift($jam_masuk, $jam_keluar, $masuk, $pulang, $get=null)
        {
            $jam= '';
            
            
                if ( ($jam_masuk=='') && ($jam_keluar != ''))
                {
                    $data = $this->find(array('condition'=>'shift_aktif = TRUE AND shift_jamakhir = :shift_jamakhir ORDER BY shift_jamakhir DESC',
                        'params'=>array(':shift_jamakhir'=>$jam_keluar,
                            ),'limit'=>1));

                   
                    if (count((array)$data)> 0){
                        $jam = $data->shift_nama.' / '.$data->shift_jamawal.' s/d '.$data->shift_jamakhir;
                    }else{
                        if ($pulang != null):
                            $jam = $this->getJamPul($pulang);
                        else:
                            $jam = '-';
                        endif;
                    }
                }elseif ( ($jam_keluar=='') && ($jam_masuk != '') ){
                    $data = $this->find(array('condition'=>'shift_aktif = TRUE AND shift_jamawal = :shift_jamawal ORDER BY shift_jamawal DESC',
                        'params'=>array(':shift_jamawal'=>$jam_masuk,
                            ),'limit'=>1));

                   
                    if (count((array)$data)> 0){
                        $jam = $data->shift_nama.' / '.$data->shift_jamawal.' s/d '.$data->shift_jamakhir;
                    }else{
                        if ($masuk != null):
                            $jam = $this->getJamMasuk($masuk);
                        else:
                            $jam = '-';
                        endif;
                    }
                }elseif (($jam_keluar=='') && ($jam_masuk=='')){
                    $jam = '-';
                }  else {
                    $data = $this->find(array('condition'=>'shift_aktif = TRUE AND shift_jamakhir = :shift_jamakhir AND shift_jamawal = :shift_jamawal ORDER BY shift_jamawal DESC',
                        'params'=>array(':shift_jamawal'=>$jam_masuk,':shift_jamakhir'=>$jam_keluar
                            ),'limit'=>1));

                    
                    if (count((array)$data)> 0){                                                
                        $jam = $data->shift_nama.' / '.$data->shift_jamawal.' s/d '.$data->shift_jamakhir;                        
                    }else{
                        $jam = '-';
                    }
                    
                }
            
            if ($get == null){
                return $jam;
            }else{
                if ($jam != '-'){
                    $pecah = explode(' / ', $jam);
                    $pecah2 = explode(' s/d ', $pecah[1]);
                            
                    if ($get == 1){
                        if ( ($jam_masuk == '08:00:00') OR ($jam_masuk == '08:15:00')){
                            //return '08:15:00';
                            return $this->getWaktu($masuk,'masuk');
                            
                        }else{
                            return $pecah2[0];
                        }
                    }else{
                        if ($pecah2[1]){
                            //return '14:00:00';
                            return $this->getWaktu($pulang,'pulang');
                        }else{
                            return $pecah2[1];
                        }
                    }
                    
                }
            }
            
        }
               
        
        public function getJamMasuk($jam_masuk)
        {
            $jam_masuk = date('H:i:s', strtotime($jam_masuk));            
                
            if ( ($jam_masuk >= '03:00:00') AND ($jam_masuk <= '06:59:59'))
            {
                return 'Pagi / 04:00:00 s/d 07:00:00';
            }elseif ( ($jam_masuk >= '07:00:00') AND ($jam_masuk <= '12:59:59'))
            {
                return 'Pagi / 08:00:00 s/d 15:00:00';
            }elseif ( ($jam_masuk >= '13:00:00') AND ($jam_masuk <= '19:59:59'))
            {
                return 'Siang / 14:00:00 s/d 21:00:00';
            }elseif ( ($jam_masuk >= '20:00:00') AND ($jam_masuk <= '03:59:59'))
            {
                return 'Malam / 21:00:00 s/d 08:00:00';
            }else{
                return '-';
            }
        }
        
        public function getJamPul($jam_keluar)
        {                           
            $jam_keluar = date('H:i:s', strtotime($jam_keluar));            
                
            if ( ($jam_keluar >= '04:00:00') AND ($jam_keluar <= '08:59:59'))
            {
                return 'Subuh / 04:00:00 s/d 07:00:00';
            }elseif ( ($jam_keluar >= '09:00:00') AND ($jam_keluar <= '15:59:59'))
            {
                return 'Pagi / 08:00:00 s/d 15:00:00';
            }elseif ( ($jam_keluar >= '16:00:00') AND ($jam_keluar <= '21:59:59'))
            {
                return 'Siang / 14:00:00 s/d 21:00:00';
            }elseif ( ($jam_keluar >= '22:00:00') AND ($jam_keluar <= '08:59:59'))
            {
                return 'Malam / 21:00:00 s/d 08:00:00';
            }else{
                return '-';
            }
        }
        
        
        public function getWaktu($jam,$get=null){
            $waktu = date('H:i:s', strtotime($jam));
         
            if ($get=='masuk'){                         
                if ( ($waktu >= '03:00:00') AND ($waktu <= '06:59:59'))
                {
                    return '04:00:00';
                }elseif ( ($waktu >= '07:00:00') AND ($waktu <= '12:59:59'))
                {
                    return '08:15:00';
                }elseif ( ($waktu >= '13:00:00') AND ($waktu <= '19:59:59'))
                {
                    return '14:00:00';
                }else{
                       
                    return '21:00:00';
                }
            }else{
                
                if ( ($waktu >= '04:00:00') AND ($waktu <= '08:59:59'))
                {
                    return '07:00:00';
                }elseif ( ($waktu >= '09:00:00') AND ($waktu <= '15:59:59'))
                {                    
                    return '14:00:00';
                }elseif ( ($waktu >= '16:00:00') AND ($waktu <= '21:59:59'))
                {
                    return '21:00:00';
                }else{                    
                    return '08:00:00';
                }
            }
        }
		
		public function getShiftJam(){
			return $this->shift_nama.' ('.$this->shift_jamawal.' - '.$this->shift_jamakhir.')';
		}
        
        
        public function getShiftRuangan($ruangan_id) {
            $cr = new CDbCriteria();
            $cr->join = 'join shiftpegawai_m sp on sp.shift_id = t.shift_id '
                    . 'join ruanganpegawai_m r on r.pegawai_id = sp.pegawai_id ';
            $cr->compare('r.ruangan_id', $ruangan_id);
            $cr->addCondition('t.shift_aktif = true');
            $cr->order = 't.shift_urutan';
            
            return self::model()->findAll($cr);
        }
        
        public function getShiftLogin($pegawai_id) {
            $now = date('H:i:s');
            $cr = new CDbCriteria();
            $cr->join = 'join shiftpegawai_m sp on sp.shift_id = t.shift_id';
            $cr->compare('sp.pegawai_id', $pegawai_id);
            $cr->addCondition("t.shift_aktif = true");
            $cr->limit = 1;
            
            $cr2 = clone $cr;
            
            $cr->addCondition("'${now}' < t.shift_jamakhir");
            $cr->order = "shift_jamakhir ASC";
            
            $cr2->addCondition("'${now}' > t.shift_jamawal");
            $cr->order = "shift_jamakhir DESC";
            
            $res = self::model()->find($cr);
            if (empty($res)) {
                return self::model()->find($cr2);
            }
            return $res;
            
            
        }
        
       
}