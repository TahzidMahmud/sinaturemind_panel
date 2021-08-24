<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Nagbak - Connecting businesses</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="./theme/assets/images/NB-200.png">
        <link href="./theme/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
        <link href="./theme/plugins/animate/animate.css" rel="stylesheet" type="text/css">
        <!-- App css -->
        <link href="./theme/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="./theme/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="./theme/assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
        <link href="./theme/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="./theme/assets/css/app.min.css" rel="stylesheet" type="text/css" />
       

        <?php if(count($this->pagecss)>0){ 
            foreach($this->pagecss as $css){
            ?>
            <link href="<?php echo $css?>" rel="stylesheet" type="text/css" />
        <?php } 
        } ?>

    </head>
    <body>

<!-- Log In page -->
<div class="left-sidenav">
            <!-- LOGO -->
            <div class="brand">
                <a href="sales-index.html" class="logo">
                    <span>
                        <img src="./theme/assets/images/NB-200.png" alt="logo-small" class="logo-sm">
                    </span>
                    <span class="text-warning">
                        <strong>NAGBAK</strong>
                    </span>
                </a>
            </div>
            <!--end logo-->
            <div class="menu-content h-100" data-simplebar>
                <ul class="metismenu left-sidenav-menu">
                    <?php 
                    if(file_exists("./web_info/menu.json")){
                        $mainmenu = json_decode(file_get_contents("./web_info/menu.json"), true);
                        foreach($mainmenu as $key=>$value){
                            if($value['type']=='section'){ ?>
                        <li class="menu-label mt-0"><?php echo $key?></li>
                        <?php }else if($value['type']=='nosub'){ ?>
                            <li>
                    
                                <a href="<?php echo URL;?>?page=<?php echo $value['page'];?>&action=<?php echo $value['method'];?>"> <i data-feather="<?php echo $value['icon'];?>" class="align-self-center menu-icon"></i><span><?php echo $key?></span></a>
                                
                            </li>
                          <?php  }else if($value['type']=='hassub'){ ?>

                            <li>
                                <a href="javascript: void(0);"><i data-feather="<?php echo $value['icon'];?>" class="align-self-center menu-icon"></i><span><?php echo $key;?></span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <?php foreach($value['submenu'] as $k=>$v){ ?>
                                        <li class="nav-item"><a class="nav-link" id="<?php echo $v['page'];?>" href="<?php echo URL;?>?page=<?php echo $v['page'];?>&action=<?php echo $v['method'];?>"><i class="ti-control-record"></i><?php echo $v['menu'];?></a></li>
                                    <?php }?>
                                </ul>
                            </li> 
                          <?php  
                            }else{
                                echo "menu not set properly!";
                            }
                        }
                    }else{
                        echo "menu not not fund!";
                    }
                        
                    ?>
                    
                    
    
                    
                        
                </ul>
                    
                
            </div>
        </div>
        <!-- end left-sidenav-->
        
        <div class="page-wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">            
                <!-- Navbar -->
                <nav class="navbar-custom">    
                    <ul class="list-unstyled topbar-nav float-right mb-0">  
                        <li class="dropdown hide-phone">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-feather="search" class="topbar-icon"></i>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right dropdown-lg p-0">
                                <!-- Top Search Bar -->
                                <div class="app-search-topbar">
                                    <form action="#" method="get">
                                        <input type="search" name="search" class="from-control top-search mb-0" placeholder="Type text...">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </li>                      

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-feather="bell" class="align-self-center topbar-icon"></i>
                                <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">
                            
                                <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    Notifications <span class="badge badge-primary badge-pill">2</span>
                                </h6> 
                                <div class="notification-menu" data-simplebar>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2">2 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <i data-feather="shopping-cart" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2">10 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <img src="assets/images/users/user-4.jpg" alt="" class="thumb-sm rounded-circle">
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <h6 class="my-0 font-weight-normal text-dark">Meeting with designers</h6>
                                                <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2">40 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">                                                    
                                                <i data-feather="users" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <h6 class="my-0 font-weight-normal text-dark">UX 3 Task complete.</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2">1 hr ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <img src="assets/images/users/user-5.jpg" class="thumb-sm rounded-circle"  alt="" >
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                                <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-right text-muted pl-2">2 hrs ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <i data-feather="check-circle" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ml-2 text-truncate">
                                                <h6 class="my-0 font-weight-normal text-dark">Payment Successfull</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                </div>
                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                                    View all <i class="fi-arrow-right"></i>
                                </a>
                            </div>
                        </li>

                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <span class="ml-1 nav-user-name hidden-sm"><?php echo Session::get('sfullname');?></span>
                                <?php if(Session::get('image')){?>
                                <img src="<?php echo USER_IMAGE_LOCATION.Session::get('image') ?>" alt="profile-user" class="rounded-circle thumb-lg" />  
                                <?php }else{ ?>
                                <img src="./theme/assets/images/users/user-5.jpg" alt="profile-user" class="rounded-circle thumb-lg" />   
                                <?php }?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo URL;?>?page=profile&action=init"><i data-feather="user" class="align-self-center icon-xs icon-dual mr-1"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings" class="align-self-center icon-xs icon-dual mr-1"></i> Settings</a>
                                <div class="dropdown-divider mb-0"></div>
                                <a class="dropdown-item" href="<?php echo URL?>?page=login&action=logout"><i data-feather="power" class="align-self-center icon-xs icon-dual mr-1"></i> Logout</a>
                            </div>
                        </li>
                    </ul><!--end topbar-nav-->
        
                    <ul class="list-unstyled topbar-nav mb-0">                        
                        <li>
                            <button class="nav-link button-menu-mobile">
                                <i data-feather="menu" class="align-self-center topbar-icon"></i>
                            </button>
                        </li> 
                        <li class="creat-btn">
                            <div class="nav-link">
                                <a class=" btn btn-sm btn-soft-primary" href="#" role="button"><i class="fas fa-plus mr-2"></i>New Task</a>
                            </div>                                
                        </li>                           
                    </ul>
                </nav>
                <!-- end navbar-->
            </div>
            <!-- Top Bar End -->

            <!-- Page Content-->
            <div class="page-content">