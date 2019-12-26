<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/static/assets/images/favicon.png" type="image/png">
  <title></title>
   <link href="/static/assets/css/icons.css" rel="stylesheet">
    <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/assets/css/style.css" rel="stylesheet">
    <link href="/static/assets/css/responsive.css" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body class="sticky-header">

 
 <!--Start login Section-->
  <section class="login-section">
       <div class="container">
           <div class="row">
               <div class="login-wrapper">
                   <div class="login-inner">
                       
                       <div class="logo">
                         <img src="/static/assets/images/logo-dark.png"  alt="logo"/>
                       </div>
                   		
                   		<h2 class="header-title text-center" style="font-size: 20px;">登 录</h2>
                        
                       <form action="{:url('dologin')}" method="POST">
                           <div class="form-group">
                               <input type="text" class="form-control"  placeholder="用户名" >
                           </div>
                           
                           <div class="form-group">
                               <input type="text" class="form-control"  placeholder="密码" >
                           </div>

						<div class="form-group">
                           <div class="pull-left">
                            <div class="checkbox primary">
                              <input  id="checkbox-2" type="checkbox">
                              <label for="checkbox-2">记住密码</label>
                            </div>
                           </div>
                           
                           <div class="pull-right">
                           	   <a href="reset-password.html" class="a-link">
                               <i class="fa fa-unlock-alt"></i> 忘记密码?
                               </a>
                           </div>
                         </div>
                          
                           <div class="form-group">
                               <input type="submit" value="登 录" class="btn btn-primary btn-block" >
                           </div>
                           
                           <div class="form-group text-center">
                            没有账号?  <a href="registration.html">注 册</a>
                           </div>
                           
                       </form>
                       
                        <div class="copy-text"> 
                         <p class="m-0">2019 &copy;  admin</p>
                        </div>
                    
                   </div>
               </div>
               
           </div>
       </div>
  </section>
 <!--End login Section-->




    <!--Begin core plugin -->
    <script src="/static/assets/js/jquery.min.js"></script>
    <script src="/static/assets/js/bootstrap.min.js"></script>
    <!-- End core plugin -->

</body>

</html>

