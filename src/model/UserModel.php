<?php

namespace Ran\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model{
    //����
     protected $table = 'user';
    //����
    protected $primaryKey = 'user_id';
    //����ģ���ֶ�
    protected $fillable = [
        'user_id',                  // '�û�ID',
        'group_id',                 // '�û���ID',
        'user_name',                // '�û���',
        'user_pwd',                 // '�û�����',
        'user_phone',               // '�û��ֻ�����',
        'user_sex',                 // '�û��Ա�',
        'user_qq',                  // '�û�QQ����',
        'user_email',               // '�û�EMAIL��ַ',
        'user_address',             // '�û���ַ',
        'user_mark',                // '�û�����',
        'user_rank_id',             // '�û��ȼ�',
        'user_last_login_ip',       // '�û���һ�ε�¼IP��ַ',
        'user_birthday',            // '�û�����',
        'user_description',         // '��������',
        'user_image_url',           // '�û�ͷ��洢·��',
        'user_school',              // '��ҵѧУ',
        'user_register_time',       // '�û�ע��ʱ��',
        'user_register_ip',         // '�û�ע��ʱIP��ַ',
        'user_last_update_time',    // '�û��ϴθ��²���ʱ��',
        'user_weibo' ,              // '�û�΢��',
        'user_blood_type',          // '�û�Ѫ��',
        'user_says',                // '�û���¼',
        'user_lock',                // '�Ƿ�������0Ϊ��������1Ϊ����',
        'user_freeze',              // '�Ƿ񶳽ᣬ0Ϊ�����ᣬ1Ϊ����',
        'user_power',               // 'ӵ��Ȩ��' 
    ];
    //�ر��Զ�����ʱ���
     public $timestamps = false;
}
