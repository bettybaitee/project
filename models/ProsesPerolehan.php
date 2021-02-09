<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proses_perolehan".
 *
 * @property int $id
 * @property int|null $pero_id
 * @property int|null $jenis_id
 * @property string|null $date_proses
 * @property int|null $staff_id
 * @property string|null $catatan
 *
 * @property MasterlistPero $pero
 * @property KonfRujukan $jenis
 * @property KonfRujukan $staff
 */
class ProsesPerolehan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proses_perolehan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pero_id', 'jenis_id', 'staff_id'], 'integer'],
            [['date_proses'], 'safe'],
            [['catatan'], 'string'],
            [['pero_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterlistPero::className(), 'targetAttribute' => ['pero_id' => 'id']],
            [['jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['jenis_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pero_id' => 'Pero ID',
            'jenis_id' => 'Jenis ID',
            'date_proses' => 'Date Proses',
            'staff_id' => 'Staff ID',
            'catatan' => 'Catatan',
        ];
    }

    /**
     * Gets query for [[Pero]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPero()
    {
        return $this->hasOne(MasterlistPero::className(), ['id' => 'pero_id']);
    }

    /**
     * Gets query for [[Jenis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenis()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'jenis_id']);
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'staff_id']);
    }
}
