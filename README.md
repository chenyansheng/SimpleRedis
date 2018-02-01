# SimpleRedis
The SimpleRedis extension provides a very simple and easily usable toolset to use redis key-value db.

SimpleRedis一个非常简单轻量化的php redis扩展。
├── lib
│   └── SimpleRedis.class.php
├── README.md
└── test
    ├── phpredis-master.zip
    ├── redis-2.8.17.tar.gz
    └── sample.php

核心文件：SimpleRedis.class.php，采用单例模式实例化，封装了redis基本操作。redis本身还有很多命令，只需要依样增加相对的方法即可。

phpredis-master.zip | redis-2.8.17.tar.gz为redis源代码包和phpredis扩展源代码包，编译安装即可使用，也可以安装其他版本的。

sample.php实例程序，先定义redis配置。db_id默认为0号库，auth可以为空


## 欢迎使用
欢迎来到Simple世界，代码永无bug！服务器永不宕机！
