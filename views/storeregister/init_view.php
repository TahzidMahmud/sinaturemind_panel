<body class="account-body accountbg">

<!-- Log In page -->
<div class="container">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-0 auth-header-box">
                            <div class="text-center p-3">
                                <a href="index.html" class="logo logo-admin">
                                    <img src="./theme/assets/images/NB-200.png" height="50" alt="logo" class="auth-logo">
                                </a>
                                <h4 class="mt-3 mb-1 font-weight-semibold text-white font-18">Let's Get Start with Nagbak</h4>   
                                <p class="text-muted  mb-0">Rgister your account.</p>  
                            </div>
                        </div>
                        <div class="card-body p-0">
                                
                                <div class="col px-3 pt-3">
                                <form class="form-horizontal auth-form" id="frmregister" >
                                <div class="row">
                                
                                        <div class="col">
                                       
                                            
                                                <div class="form-group mb-2">
                                                    <label for="username">Name </label>
                                                    <div class="input-group">                                                                            
                                                        <input type="text" class="form-control form-control-sm" name="name" id="name" required
                                                        data-parsley-minlength="5" placeholder="Min 5 chars.">
                                                    </div>                                    
                                                </div><!--end form-group--> 
                                                
                                                <div class="form-group mb-2">
                                                    <label for="username">Mobile </label>
                                                    <div class="input-group">                                                                                         
                                                        <input type="text" class="form-control form-control-sm" name="mobile" id="mobile" required
                                                        data-parsley-minlength="11" placeholder="Min 11 chars.">
                                                    </div>                                    
                                                </div>
                                            
                                                <div class="form-group mb-2">
                                                    <label for="userpassword">Password</label>                                            
                                                    <div class="input-group">                                  
                                                        <input type="password" class="form-control form-control-sm" name="xpassword" id="xpassword" placeholder="Enter password">
                                                    </div>                               
                                                </div><!--end form-group--> 
            
                                                <div class="form-group row my-3">
                                                <div class="col-sm-12">
                                                    
                                                </div><!--end col-->                                             
                                            </div><!--end form-group--> 
                                           
                                            <hr>
                                       
                                        
                                        </div>

                                         <div class="col">
                                       
                                            
                                                
                                                <div class="form-group mb-2">
                                                    <label for="useremail">Email</label>
                                                    <div class="input-group">                                                                                         
                                                    <input type="email" id="xemail" name="xemail" class="form-control form-control-sm" required
                                                            parsley-type="email" placeholder="E-mail"/>
                                                    </div>                                    
                                                </div><!--end form-group-->
                                            
                                            
                                        
                                            <div class="form-group mb-2">
                                                <label for="username">Address</label>
                                                    
                                                <input type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Enter Confirm Password">
                                                    
                                                </div>
                                                <div class="form-group mb-2 ml-2">
                                                    <label for="conf_password">Confirm Password</label>                                            
                                                    <div class="input-group">                                   
                                                        <input type="password" class="form-control form-control-sm" name="confirmpassword" id="confirmpassword" placeholder="Enter Confirm Password">
                                                    </div>
                                                </div><!--end form-group-->
                                            
                                            <div class="form-group row my-3">
                                                <div class="col-sm-12">
                                                    <div class="custom-control custom-switch switch-success">
                                                        <input type="checkbox" class="custom-control-input" checked id="isagree" name="isagree">
                                                        <label class="custom-control-label text-muted" for="isagree">You agree to the Nagbak <a  href="<?php echo URL;?>?page=nagbakpages&action=storetc" class="text-primary">Terms of Service</a></label>
                                                        
                                                    </div>
                                                </div><!--end col-->                                             
                                            </div><!--end form-group--> 
                                            
                                            <div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <input type="hidden" value="<?php echo $this->token;?>"  name="apikey" id="apikey">
                                                    <input type="hidden" value="<?php echo URL;?>"  name="callbackurl" id="callbackurl">
                                                    
                                                </div><!--end col--> 
                                            </div> <!--end form-group--> 

                                       
                                        
                                    </div>
                               
                                </div>
                                </form><!--end form-->
                                <button class="btn btn-primary btn-block waves-effect waves-light" id="register" >
                                                        <span id="" class="mr-2" role="status" aria-hidden="true"></span> 
                                                        Register <i class="fas fa-sign-in-alt ml-1"></i>
                                                    </button>
                                </div>
                        </div><!--end card-body-->
                        <div class="card-body bg-light-alt text-center">
                            <span class="text-muted d-none d-sm-inline-block">DOT BD SOLUTIONS © 2021</span>                                            
                        </div>
                        
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->
<!-- End Log In page -->


