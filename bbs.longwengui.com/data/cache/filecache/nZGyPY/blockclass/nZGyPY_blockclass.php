<?php
$data = array (
  'exp' => 0,
  'data' => 
  array (
    'forum' => 
    array (
      'name' => '论坛类',
      'subs' => 
      array (
        'forum_activity' => 
        array (
          'name' => '活动模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '活动帖URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '活动标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '主题图片',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '活动介绍',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'time' => 
            array (
              'name' => '活动时间',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'expiration' => 
            array (
              'name' => '报名截止时间',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'author' => 
            array (
              'name' => '发起人',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'authorid' => 
            array (
              'name' => '发起人UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'cost' => 
            array (
              'name' => '每人花销',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'place' => 
            array (
              'name' => '活动地点',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'class' => 
            array (
              'name' => '活动类型',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'gender' => 
            array (
              'name' => '性别要求',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'number' => 
            array (
              'name' => '需要人数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'applynumber' => 
            array (
              'name' => '已报名人数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'activity' => '高级自定义',
            'activitycity' => '同城活动',
            'activitynew' => '最新活动',
          ),
        ),
        'forum_forum' => 
        array (
          'name' => '版块模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '版块链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '版块名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'summary' => 
            array (
              'name' => '版块介绍',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'icon' => 
            array (
              'name' => '版块图标',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'posts' => 
            array (
              'name' => '版块帖子数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'threads' => 
            array (
              'name' => '版块话题数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'todayposts' => 
            array (
              'name' => '版块今日新帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'forum' => '论坛版块',
          ),
        ),
        'forum_thread' => 
        array (
          'name' => '帖子模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '帖子URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '帖子标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '附件图片',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '帖子内容',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'author' => 
            array (
              'name' => '楼主',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'authorid' => 
            array (
              'name' => '楼主UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'avatar' => 
            array (
              'name' => '楼主头像',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_middle' => 
            array (
              'name' => '楼主头像(中)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_big' => 
            array (
              'name' => '楼主头像(大)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'forumurl' => 
            array (
              'name' => '版块URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'forumname' => 
            array (
              'name' => '版块名称',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'typename' => 
            array (
              'name' => '主题分类名称',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'typeicon' => 
            array (
              'name' => '主题分类图标',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'typeurl' => 
            array (
              'name' => '主题分类URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'sortname' => 
            array (
              'name' => '分类信息名称',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'sorturl' => 
            array (
              'name' => '分类信息URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'posts' => 
            array (
              'name' => '总发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'todayposts' => 
            array (
              'name' => '今日发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'lastpost' => 
            array (
              'name' => '最后回复时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'dateline' => 
            array (
              'name' => '发帖时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'replies' => 
            array (
              'name' => '回复数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'views' => 
            array (
              'name' => '总浏览数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'heats' => 
            array (
              'name' => '热度值',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'recommends' => 
            array (
              'name' => '推荐数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'thread' => '高级自定义',
            'threaddigest' => '精华帖',
            'threadhot' => '热门帖',
            'threadnew' => '最新帖',
            'threadspecial' => '特殊主题帖',
            'threadspecified' => '指定帖子',
            'threadstick' => '置顶帖',
          ),
        ),
        'forum_trade' => 
        array (
          'name' => '商品模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '商品链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '商品名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '商品图片地址',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '商品说明',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'totalitems' => 
            array (
              'name' => '商品累计售出数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'author' => 
            array (
              'name' => '商品卖家',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'authorid' => 
            array (
              'name' => '商品卖家UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'price' => 
            array (
              'name' => '商品价格',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
          ),
          'script' => 
          array (
            'trade' => '高级自定义',
            'tradehot' => '热门商品',
            'tradenew' => '新商品',
            'tradespecified' => '指定商品',
          ),
        ),
      ),
    ),
    'group' => 
    array (
      'name' => '群组类',
      'subs' => 
      array (
        'group_group' => 
        array (
          'name' => '群组模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '群组链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '群组名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '群组图片',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '群组介绍',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'icon' => 
            array (
              'name' => '群组图标',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'foundername' => 
            array (
              'name' => '创始人',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'founderuid' => 
            array (
              'name' => '创始人UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'posts' => 
            array (
              'name' => '总发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'todayposts' => 
            array (
              'name' => '今日发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'threads' => 
            array (
              'name' => '总话题数',
              'formtype' => 'date',
              'datatype' => 'int',
            ),
            'membernum' => 
            array (
              'name' => '成员数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'dateline' => 
            array (
              'name' => '创建时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'level' => 
            array (
              'name' => '群组等级',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'commoncredits' => 
            array (
              'name' => '群组公共积分',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'activity' => 
            array (
              'name' => '群组活跃度',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'group' => '高级自定义',
            'grouphot' => '热门群组',
            'groupnew' => '最新群组',
            'groupspecified' => '指定群组',
          ),
        ),
        'group_activity' => 
        array (
          'name' => '群组活动',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '活动帖URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '活动标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '主题图片',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '活动介绍',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'time' => 
            array (
              'name' => '活动时间',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'expiration' => 
            array (
              'name' => '报名截止时间',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'author' => 
            array (
              'name' => '发起人',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'authorid' => 
            array (
              'name' => '发起人UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'cost' => 
            array (
              'name' => '每人花销',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'place' => 
            array (
              'name' => '活动地点',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'class' => 
            array (
              'name' => '活动类型',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'gender' => 
            array (
              'name' => '性别要求',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'number' => 
            array (
              'name' => '需要人数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'applynumber' => 
            array (
              'name' => '已报名人数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'groupactivity' => '群组活动',
            'groupactivitycity' => '同城活动',
            'groupactivitynew' => '最新活动',
          ),
        ),
        'group_thread' => 
        array (
          'name' => '群组帖子',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '帖子链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '帖子标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '附件图片',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '帖子内容',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'author' => 
            array (
              'name' => '楼主',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'authorid' => 
            array (
              'name' => '楼主UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'avatar' => 
            array (
              'name' => '楼主头像',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_middle' => 
            array (
              'name' => '楼主头像(中)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_big' => 
            array (
              'name' => '楼主头像(大)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'posts' => 
            array (
              'name' => '主题帖子总数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'todayposts' => 
            array (
              'name' => '主题今日帖子数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'lastpost' => 
            array (
              'name' => '主题最后发帖时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'dateline' => 
            array (
              'name' => '主题发布时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'replies' => 
            array (
              'name' => '主题回复数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'views' => 
            array (
              'name' => '主题查看数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'heats' => 
            array (
              'name' => '主题热度',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'recommends' => 
            array (
              'name' => '主题推荐数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'groupname' => 
            array (
              'name' => '群组名称',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'groupurl' => 
            array (
              'name' => '群组链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
          ),
          'script' => 
          array (
            'groupthread' => '高级自定义',
            'groupthreadhot' => '热门主题',
            'groupthreadnew' => '新主题',
            'groupthreadspecial' => '特殊主题',
            'groupthreadspecified' => '指定主题',
          ),
        ),
        'group_trade' => 
        array (
          'name' => '群组商品',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '商品链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '商品名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '商品图片地址',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '商品说明',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'totalitems' => 
            array (
              'name' => '商品累计售出数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'author' => 
            array (
              'name' => '商品卖家',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
            'authorid' => 
            array (
              'name' => '商品卖家UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'price' => 
            array (
              'name' => '商品价格',
              'formtype' => 'text',
              'datatype' => 'text',
            ),
          ),
          'script' => 
          array (
            'grouptrade' => '高级自定义',
            'grouptradehot' => '热门商品',
            'grouptradenew' => '新商品',
            'grouptradespecified' => '指定商品',
          ),
        ),
      ),
    ),
    'html' => 
    array (
      'name' => '展示类',
      'subs' => 
      array (
        'html_html' => 
        array (
          'name' => '静态模块',
          'fields' => 
          array (
          ),
          'script' => 
          array (
            'adv' => '站点广告',
            'banner' => '图片横幅',
            'blank' => '自定义HTML',
            'forumtree' => '版块列表',
            'friendlink' => '友情链接',
            'google' => 'GOOGLE',
            'line' => '分割线',
            'search' => '搜索条',
            'sort' => '分类信息',
            'stat' => '数据统计',
            'vedio' => '网络视频',
          ),
        ),
        'html_announcement' => 
        array (
          'name' => '公告模块',
          'fields' => 
          array (
            'url' => 
            array (
              'name' => '公告链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '公告标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'summary' => 
            array (
              'name' => '公告内容',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'starttime' => 
            array (
              'name' => '开始时间',
              'formtype' => 'text',
              'datatype' => 'date',
            ),
            'endtime' => 
            array (
              'name' => '结束时间',
              'formtype' => 'text',
              'datatype' => 'date',
            ),
          ),
          'script' => 
          array (
            'announcement' => '站点公告',
          ),
        ),
        'html_myapp' => 
        array (
          'name' => '漫游模块',
          'fields' => 
          array (
            'url' => 
            array (
              'name' => '应用链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '应用名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'icon' => 
            array (
              'name' => '应用图标',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'icon_small' => 
            array (
              'name' => '应用图标(小)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'icon_abouts' => 
            array (
              'name' => '应用图标(大图)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
          ),
          'script' => 
          array (
            'myapp' => '漫游应用',
          ),
        ),
      ),
    ),
    'member' => 
    array (
      'name' => '会员类',
      'subs' => 
      array (
        'member_member' => 
        array (
          'name' => '会员模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '空间链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '用户名',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'avatar' => 
            array (
              'name' => '用户头像',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_middle' => 
            array (
              'name' => '用户头像(中)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_big' => 
            array (
              'name' => '用户头像(大)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'regdate' => 
            array (
              'name' => '注册时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'posts' => 
            array (
              'name' => '发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'threads' => 
            array (
              'name' => '主题数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'digestposts' => 
            array (
              'name' => '精华帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'credits' => 
            array (
              'name' => '积分数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'reason' => 
            array (
              'name' => '推荐原因',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'unitprice' => 
            array (
              'name' => '竟价单次访问单价',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'showcredit' => 
            array (
              'name' => '竟价总积分',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'shownote' => 
            array (
              'name' => '竟价上榜宣言',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'extcredits1' => 
            array (
              'name' => '威望',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'extcredits2' => 
            array (
              'name' => '金钱',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'extcredits3' => 
            array (
              'name' => '贡献',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'realname' => 
            array (
              'name' => '真实姓名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'gender' => 
            array (
              'name' => '性别',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthyear' => 
            array (
              'name' => '出生年份',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthmonth' => 
            array (
              'name' => '出生月份',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthday' => 
            array (
              'name' => '生日',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'constellation' => 
            array (
              'name' => '星座',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'zodiac' => 
            array (
              'name' => '生肖',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'telephone' => 
            array (
              'name' => '固定电话',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'mobile' => 
            array (
              'name' => '手机',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'idcardtype' => 
            array (
              'name' => '证件类型',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'idcard' => 
            array (
              'name' => '证件号',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'address' => 
            array (
              'name' => '邮寄地址',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'zipcode' => 
            array (
              'name' => '邮编',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthprovince' => 
            array (
              'name' => '出生省份',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthcity' => 
            array (
              'name' => '出生地',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthdist' => 
            array (
              'name' => '出生县',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'birthcommunity' => 
            array (
              'name' => '出生小区',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'resideprovince' => 
            array (
              'name' => '居住省份',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'residecity' => 
            array (
              'name' => '居住地',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'residedist' => 
            array (
              'name' => '居住县',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'residecommunity' => 
            array (
              'name' => '居住小区',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'graduateschool' => 
            array (
              'name' => '毕业学校',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'education' => 
            array (
              'name' => '学历',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'company' => 
            array (
              'name' => '公司',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'occupation' => 
            array (
              'name' => '职业',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'position' => 
            array (
              'name' => '职位',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'revenue' => 
            array (
              'name' => '年收入',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'affectivestatus' => 
            array (
              'name' => '情感状态',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'lookingfor' => 
            array (
              'name' => '交友目的',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'bloodtype' => 
            array (
              'name' => '血型',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'alipay' => 
            array (
              'name' => '支付宝',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'qq' => 
            array (
              'name' => 'QQ',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'msn' => 
            array (
              'name' => 'MSN',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'taobao' => 
            array (
              'name' => '阿里旺旺',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'site' => 
            array (
              'name' => '个人主页',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'bio' => 
            array (
              'name' => '自我介绍',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'interest' => 
            array (
              'name' => '兴趣爱好',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
          ),
          'script' => 
          array (
            'member' => '高级自定义',
            'membercredit' => '积分排行',
            'membernew' => '新会员',
            'memberposts' => '发帖排行',
            'membershow' => '竞价排行',
            'memberspecial' => '特殊会员',
            'memberspecified' => '指定用户',
          ),
        ),
      ),
    ),
    'other' => 
    array (
      'name' => '其它类',
      'subs' => 
      array (
        'other_otherfriendlink' => 
        array (
          'name' => '友情链接',
          'fields' => 
          array (
            'url' => 
            array (
              'name' => '站点URL',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '站点名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '站点LOGO',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '站点简介',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
          ),
          'script' => 
          array (
            'otherfriendlink' => '高级自定义',
          ),
        ),
        'other_otherstat' => 
        array (
          'name' => '统计模块',
          'fields' => 
          array (
            'posts' => 
            array (
              'name' => '发帖总数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'posts_title' => 
            array (
              'name' => '帖子显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'groups' => 
            array (
              'name' => '群组总数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'groups_title' => 
            array (
              'name' => '群组显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'members' => 
            array (
              'name' => '会员总数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'members_title' => 
            array (
              'name' => '会员显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'groupnewposts' => 
            array (
              'name' => '群组今日发帖',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'groupnewposts_title' => 
            array (
              'name' => '今日发帖显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'bbsnewposts' => 
            array (
              'name' => '论坛今日发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'bbsnewposts_title' => 
            array (
              'name' => '今日发帖显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'bbslastposts' => 
            array (
              'name' => '论坛昨日发帖数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'bbslastposts_title' => 
            array (
              'name' => '昨日发帖显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'onlinemembers' => 
            array (
              'name' => '当前在线会员数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'onlinemembers_title' => 
            array (
              'name' => '当前在线会员显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'maxmembers' => 
            array (
              'name' => '历史最高在线会员数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'maxmembers_title' => 
            array (
              'name' => '历史最高在线显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'doings' => 
            array (
              'name' => '动态数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'doings_title' => 
            array (
              'name' => '动态显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'blogs' => 
            array (
              'name' => '日志数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'blogs_title' => 
            array (
              'name' => '日志显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'albums' => 
            array (
              'name' => '相册数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'albums_title' => 
            array (
              'name' => '相册显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'pics' => 
            array (
              'name' => '图片数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'pics_title' => 
            array (
              'name' => '图片显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'shares' => 
            array (
              'name' => '分享数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'shares_title' => 
            array (
              'name' => '分享显示名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
          ),
          'script' => 
          array (
            'otherstat' => '高级自定义',
          ),
        ),
      ),
    ),
    'portal' => 
    array (
      'name' => '门户类',
      'subs' => 
      array (
        'portal_article' => 
        array (
          'name' => '文章模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'uid' => 
            array (
              'name' => '作者UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'username' => 
            array (
              'name' => '作者名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar' => 
            array (
              'name' => '用户头像',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_middle' => 
            array (
              'name' => '用户头像(中)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_big' => 
            array (
              'name' => '用户头像(大)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'url' => 
            array (
              'name' => '文章链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '文章标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '文章封面',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '文章简介',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'dateline' => 
            array (
              'name' => '发布时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'caturl' => 
            array (
              'name' => '栏目链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'catname' => 
            array (
              'name' => '栏目名称',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'articles' => 
            array (
              'name' => '文章数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'viewnum' => 
            array (
              'name' => '查看数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'commentnum' => 
            array (
              'name' => '评论数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'article' => '高级自定义',
            'articlehot' => '热门文章',
            'articlenew' => '最新文章',
            'articlespecified' => '指定文章',
          ),
        ),
        'portal_category' => 
        array (
          'name' => '文章栏目',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '栏目链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '栏目名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'articles' => 
            array (
              'name' => '文章数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'portalcategory' => '文章栏目',
          ),
        ),
        'portal_topic' => 
        array (
          'name' => '专题模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '专题链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '专题名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '专题封面',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '专题介绍',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'uid' => 
            array (
              'name' => '创建者UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'username' => 
            array (
              'name' => '创建者',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'dateline' => 
            array (
              'name' => '创建时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'viewnum' => 
            array (
              'name' => '查看数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'topic' => '高级自定义',
            'topichot' => '热门专题',
            'topicnew' => '最新专题',
            'topicspecified' => '指定专题',
          ),
        ),
      ),
    ),
    'space' => 
    array (
      'name' => '空间类',
      'subs' => 
      array (
        'space_album' => 
        array (
          'name' => '相册模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '相册链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '相册名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '相册封面',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'uid' => 
            array (
              'name' => '用户UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'username' => 
            array (
              'name' => '用户名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'dateline' => 
            array (
              'name' => '创建日期',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'updatetime' => 
            array (
              'name' => '更新日期',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'picnum' => 
            array (
              'name' => '照片数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'album' => '高级自定义',
            'albumnew' => '最新相册',
            'albumspecified' => '指定相册',
          ),
        ),
        'space_blog' => 
        array (
          'name' => '日志模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '日志链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '日志标题',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'summary' => 
            array (
              'name' => '日志简介',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'pic' => 
            array (
              'name' => '日志图片',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'dateline' => 
            array (
              'name' => '发布时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'uid' => 
            array (
              'name' => '作者UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'username' => 
            array (
              'name' => '作者名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar' => 
            array (
              'name' => '用户头像',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_middle' => 
            array (
              'name' => '用户头像(中)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_big' => 
            array (
              'name' => '用户头像(大)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'replynum' => 
            array (
              'name' => '评论数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'viewnum' => 
            array (
              'name' => '浏览数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click1' => 
            array (
              'name' => '表态项1',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click2' => 
            array (
              'name' => '表态项2',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click3' => 
            array (
              'name' => '表态项3',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click4' => 
            array (
              'name' => '表态项4',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click5' => 
            array (
              'name' => '表态项5',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click6' => 
            array (
              'name' => '表态项6',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click7' => 
            array (
              'name' => '表态项7',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click8' => 
            array (
              'name' => '表态项8',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'blog' => '高级自定义',
            'bloghot' => '热门日志',
            'blognew' => '最新日志',
            'blogspecified' => '指定日志',
          ),
        ),
        'space_doing' => 
        array (
          'name' => '记录模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '记录链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '记录内容',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'uid' => 
            array (
              'name' => '用户UID',
              'formtype' => 'text',
              'datatype' => 'pic',
            ),
            'username' => 
            array (
              'name' => '用户名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar' => 
            array (
              'name' => '用户头像',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_middle' => 
            array (
              'name' => '用户头像(中)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'avatar_big' => 
            array (
              'name' => '用户头像(大)',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'dateline' => 
            array (
              'name' => '发布时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'replynum' => 
            array (
              'name' => '回复数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'doing' => '高级自定义',
            'doinghot' => '热门记录',
            'doingnew' => '最新记录',
          ),
        ),
        'space_pic' => 
        array (
          'name' => '图片模块',
          'fields' => 
          array (
            'id' => 
            array (
              'name' => '数据ID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'url' => 
            array (
              'name' => '图片链接',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'title' => 
            array (
              'name' => '图片名称',
              'formtype' => 'title',
              'datatype' => 'title',
            ),
            'pic' => 
            array (
              'name' => '图片地址',
              'formtype' => 'pic',
              'datatype' => 'pic',
            ),
            'summary' => 
            array (
              'name' => '图片说明',
              'formtype' => 'summary',
              'datatype' => 'summary',
            ),
            'uid' => 
            array (
              'name' => '用户UID',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'username' => 
            array (
              'name' => '用户名',
              'formtype' => 'text',
              'datatype' => 'string',
            ),
            'dateline' => 
            array (
              'name' => '上传时间',
              'formtype' => 'date',
              'datatype' => 'date',
            ),
            'viewnum' => 
            array (
              'name' => '查看数',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click1' => 
            array (
              'name' => '表态项1',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click2' => 
            array (
              'name' => '表态项2',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click3' => 
            array (
              'name' => '表态项3',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click4' => 
            array (
              'name' => '表态项4',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click5' => 
            array (
              'name' => '表态项5',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click6' => 
            array (
              'name' => '表态项6',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click7' => 
            array (
              'name' => '表态项7',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
            'click8' => 
            array (
              'name' => '表态项8',
              'formtype' => 'text',
              'datatype' => 'int',
            ),
          ),
          'script' => 
          array (
            'pic' => '高级自定义',
            'pichot' => '热门图片',
            'picnew' => '最新图片',
            'picspecified' => '指定图片',
          ),
        ),
      ),
    ),
  ),
);
