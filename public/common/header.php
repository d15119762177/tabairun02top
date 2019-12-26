<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <link rel="stylesheet" href="/static/css/bootstrap.min.css">
  <link rel="icon" href="/static/assets/images/favicon.png" type="image/png">
  <title>Home</title>

    <!--Begin  Page Level  CSS -->
    <link href="/static/assets/plugins/morris-chart/morris.css" rel="stylesheet">
    <link href="/static/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
     <!--End  Page Level  CSS -->
    <link href="/static/assets/css/icons.css" rel="stylesheet">
    <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/assets/css/style.css" rel="stylesheet">
    <link href="/static/assets/css/responsive.css" rel="stylesheet">
   <!--  <script type="text/javascript" src="/static/assets/css/jquery-3.3.1.min.js"></script> -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
    <![endif]-->
<style>
    #tag{
      margin-top:0px;

    }
    #tag font{
      margin:0px 5px 0px 5px;
      display:inline-block;
      width:60px;
      height: 30px;
      text-align: center;
      line-height: 30px;
      color: black;
      background-color: #eee;
      overflow: hidden;
    }
</style>
</head>
<script src="/static/layui/layui.js"></script>
<body class="sticky-header left-side-collapsed">


    <!--Start left side Menu-->
    <div class="left-side sticky-left-side">

        <!--logo-->
        <div class="logo">
            <a href="index.html"><img src="/static/assets/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="/static/assets/images/logo-icon.png" alt=""></a>
        </div>
        <!--logo-->

        <div class="left-side-inner">
            <!--Sidebar nav-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="menu-list"><a href="{:url('Index/index')}"><i class="icon-layers"></i> <span>广告组</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{:url('Index/index')}"> Buttons</a></li>
                        <li><a href="{:url('Index/index')}"> Panels</a></li>
                    </ul>
                </li>
                
                <li class="menu-list"><a href="{:url('Plan/index')}"><i class="icon-grid"></i> <span>广告计划</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{:url('Plan/index')}"> Basic Table</a></li>
                        <li><a href="{:url('Plan/index')}">Responsive Table</a></li>
                    </ul>
                </li>

                <li class="menu-list"><a href="{:url('Ideas/index')}"><i class="icon-envelope-open"></i> <span>广告创意</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{:url('Ideas/index')}"> Inbox</a></li>
                        <li><a href="{:url('Ideas/index')}"> Compose Mail</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="{:url('Ideas/index')}"><i class="icon-envelope-open"></i> <span>Excel批量上传</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{:url('Batch/index')}"> 批量创建广告组</a></li>
                        <li><a href="{:url('Batch/plan_up')}"> 批量创建广告计划</a></li>
                        <li><a href="{:url('Batch/ideas_up')}"> 批量创建广告创意</a></li>
                    </ul>
                </li>
            </ul>
            <!--End sidebar nav-->

        </div>
    </div>
    <!--End left side menu-->
    
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <a class="toggle-btn"><i class="fa fa-bars"></i></a>

            <form class="searchform">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form>

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-tasks"></i>
                            <span class="badge">8</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                            <h5 class="title">You have 8 pending task</h5>
                            <ul class="dropdown-list">
                            <li class="notification-scroll-list notification-list ">
                               <!-- list item-->
                               <a href="javascript:void(0);" class="list-group-item">
                                  <div class="media">
                                     <div class="pull-left p-r-10">
                                        <em class="fa  fa-shopping-cart noti-primary"></em>
                                     </div>
                                     <div class="media-body">
                                        <h5 class="media-heading">A new order has been placed.</h5>
                                        <p class="m-0">
                                            <small>29 min ago</small>
                                        </p>
                                     </div>
                                  </div>
                               </a>
                    
                               <!-- list item-->
                               <a href="javascript:void(0);" class="list-group-item">
                                  <div class="media">
                                     <div class="pull-left p-r-10">
                                        <em class="fa fa-check noti-success"></em>
                                     </div>
                                     <div class="media-body">
                                        <h5 class="media-heading">Databse backup is complete</h5>
                                        <p class="m-0">
                                            <small>12 min ago</small>
                                        </p>
                                     </div>
                                  </div>
                               </a>
                    
                               <!-- list item-->
                               <a href="javascript:void(0);" class="list-group-item">
                                  <div class="media">
                                     <div class="pull-left p-r-10">
                                        <em class="fa fa-user-plus noti-info"></em>
                                     </div>
                                     <div class="media-body">
                                        <h5 class="media-heading">New user registered</h5>
                                        <p class="m-0">
                                             <small>17 min ago</small>
                                        </p>
                                     </div>
                                  </div>
                               </a>
                    
                                <!-- list item-->
                               <a href="javascript:void(0);" class="list-group-item">
                                  <div class="media">
                                     <div class="pull-left p-r-10">
                                        <em class="fa fa-diamond noti-danger"></em>
                                     </div>
                                     <div class="media-body">
                                        <h5 class="media-heading">Database error.</h5>
                                        <p class="m-0">
                                             <small>11 min ago</small>
                                        </p>
                                     </div>
                                  </div>
                               </a>
                    
                               <!-- list item-->
                               <a href="javascript:void(0);" class="list-group-item">
                                  <div class="media">
                                     <div class="pull-left p-r-10">
                                        <em class="fa fa-cog noti-warning"></em>
                                     </div>
                                     <div class="media-body">
                                        <h5 class="media-heading">New settings</h5>
                                        <p class="m-0">
                                             <small>18 min ago</small>
                                        </p>
                                     </div>
                                  </div>
                               </a>
                             </li>
                             <li class="last"> <a href="#">View all notifications</a> </li>
              </ul>
                        </div>
                    </li>
                    
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                         <h5 class="title">Notifications</h5>
                        <ul class="dropdown-list normal-list">
             <li class="message-list message-scroll-list">
                          <a href="#">
                              <span class="photo"> <img src="/static/assets/images/users/avatar-8.jpg" class="img-circle" alt="img"></span>
                              <span class="subject">John Doe</span>
                              <span class="message"> New tasks needs to be done</span>
                               <span class="time">15 minutes ago</span>
                          </a>
                          
                          <a href="#">
                              <span class="photo"> <img src="/static/assets/images/users/avatar-7.jpg" class="img-circle" alt="img"></span>
                              <span class="subject">John Doe</span>
                              <span class="message"> New tasks needs to be done</span>
                               <span class="time">10 minutes ago</span>
                          </a>
                        
                          <a href="#">
                              <span class="photo"> <img src="/static/assets/images/users/avatar-6.jpg" class="img-circle" alt="img"></span>
                               <span class="subject">John Doe</span>
                               <span class="message"> New tasks needs to be done</span>
                              <span class="time">20 minutes ago</span>
                          </a>
                         
                          <a href="#">
                              <span class="photo"> <img src="/static/assets/images/users/avatar-6.jpg" class="img-circle" alt="img"></span>
                               <span class="subject">John Doe</span>
                               <span class="message"> New tasks needs to be done</span>
                              <span class="time">20 minutes ago</span>
                          </a>
                        
                          <a href="#">
                              <span class="photo"> <img src="/static/assets/images/users/avatar-6.jpg" class="img-circle" alt="img"></span>
                               <span class="subject">John Doe</span>
                               <span class="message"> New tasks needs to be done</span>
                              <span class="time">20 minutes ago</span>
                          </a>
                          
                          <a href="#">
                              <span class="photo"> <img src="/static/assets/images/users/avatar-6.jpg" class="img-circle" alt="img"></span>
                               <span class="subject">John Doe</span>
                               <span class="message"> New tasks needs to be done</span>
                              <span class="time">20 minutes ago</span>
                          </a>
            </li>
            <li class="last"> <a  href="#">All Messages</a> </li>
          </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="/static/assets/images/users/avatar-6.jpg" alt="" />
                            {$Request.cookie.advertiser_id}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                          <li> <a href="#"> <i class="fa fa-wrench"></i> {$Request.cookie.advertiser_id} </a> </li>
                          <!-- <li> <a href="#"> <i class="fa fa-user"></i> Profile </a> </li>
                          <li> <a href="#"> <i class="fa fa-info"></i> Help </a> </li> -->
                          <li> <a href="{:url('index/exit')}"> <i class="fa fa-lock"></i> Logout </a> </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->
        <!--body wrapper start-->
        <div class="wrapper">

        <!-- <a href="{:url('Index/add')}" class="layui-btn" style="margin-left:15px;">创建广告组</a>
        <a href="{:url('Plan/add')}" class="layui-btn" style="margin-left:15px;">创建广告计划</a>
        <a href="{:url('Ideas/add')}" class="layui-btn" style="margin-left:15px;">创建广告创意</a> -->