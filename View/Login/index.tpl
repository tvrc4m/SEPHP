<!DOCTYPE html>
<html>
<head>

<title>{$pageTitle}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="/Static/default/css/register.css" />
</head>
<body class="unlog">
<div id="page">
  <div class="wraper wraper800">
   <div class="header_nologin clearfix">
      <div class="logobox fl">
        <a href="{$smarty.const.HOST}"><img src="/Static/images/logo3.png" /></a>
      </div>
      <div class="rbox"><span>还没帐号？</span>
        <a class="btn" href="/register.html">注册帐号</a>
      </div>
    </div>
    <div class="inner inner_nologin clearfix">
      <div class="login_tip">亲，你可以用本地帐号登录，也可以使用第三方帐号直接登录哦！</div>
      <form action="{$smarty.const.HOST}/login/local" method="POST">
        <input type="hidden" name="furl" value="{$furl}" />
        <ul class="login_box fl">
          <li>
            <label class="labeltit">帐户昵称</label>
            <input style="display:inline-block" type="text" placeholder="帐户昵称" name="u" id="uname" value="{$uname}" />
            <span>{$nmsg}</span>
          </li>
          <li>
            <label class="labeltit">登录密码</label>
            <input style="display:inline-block" type="password" placeholder="登录密码" name="p" id="pwd" />
            <span >{$pmsg}</span>    
          </li>
          <li>
            <input class="btn btn-success" type="submit" value="登 录" onclick="return login()" />
            <a class="linkblue" href="#">忘记密码？</a>
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
      </ul>
    </div>
     <script type="text/javascript" src="/Static/default/js/jquery.js"></script>
	   {literal}
      <script type="text/javascript">
        function $id(id){
          return document.getElementById(id);
        }
        function login(jump,callback){
          var uname=$id('uname').value;
          var password=$id('pwd').value;
          if(!uname || typeof(uname)=='undefined'){
            $id('uname').focus();
            return false;
          }
          if(!password || typeof(password)=='undefined'){
            $id('pwd').focus();
            return false;
          }
          return true;
        }

      </script>
     {/literal}
  </div>
</div>
</body>
</html>
