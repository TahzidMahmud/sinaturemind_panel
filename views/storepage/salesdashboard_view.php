<div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="page-title">Sales</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dastone</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div><!--end col-->
                                    <div class="col-auto align-self-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                            <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                            <span class="" id="Select_date">Jan 11</span>
                                            <i data-feather="calendar" class="align-self-center icon-xs ml-1"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i data-feather="download" class="align-self-center icon-xs"></i>
                                        </a>
                                    </div><!--end col-->  
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Revenu Status</h4>                      
                                        </div><!--end col-->
                                        <div class="col-auto"> 
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                   This Month<i class="las la-angle-down ml-1"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Today</a>
                                                    <a class="dropdown-item" href="#">Last Week</a>
                                                    <a class="dropdown-item" href="#">Last Month</a>
                                                    <a class="dropdown-item" href="#">This Year</a>
                                                </div>
                                            </div>               
                                        </div><!--end col-->
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body"> 
                                    <div class="">
                                        <div id="Revenu_Status" class="apex-charts"></div>
                                    </div>                                                                                                                          
                                </div><!--end card-body--> 
                            </div><!--end card-->  
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl"> 
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col text-center">  
                                                <h6 class="text-uppercase text-muted mt-2 m-0">Orders Placed</h6>                
                                                    <span class="h4"><?php echo $this->totalordr ;?></span>      
                                                              
                                                </div><!--end col-->
                                            </div> <!-- end row -->
                                        </div><!--end card-body-->
                                    </div> <!--end card-body-->                     
                                </div><!--end col-->
                                <div class="col-12 col-lg-6 col-xl"> 
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col text-center">  
                                                <h6 class="text-uppercase text-muted mt-2 m-0">Delivered</h6> 
                                                    <span class="h4"><?php echo $this->delord ;?></span>      
                                                </div><!--end col-->
                                            </div> <!-- end row -->
                                        </div><!--end card-body-->
                                    </div> <!--end card-body-->                     
                                </div><!--end col-->
                                <div class="col-12 col-lg-6 col-xl"> 
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col text-center">             
                                                <h6 class="text-uppercase text-muted mt-2 m-0">Processing</h6>                

                                                    <span class="h4"><?php echo $this->ordproc ;?></span>      
                                                </div><!--end col-->
                                            </div> <!-- end row -->
                                        </div><!--end card-body-->
                                    </div> <!--end card-body-->                     
                                </div><!--end col-->
                                <div class="col-12 col-lg-6 col-xl"> 
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col text-center">
                                                <h6 class="text-uppercase text-muted mt-2 m-0">Pending</h6>                

                                                    <span class="h4"><?php echo $this->ordpen ;?></span>      
                                                </div><!--end col-->
                                            </div> <!-- end row -->
                                        </div><!--end card-body-->
                                    </div> <!--end card-->                     
                                </div><!--end col-->                                
                            </div><!--end row--> 
                        </div><!-- end col--> 

                        <div class="col-lg-3">
                        <h5 class="text-center"><b>Total Sales</b></h5><hr>
                            <div class="card"> 
                                <div class="card-body">                                    
                                    <div class="row">
                                        <div class="col">
                                            <div class="media">
                                                <img src="assets/images/money-beg.png" alt="" class="align-self-center" height="40">
                                                <div class="media-body align-self-center ml-3"> 
                                                <p class="text-muted mb-0">Total Order Amount</p>  
                                                    <h6 class="m-0 font-20"><?php echo $this->total ;?>৳</h6>
                                                                                                                                                                                                 
                                                </div>
                                            </div>
                                        </div>< 
                                        <!-- <div class="col-auto align-self-center">
                                            <p class="mb-0"><span class="text-success"><i class="mdi mdi-trending-up"></i>4.8%</span> Then Last Month</p>
                                        </div>                                      -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="apexchart-wrapper">
                                            <div id="dash_spark_1" class="chart-gutters"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card"> 
                                <div class="card-body">                                    
                                    <div class="row">
                                        <div class="col">
                                            <div class="media">
                                                <img src="assets/images/money-beg.png" alt="" class="align-self-center" height="40">
                                                <div class="media-body align-self-center ml-3"> 
                                                <p class="text-muted mb-0">Total Received</p>  
                                                    <h6 class="text-primary m-0 font-20"><?php echo $this->trecev ;?>৳</h6>
                                                                                                    
                                                </div>
                                            </div>
                                        </div>< 
                                        <!-- <div class="col-auto align-self-center">
                                            <p class="mb-0"><span class="text-success"><i class="mdi mdi-trending-up"></i>4.8%</span> Then Last Month</p>
                                        </div>                                      -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="apexchart-wrapper">
                                            <div id="dash_spark_1" class="chart-gutters"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card"> 
                                <div class="card-body">                                    
                                    <div class="row">
                                        <div class="col">
                                            <div class="media">
                                                <img src="assets/images/money-beg.png" alt="" class="align-self-center" height="40">
                                                <div class="media-body align-self-center ml-3"> 
                                                <p class="text-muted mb-0">Total Due</p>  
                                                    <h6 class="text-danger m-0 font-20"><?php echo ($this->total - $this->trecev) ;?>৳</h6>
                                                                                                    
                                                </div>
                                            </div>
                                        </div>< 
                                        <!-- <div class="col-auto align-self-center">
                                            <p class="mb-0"><span class="text-success"><i class="mdi mdi-trending-up"></i>4.8%</span> Then Last Month</p>
                                        </div>                                      -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="apexchart-wrapper">
                                            <div id="dash_spark_1" class="chart-gutters"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!--end card-->   
                        </div><!-- end col-->                                                          
                    </div><!--end row-->
                    
                   <!--end row-->
                    
                </div><!-- container -->