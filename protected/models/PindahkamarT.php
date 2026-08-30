<?php

/**
 * This is the model class for table "pindahkamar_t".
 *
 * The followings are the available columns in table 'pindahkamar_t':
 * @property integer $pindahkamar_id
 * @property integer $pasien_id
 * @property integer $shift_id
 * @property integer $kamarruangan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $pegawai_id
 * @property integer $masukkamar_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $nopindahkamar
 * @property string $tglpindahkamar
 * @property string $jampindahkamar
 */
class PindahkamarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PindahkamarT the static model class
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
		return 'pindahkamar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, shift_id, pendaftaran_id, pasienadmisi_id, carabayar_id, penjamin_id, ruangan_id, nopindahkamar, tglpindahkamar, jampindahkamar', 'required'),
			array('pasien_id, shift_id, kamarruangan_id, pendaftaran_id, pasienadmisi_id, carabayar_id, penjamin_id, pegawai_id, masukkamar_id, kelaspelayanan_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('nopindahkamar', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pindahkamar_id, pasien_id, shift_id, kamarruangan_id, pendaftaran_id, pasienadmisi_id, carabayar_id, penjamin_id, pegawai_id, masukkamar_id, kelaspelayanan_id, ruangan_id, nopindahkamar, tglpindahkamar, jampindahkamar', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'kamarruangan'=> array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pindahkamar_id' => 'Pindahkamar',
			'pasien_id' => 'Pasien',
			'shift_id' => 'Shift',
			'kamarruangan_id' => 'Kamar Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'pegawai_id' => 'Nama Dokter',
			'masukkamar_id' => 'Masukkamar',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'ruangan_id' => 'Ruangan',
			'nopindahkamar' => 'Nopindahkamar',
			'tglpindahkamar' => 'Tanggal Pindah Kamar',
			'jampindahkamar' => 'Jam Pindah Kamar',
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

		$criteria->compare('pindahkamar_id',$this->pindahkamar_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(nopindahkamar)',strtolower($this->nopindahkamar),true);
		$criteria->compare('LOWER(tglpindahkamar)',strtolower($this->tglpindahkamar),true);
		$criteria->compare('LOWER(jampindahkamar)',strtolower($this->jampindahkamar),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pindahkamar_id',$this->pindahkamar_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(nopindahkamar)',strtolower($this->nopindahkamar),true);
		$criteria->compare('LOWER(tglpindahkamar)',strtolower($this->tglpindahkamar),true);
		$criteria->compare('LOWER(jampindahkamar)',strtolower($this->jampindahkamar),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasiId='')
        {
            if($instalasiId!='')
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasiId,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            else
                return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
        }
        
         /**
         * Mengambil daftar semua ruangan di module perawat intensif
         * @return CActiveDataProvider 
         */
        public function getRuanganItems2($instalasiId='',$instalasiId2='')
        {
            if($instalasiId!='' && $instalasiId2!='') {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('instalasi_id', array($instalasiId,$instalasiId2,));
                $criteria->addCondition('ruangan_aktif = true');
                $criteria->order='ruangan_nama ASC';
                return RuanganM::model()->findAll($criteria);
            }else{
                return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
        
            }
        }
        
        public function getKelasItems($ruangan_id = null)
        {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                array(
                    'ruangan_id'=>$ruangan_id,
                ),
                array(
                    'order'=>'kelaspelayanan_id'
                )
            );

            $kelas = null;
			$kelaspelayanan = array();
            foreach($kamarKosong as $val)
            {
                if($kelas != $val->kelaspelayanan_id)
                {
                    $kelas = $val->kelaspelayanan_id;
                    $kls_pelayanan = KelaspelayananM::model()->findByAttributes(
                        array(
                            'kelaspelayanan_id'=>$val->kelaspelayanan_id
                        )
                    );
                    $kelaspelayanan[] = $kls_pelayanan;
                }
            }
            return $kelaspelayanan;
        }        
        
        public function getKelasPelayananItems()
        {
            return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true ORDER BY kelaspelayanan_nama');
        }
        
        /*
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                    }
            }
            return parent::beforeValidate ();
        }
         * 
         */
        /*
        protected function beforeSave() {  
            return parent::beforeSave();
        }
         * 
         */
        /*
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
         * 
         */
}