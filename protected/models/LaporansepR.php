<?php

/**
 * This is the model class for table "laporansep_r".
 *
 * The followings are the available columns in table 'laporansep_r':
 * @property integer $laporansep_id
 * @property integer $inacbg_id
 * @property integer $pendaftaran_id
 * @property integer $sep_id
 * @property string $laporansep_tgl
 * @property string $kdinacbg
 * @property string $kdseverity
 * @property string $nminacbg
 * @property double $bytagihan
 * @property double $bytarifgruper
 * @property double $bytarifrs
 * @property double $bytopup
 * @property string $jnspelayanan
 * @property string $nomr
 * @property string $nosep
 * @property string $nama
 * @property string $nokartu
 * @property string $kdstatsep
 * @property string $nmstatsep
 * @property string $tglpulang
 * @property string $tglsep
 * @property string $create_time
 * @property string $update_time
 * @property integer $login_pemakai_id
 * @property integer $update_pemakai_id
 * @property integer $create_ruangan
 */
class LaporansepR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansepR the static model class
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
		return 'laporansep_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, sep_id, laporansep_tgl, kdinacbg, nminacbg, bytagihan, bytarifgruper, bytarifrs, jnspelayanan, nomr, nosep, nama, nokartu, kdstatsep, nmstatsep, tglsep, create_time, login_pemakai_id, create_ruangan', 'required'),
			array('inacbg_id, pendaftaran_id, sep_id, login_pemakai_id, update_pemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('bytagihan, bytarifgruper, bytarifrs, bytopup', 'numerical'),
			array('kdinacbg, kdseverity, kdstatsep', 'length', 'max'=>50),
			array('nminacbg, nama', 'length', 'max'=>200),
			array('jnspelayanan, nosep, nokartu, nmstatsep', 'length', 'max'=>100),
			array('nomr', 'length', 'max'=>10),
			array('tglpulang, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('laporansep_id, inacbg_id, pendaftaran_id, sep_id, laporansep_tgl, kdinacbg, kdseverity, nminacbg, bytagihan, bytarifgruper, bytarifrs, bytopup, jnspelayanan, nomr, nosep, nama, nokartu, kdstatsep, nmstatsep, tglpulang, tglsep, create_time, update_time, login_pemakai_id, update_pemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'laporansep_id' => 'Laporansep',
			'inacbg_id' => 'Inacbg',
			'pendaftaran_id' => 'Pendaftaran',
			'sep_id' => 'Sep',
			'laporansep_tgl' => 'Laporansep Tgl',
			'kdinacbg' => 'Kdinacbg',
			'kdseverity' => 'Kdseverity',
			'nminacbg' => 'Nminacbg',
			'bytagihan' => 'Bytagihan',
			'bytarifgruper' => 'Bytarifgruper',
			'bytarifrs' => 'Bytarifrs',
			'bytopup' => 'Bytopup',
			'jnspelayanan' => 'Jnspelayanan',
			'nomr' => 'Nomr',
			'nosep' => 'Nosep',
			'nama' => 'Nama',
			'nokartu' => 'Nokartu',
			'kdstatsep' => 'Kdstatsep',
			'nmstatsep' => 'Nmstatsep',
			'tglpulang' => 'Tglpulang',
			'tglsep' => 'Tglsep',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'login_pemakai_id' => 'Login Pemakai',
			'update_pemakai_id' => 'Update Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->laporansep_id)){
			$criteria->addCondition('laporansep_id = '.$this->laporansep_id);
		}
		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->sep_id)){
			$criteria->addCondition('sep_id = '.$this->sep_id);
		}
		$criteria->compare('LOWER(laporansep_tgl)',strtolower($this->laporansep_tgl),true);
		$criteria->compare('LOWER(kdinacbg)',strtolower($this->kdinacbg),true);
		$criteria->compare('LOWER(kdseverity)',strtolower($this->kdseverity),true);
		$criteria->compare('LOWER(nminacbg)',strtolower($this->nminacbg),true);
		$criteria->compare('bytagihan',$this->bytagihan);
		$criteria->compare('bytarifgruper',$this->bytarifgruper);
		$criteria->compare('bytarifrs',$this->bytarifrs);
		$criteria->compare('bytopup',$this->bytopup);
		$criteria->compare('LOWER(jnspelayanan)',strtolower($this->jnspelayanan),true);
		$criteria->compare('LOWER(nomr)',strtolower($this->nomr),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(kdstatsep)',strtolower($this->kdstatsep),true);
		$criteria->compare('LOWER(nmstatsep)',strtolower($this->nmstatsep),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(tglsep)',strtolower($this->tglsep),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->login_pemakai_id)){
			$criteria->addCondition('login_pemakai_id = '.$this->login_pemakai_id);
		}
		if(!empty($this->update_pemakai_id)){
			$criteria->addCondition('update_pemakai_id = '.$this->update_pemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}