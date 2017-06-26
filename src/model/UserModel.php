<?php

namespace Ran\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model{
    //表名
     protected $table = 'user';
    //主键
    protected $primaryKey = 'user_id';
    //定义模型字段
    protected $fillable = [
        'user_id',                  // '用户ID',
        'group_id',                 // '用户组ID',
        'user_name',                // '用户名',
        'user_pwd',                 // '用户密码',
        'user_phone',               // '用户手机号码',
        'user_sex',                 // '用户性别',
        'user_qq',                  // '用户QQ号码',
        'user_email',               // '用户EMAIL地址',
        'user_address',             // '用户地址',
        'user_mark',                // '用户积分',
        'user_rank_id',             // '用户等级',
        'user_last_login_ip',       // '用户上一次登录IP地址',
        'user_birthday',            // '用户生日',
        'user_description',         // '自我描述',
        'user_image_url',           // '用户头像存储路径',
        'user_school',              // '毕业学校',
        'user_register_time',       // '用户注册时间',
        'user_register_ip',         // '用户注册时IP地址',
        'user_last_update_time',    // '用户上次更新博客时间',
        'user_weibo' ,              // '用户微博',
        'user_blood_type',          // '用户血型',
        'user_says',                // '用户语录',
        'user_lock',                // '是否锁定，0为不锁定，1为锁定',
        'user_freeze',              // '是否冻结，0为不冻结，1为冻结',
        'user_power',               // '拥有权限' 
    ];
    //关闭自动更新时间戳
     public $timestamps = false;
}
