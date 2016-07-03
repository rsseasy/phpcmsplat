var menudata = {
    'user': {
        'text': '联盟管理',
        'children': {
            'staff': {
                'text': '管理事项',
                'children': {
                    'staff': {
                        'text': '用户列表',
                        'url': '/user/list.php'
                    }
                }
            }
        }
    },
    'article': {
        'text': '文章管理',
        'children': {
            'staff': {
                'text': '管理事项',
                'children': {
                    'list': {
                        'text': '文章列表',
                        'url': '/article/list.php'
                    },
                    'huandeng': {
                        'text': '幻灯列表',
                        'url': '/huandeng/list.php'
                    }
                }
            }
        }
    },
    'admin': {
        'text': '管理员管理',
        'children': {
            'staff': {
                'text': '管理事项',
                'children': {
                    'staff': {
                        'text': '人员管理',
                        'url': '/staff/list.php'
                    }
                }
            },
            'power': {
                'text': '权限管理',
                'children': {
                    'list': {
                        'text': '列表',
                        'url': '/staff/power/list.php'
                    },
                    'create': {
                        'text': '生成数据',
                        'url': '/staff/power/json.php'
                    }
                }
            }
        }
    }
}