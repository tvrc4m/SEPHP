<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录注册</title>
<link type="text/css" rel="stylesheet" href="/Static/default/css/register.css" />
</head>
<body class="unlog">
<div id="page">
  <div class="wraper wraper800">
    <div class="header_nologin clearfix">
      <div class="logobox fl">
        <a href="{$smarty.const.HOST}"><img src="/Static/images/logo3.png"></a>
      </div>
      <div class="rbox"><span>已有快推网帐号？</span>
        <a class="btn btn-primary" href="/login.html">马上登录</a>
      </div>
    </div>
    <div class="inner inner_nologin clearfix">
      <div class="login_tip">亲，填写信息30秒快速完成注册，也可以使用第三方帐号更快捷的注册登录哦！</div>
      <form method="post" name="form1" id="form1" action="">
        <ul class="sign_box fl">
          <li>
            <label class="labeltit">帐户昵称</label>
            <input type="text" placeholder="帐户昵称" id="uname" name="uname" />      
            <span id="unameTip"></span>
          </li>
          <li>
            <label class="labeltit">填写邮箱</label>
            <input type="text" placeholder="常用邮箱" id="email" name="email" />      
            <span id="emailTip"></span>
          </li>
          <li>
            <label class="labeltit">填写密码</label>
            <input type="password" placeholder="至少6个字符的字母与数字组合" id="p" name="p" />      
            <span id="password1Tip"></span>
          </li>
          <li>
            <label class="labeltit">重复填写密码</label>
            <input type="password" placeholder="重复填写密码" id="rep" name="rep" />      
            <span id="password2Tip"></span>
          </li>
          <li>
            <a class="btn btn-success" href="javascript:void(0);" onclick="return sign()">确认注册</a>
            <span>
            已有快推网帐号？
            <a class="linkblue" href="/login.html">立即登录</a>
          </span>
        </li>
      </ul>
      </form>
      <ul class="social_box fr">
        <li>
          <a href="/login/sina"><i class="icon ico_sina"></i></a>
        </li>
        <li>
          <a href="/login/qq"><i class="icon ico_qq"></i></a>
        </li>
         <li>
          <a href="/login/taobao"><i class="icon ico_taobao"></i></a>
        </li>
      </ul>
    </div>
  </div>
</div>
  <script type="text/javascript" src="/Static/default/js/jquery.js"></script>
  <script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey={$smarty.const.TB_APP_KEY}"></script>
{literal}
  <script type="text/javascript">
       function $id(id){
          return document.getElementById(id);
        }
        function jsonp(url,data,title,f){
          $.ajax({
            'url':url,
            'data':data,
            'type':'POST',
            'dataType':'jsonp',
            'jsonp':'jsonpcallback',
            'success':function(res){
              f(res,title);
            }
          });
        }
        function tip(span,text){
          span.removeClass('ok error').addClass('tip').text(text);
        };
        function ok(span,text){
          span.removeClass('tip error').addClass('ok').text(text);
        };
        function error(span,text){
          span.removeClass('tip ok').addClass('error').text(text);
        }
        var existuname=1;
        var existemail=1;
        var guname='';
        var gemail='';
        var prep=0;
        $id('uname').onblur=function(){
          existuname=1;
          var uname=this.value;
          var span=$(this).siblings('span');
          if(!uname || typeof(uname)=='undefined'){
            tip(span,'');
            return;
          }
          if(!/.{2,}/.test(uname)){
            tip(span,'');
            return;
          }
          var f=function(data){
            switch(data.ret){
              case 1:ok(span,'');existuname=0;break;
              case 0:tip(span,'来晚了,被人注册了');break;
              case -1:tip(span,'');break;
              case -2:error(span,'');break;
            }
          }
          if(guname==uname){
            return;
          }
          guname=uname;
          jsonp('/register/uniqueName.html',{'u':uname},'',f);
        };
        $id('p').onblur=function(){
          prep=0;
          var pwd1=this.value;
          var span=$(this).siblings('span');
          if(!pwd1 || typeof(pwd1)=='undefined'){
            tip(span,'');
            return;
          }
          if(pwd1.length<6){
            tip(span,'密码要大于6位');
            return;
          }
          var pwd2=$id('rep').value;
          if(pwd2.length>1 && pwd1!==pwd2){
            $('#rep').siblings('span').removeClass('tip ok').addClass('error');
          }else if(pwd2.length>1 && pwd1===pwd2){
            $('#rep').siblings('span').removeClass('tip error').addClass('ok');
            prep=1;
          }

          ok(span,'');
        };
        $id('rep').onblur=function(){
          prep=0;
          var pwd2=this.value;
          var pwd1=$id('p').value;
          var span=$(this).siblings('span');
          if(!pwd2 || typeof(pwd2)=='undefined'){
            tip(span,'');
            return;
          }
          if(pwd1!==pwd2){
            error(span,'');
            prep=0;
            return;
          }
          prep=1;
          ok(span,'');
        };
        $id('email').onblur=function(){
          existemail=1;
          var email=this.value;
          var span=$(this).siblings('span');
          if(!email || typeof(email)=='undefined'){
            tip(span,'');
            return;
          }
          if(!/\w+@\w+\.\w+/.test(email)){
            error(span,'');
            return;
          }
          var f=function(data){
            switch(data.ret){
              case 1:ok(span,'');existemail=0;break;
              case 0:tip(span,'邮箱已经注册过,如有疑问请联系管理员');$('#email').attr('title','errro');break;
              case -1:tip(span,'');break;
              case -2:error(span,'');break;
            }
          }
          if(email==gemail){
            return;
          }
          gemail=email;
          jsonp('/register/uniqueEmail.html',{'e':email},'',f);
        };
      function sign(jump,callback){
        
        var cf=function(res){
          switch(res.ret){
            case 1:document.location.href="/guide/follow.html";
                break;
            case -1:$id('uname').focus();$('#uname').siblings('span').removeClass('tip ok').addClass('error');break;

            case -2:$id('email').focus();$('#email').siblings('span').removeClass('tip ok').addClass('error');break;

            case -3:$id('rep').focus();$('#rep').siblings('span').removeClass('tip ok').addClass('error');break;

          }
          
        };
        var uname=$id('uname').value;
        var pwd1=$id('p').value;
        var pwd2=$id('rep').value;
        var email=$id('email').value;
          if(existuname){
            $id('uname').focus();
            return false;
          }
           if(existemail){
            $id('email').focus();
            return false;
          }
          if(!prep){
            $id('rep').focus();
            return false;
          }
          var data={'u':uname,'p':pwd1,'rep':pwd2,'e':email};
          jsonp('/registering.html',data,'',cf);
          return false;
        }
        TOP.ui("login-btn", {
            container: "#taobao-login", 
            type: "2,4",
            callback:{
              login: function(user){
                userinfo=TOP.auth. getUser(); 
                var tbuid=userinfo.id,nick=userinfo.nick;
                get('/login/taobao/',{tbuid:tbuid,nick:nick},'',function(res){
                  if(res.ret==0) document.location.href="/register/open.html";
                  else if(res.ret==1) document.location.href='/';
                  else tips('发生错误,请重试');
                })
              },
              logout: function(){}
            }
        });
  </script>
{/literal}
</body>
</html>
