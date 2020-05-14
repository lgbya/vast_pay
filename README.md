# vast_pay
php版本 第四方支付web系统v1.0    

###一,安装
####window安装
直接运行以下命令
    
    ./install
    
####linux安装
1，先将根目录的install.sh文件赋予可执行权限
2，设置runtime目录可读可写权限
3，运行以下命令

    ./install
    
####如果install命令无法执行按以下步骤自行安装

1，执行安装扩展命令

    composer -vvv install 
    如果安装过程运行提示vendor\bower/jquery/dist文件不存在
    请执行以下命令
    composer global require "fxp/composer-asset-plugin:^1.4.0"

2，执行数据库迁移命令

    php yii migrate
    如果无法执行数据库迁移，请自行将根目录下的migrations文件夹下的sql文件导入数据库
    先导入base_table.sql再导入base_data.sql   
    
    
###二,nginx配置
nginx的配置放在根目录的vagrant\nginx下的app.conf 请根据实际自行修改<br>
项目分为三个部分

    前台 /app/home
    后台 /app/backend
    api /app/api
    
    
###三,定时任务的配置
    * * * * * php yii pay-order/notify-user
    
###四,下版本优化

    1,增加redis缓存
    2,将现有的models层分离出Repository 和业务逻辑层Service
    3,优化定时任务
    4,增加定时查询上游确认订单的正确性
    5,增加代付接口
    6,增加风控设置
    7,增加通道和产品，提款的图表分析
    8,优化前端显示和前台用户操作