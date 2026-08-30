<?php

/**
 * This is the model class for table "masterakunrekening_v".
 *
 * The followings are the available columns in table 'masterakunrekening_v':
 * @property integer $akun
 * @property integer $id
 * @property string $kode
 * @property string $nama
 * @property string $saldo_normal
 * @property boolean $aktif
 * @property string $keterangan
 */
class MasterakunrekeningV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MasterakunrekeningV the static model class
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
		return 'masterakunrekening_v';
		// return 'rekening5_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('akun, id', 'numerical', 'integerOnly'=>true),
			array('kode, nama, saldo_normal, aktif, keterangan, tiperekening_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('akun, id, kode, nama, saldo_normal, aktif, keterangan, tiperekening_id', 'safe', 'on'=>'search'),
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
			'akun' => 'Akun',
			'id' => 'ID',
			'kode' => 'Kode',
			'nama' => 'Nama',
			'saldo_normal' => 'Saldo Normal',
			'aktif' => 'Aktif',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('t.akun',$this->akun);
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.kode',$this->kode,true);
		$criteria->compare('lower(t.nama)',strtolower($this->nama),true);
		$criteria->compare('lower(t.saldo_normal)',strtolower($this->saldo_normal),true);
		$criteria->compare('t.aktif',$this->aktif);
		$criteria->compare('t.keterangan',$this->keterangan,true);
		$criteria->compare('t.tiperekening_id',$this->tiperekening_id);
                
                $criteria->order = 't.kode asc';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    public function searchKodeRekening() {
        $prov = $this->search();
        $prov->pagination = false;
        $prov->criteria->join = ' join rekeningakuntansi_v r on ('
		. '(t.levelrek = 1 and r.rekening1_id = t.id) or '
		. '(t.levelrek = 2 and r.rekening2_id = t.id) or '
		. '(t.levelrek = 3 and r.rekening3_id = t.id) or '
		. '(t.levelrek = 4 and r.rekening4_id = t.id) or '
		. '(t.levelrek = 5 and r.rekening5_id = t.id) or '
		. '(t.levelrek = 6 and r.rekening6_id = t.id) or '
		. '(t.levelrek = 7 and r.rekening7_id = t.id) or '
		. '(t.levelrek = 8 and r.rekening8_id = t.id) or '
		. '(t.levelrek = 9 and r.rekening9_id = t.id) or '
		. '(t.levelrek = 10 and r.rekening10_id = t.id)'
		. ')';
		$prov->criteria->group = 't.akun, t.id, t.kode, t.nama,t.levelrek, t.saldo_normal, t.aktif, t.keterangan, t.tiperekening_id,r.kelrekeninglast_id';
        // $prov->criteria->group = 't.akun, t.id, t.kode, t.nama,t.levelrek, t.saldo_normal, t.aktif, t.keterangan, t.tiperekening_id';
        $prov->criteria->addCondition('t.aktif = true');
        
        
        $res = array();
        
        $key = 0;
        foreach ($prov->data as $item) {
            
            $sub = $item->attributes;
            $sub['item_id'] = $key++;
            
            $res[] = $sub;
        }
        
        return new CArrayDataProvider($res, array(
            'id'=>'item_id',
            'keyField'=>'kode'
        ));
        
    }
    
        public function searchPrint() {
                $provider = $this->search();
                $provider->criteria->limit = -1;
                $provider->pagination = false;
                
                return $provider;
        }
}