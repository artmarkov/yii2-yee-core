<?php

namespace yeesoft\models;

use Yii;

/**
 * This is the model class for table "user_setting".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 *
 * @author Taras Makitra <makitrataras@gmail.com>
 */
class UserSetting extends \yeesoft\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'key', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public function get($key, $default = NULL)
    {
        if ($setting = self::findOne(['user_id' => Yii::$app->user->id, 'key' => $key])) {
            return json_decode($setting->value);
        }

        return $default;
    }

    public function set($key, $value)
    {
        $params = ['user_id' => Yii::$app->user->id, 'key' => $key];

        if (!$setting = self::findOne($params)) {
            $setting = new self($params);
        }

        $setting->value = json_encode($value);

        return ($setting->save()) ? TRUE : FALSE;
    }

}
