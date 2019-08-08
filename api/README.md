# 1 安装部署

# 1.1 前置依赖

要求部署环境上已经有如下工具:
1.系统环境:Debian Stable ( wheezy 7.8 )
2.服务器: nginx/1.4.6 

3.数据库:mysql/5.5.44
4.php版本 >=5.5.9

# 1.2 安装依赖

# 1.2.1 安装系统工具

在一个干净的debain上安装需要php, php-fpm, curl，composer。

````bash
#安装php环境
sudo apt-get install php5 php5-fpm php5-sybase
在/etc/freetds/freetds.conf中修改新增一行：
````bash
    [global]
            # TDS protocol version
    ;       tds version = 4.2
            tds version = 8.0//新增

````
#安装curl
sudo apt-get install curl


#安装composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
````

# 1.2.2 安装php扩展

中台正常运行需要如下php扩展：Mcrypt/MySQL PDO/CURL/gd。

````bash
sudo apt-get install php5-mcrypt php5-mysql php5-curl php5-gd
````

# 1.3 部署源码

## 1.3.1 从github上获得项目源码

项目源码托管在github.com上，项目名称为： https://github.com/uncarman/laraval_admin.git。

````bash
# 使用master分支
git clone https://github.com/uncarman/laraval_admin.git
git checkout master
````
## 1.3.2 项目目录权限配置

storage：  数据存储目录，用于存储项目缓存数据，需要有写入权限.
bootstrap/cache: 目录的写权限

## 1.3.3 composer加载项目扩展依赖

````bash
#切换到网站根目录下
composer install
````
## 1.3.4 nginx服务器配置

````bash
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
````
# 1.4 配置文件

先复制配置示例：

````bash
#根目录下找到 .env.example
cp .env.example .env
````
.env即该项目配置文件

## 1.4.1 数据库配置

在.env中修改如下配置:

````bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=root
DB_PASSWORD=123456

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DATABASE_LOG=6

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mxhichina.com
MAIL_PORT=465
MAIL_USERNAME=center_post@sunallies.com
MAIL_FROM_ADDRESS=center_post@sunallies.com
MAIL_FROM_NAME=center_post@sunallies.com
MAIL_PASSWORD=Center@12
MAIL_ENCRYPTION=ssl

// 短信接口
SMS_URL= http://****/send

// 极光推送配置
JPUSH_APP_KEY = 7b251a07b0edfe09dd24****
JPUSH_MASTER_SECRET = 1997fc5df257ff89ebb7****
````

# 1.5 数据库/文件初始化

## 1.5.1 数据库初始化

````bash
 在数据库创建数据库
#在网站根目录执行
php artisan forone:init
#php artisan migrate:refresh --seed
````

# 2 更新部署

初次安装完毕后， 如果需要升级，需要执行如下步骤。

## 2.1 依赖更新

需要参考每一次的更新文档

## 2.2 代码更新

在网站的根目录执行：

````bash
git pull --rebase
````

## 2.3 数据库升级

````
cd src
php artisan migrate --force
````

# 3 开发配置

## 3.1 开启调试

在根目录.env文件中修改如下配置即可控制是否开启调试模式:
````bash
APP_DEBUG=false
````

# 4. 升级php7.0


## ubuntu 14 升级php7.0步骤
```bash
sudo add-apt-repository ppa:ondrej/php

sudo apt-get update

sudo apt-get install php7.0 php7.0-cli php7.0-fpm php7.0-gd php7.0-json php7.0-mysql php7.0-zip php7.0-bcmath php7.0-readline php7.0-mbstring php7.0-xml php7.0-mcrypt php7.0-curl php7.0-sybase

```

## 更改nginx配置
在站点配置

```bash
location ~ \.php$ {
                include snippets/fastcgi-php.conf;
        #       # With php5-fpm:
                fastcgi_pass unix:/var/run/php5-fpm.sock;
        }

```
改为

```bash
location ~ \.php$ {
                include snippets/fastcgi-php.conf;
        #       # With php5-fpm:
                fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
        }


```
重启
```bash
sudo service nginx restart

```
