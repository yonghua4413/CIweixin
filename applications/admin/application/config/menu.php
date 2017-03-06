<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(
    'menu' => array(
        '资讯管理' => array(
            'code' => 'news',
            'class' => 'glyphicon glyphicon-book',
            'list' => array(
                array(
                    '/newsclass',
                    '资讯分类'
                ),
                array(
                    '/news',
                    '资讯列表'
                )
            )
        ),
        '手工位管理' => array(
            'code' => 'manual',
            'class' => 'fa fa-chain',
            'list' => array(
                array(
                    '/manualclass',
                    '手工位名称' 
                ),
                array(
                    '/manual',
                    '手工位内容' 
                ) 
            ) 
        ),
        '管理员管理' => array(
            'code' => 'admin_user_manage',
            'class' => 'fa fa-user',
            'list' => array(
                array(
                    '/admin',
                    '管理员列表' 
                ),
                array(
                    '/admingroup',
                    '角色管理' 
                ),
                array(
                    '/adminspurview',
                    '权限管理' 
                ) 
            ) 
        ),
        '系统管理' => array(
            'code' => 'system_manage',
            'class' => 'fa fa-sun-o',
            'list' => array(
                array(
                    '/version',
                    '资源版本号更新' 
                ),
                array(
                    '/configes',
                    '系统配置' 
                )
            ) 
        ) 
    ) 
);
