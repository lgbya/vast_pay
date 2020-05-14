<?php

namespace common\models;


/**
 * This is the model class for table "p_admin_log".
 *
 * @property int $id
 * @property string $route
 * @property int $created_at
 * @property int $admin_id
 * @property string $admin_ip
 * @property string $admin_agent
 * @property string $admin_name
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at', 'admin_id'], 'integer'],
            [['route', 'admin_agent', 'admin_name'], 'string', 'max' => 255],
            [['admin_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => '访问路由',
            'created_at' => '创建时间',
            'admin_id' => '管理员id',
            'admin_ip' => '访问ip',
            'admin_agent' => 'Agent',
            'admin_name' => '管理员名称',
        ];
    }
}
