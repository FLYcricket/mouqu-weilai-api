# mouqu-weilai-api
谋趣相关接口-初调
刚开始写接口，没有加上token验证这是一个很大的问题，另外还有就是面向对象没有吃透，所有就用了一种最简单的接口方式。
  这里app的聊天系统是集成环信的客服系统，而支付我们用的是ping++平台的支付系统。
  
  ####----注释------################
  http://127.0.0.1/demo/sign.php
1.手机登录验证码
  参数
   action：sendcode
            phone  手机号
			
		json：
		code  验证码
		phone  手机号
			
			
2.登录
  参数	
   action：login
        code  验证码
		phone  手机号
		
	####状态码：code 1 验证成功，注册登录  0， 验证失败  2 用户已存在,直接登陆  3 登录失败	
	

	
http://127.0.0.1/demo/setting.php
1.最新消息通知
   action：message
   
      json：
   message 最新消息
   
2.服务协议
   action：service
   
      json：
	   service 协议
      
   
3.版本号
   action：version
   
      json：
	  version 版本号
   
4.建议
action：advice
     advice
	 
      json：
	  advice  建议
	  
5.投诉
   action：complaint
     complaint
	 
	
      json：
	  complaint 投诉
	 
########状态码：status 0 更新失败  1 更新成功
	 
	 
	 
http://127.0.0.1/demo/setting.php
1.个人信息
 action：info
 
      json：
	   username 用户名
	 sex  性别  （男，女，保密）
	 age   年龄
	 tag    职业标签 （用户，商户）
	 phone    手机号
	 location    所在地
	 hometown     故乡
	 info   个人说明
	  
 
 2.更改个人信息
 action：add_info
     username 用户名
	 sex  性别  （男，女，保密）
	 age   年龄
	 tag    职业标签 （用户，商户）
	 phone    手机号
	 location    所在地
	 hometown     故乡
	 info   个人说明


	 
地址接收
   action：address
   
   json：
        name 姓名
	   sex   性别
	   phone   联系电话
	   address   联系地址
	   
         
		 
添加地址
   action：add_address
       name 姓名
	   sex   性别
	   phone   联系电话
	   address   联系地址
	   
	   
	   
设置默认地址
 action：de_address
    id 地址id
	
	
订单列表（用户）
   action：orders
   page_size  页码
   page_num   每页显示条数
   
  	
订单列表（商户）
   action：orderslist
   page_size  页码
   page_num   每页显示条数
   
 评价
    action：assess
	   stars  评星
	   assess  评价
	   id   订单id
	   
	   
	   
商户入驻
  action：aut
     name 姓名
	 sex  性别 （男，女）
	 type  职业类别（用户，商户）
	 id_num  身份证号码
	 pic     身份证正反面和营业执照 （这是一个数组）
	 other   其他
	 
	 
	 
手机改绑验证
action：mobile
   phone 手机号
   
 ########状态码：status 0 更新失败  1 更新成功  
   
	
  http://127.0.0.1/demo/orders.php  
  
商户接单列表
  action：list
	page_size  页码
    page_num   每页显示条数
	
	
订单详情
  action：detail
    id  订单id
	
	
商户接单
    action：receive
	   id  订单id
	   
 ########状态码 status 0 接单失败  1 接单成功 2 未审核
   
 
