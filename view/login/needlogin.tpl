<!DOCTYPE html>
<html>
  <head>
    <title>{$pageTitle}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/Static/default/css/register.css" />
</head>
<body class="unlog">

<div class="callout" id="login_popupdiv">
  <div class="call_login clearfix">
    <div class="login_tip">亲，你可以用{$smarty.const.SITE_NAME}帐号登录，也可以使用第三方帐号直接登录哦！</div>
    <ul class="login_box fl">
      <li>
        <label class="labeltit">登录昵称</label>
        <input type="text" placeholder="请填写昵称" id="uname" name="u">
        <span class=""></span>
      </li>
      <li>
        <label class="labeltit">登录密码</label>
        <input type="password" placeholder="填写登录密码" id="password" name="p">
        <span class=""></span>
      </li>
      <li>
        <input type="button" id="loginbtn" onclick="logining();return false;" class="btn btn-success" value="登 录" />
        <a class="linkblue" href="#">忘记密码？</a>
        <a class="linkblue" href="javascript:void(0);" onclick="goRegister()" id="registerbtn">注册帐户？</a>
      </li>
    </ul>
    <ul class="social_box fr">
      <li>
        <a href="/login/sina"> <i class="icon ico_sina"></i>
        </a>
      </li>
      <li>
        <a href="/login/qq"> <i class="icon ico_qq"></i>
        </a>
      </li>
       <li>
        <a href="/login/taobao"> <i class="icon ico_taobao"></i>
        </a>
      </li>
    </ul>
    <script type="text/javascript" src="/Static/default/js/jquery.js"></script>
    <script type="text/javascript" src="/Static/default/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/Static/default/js/common.js"></script>
    <script type="text/javascript" src="/Static/box/js/share.js"></script>
    <script type="text/javascript" src="/Static/artDialog/artDialog.js"></script>
    <script type="text/javascript" src="/Static/artDialog/plugins/iframeTools.js"></script>
    {literal}
      <SCRIPT TYPE="text/javascript">
         function sucess(res){
            switch(res.ret){
              case 1:parent.quickLoginOk();if(typeof(callback)=='function') callback();break;
              
              case -1:$id('uname').focus();break;

              case -2:$id('password').focus();break;

              case -3:$id('uname').focus();break;

              case -4:$id('password').focus();break;
            }
            
          };
          function logining(){
             var uname=iv('uname');
              var password=iv('password');
              if(!uname || typeof(uname)=='undefined'){
                $id('uname').focus();
                return;
              }
              if(!password || typeof(password)=='undefined'){
                $id('password').focus();
                return;
              }
              var data={'u':uname,'p':password};
              jsonp('/logining.html',data,'',sucess);
              return false;
          }

      </SCRIPT>
    {/literal}
</div>
</div>
</body>
</html>
