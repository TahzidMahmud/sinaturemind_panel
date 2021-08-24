<div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                           
                                <div class="row">
                                
                                    <div class="col">
                                        <h4 class="page-title">Item Database</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">App Settings</a></li>
                                            <li class="breadcrumb-item active">Add Item</li>
                                        </ol>
                                    </div><!--end col-->
                                            
                                </div><!--end row-->                                                              
                            </div><!--end page-title-box-->
                        </div><!--end col-->
                    </div><!--end row-->
                    <!-- end page title end breadcrumb -->
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Create Item</h4>                      
                                        </div><!--end col-->
                                        
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body"> 
                                <h5>Search By Selecting Category and Sub-category</h5>
                                    <!-- <form id="itemform"> -->
                                <div class="row ">
                                
                                <div class="col-md-3">
                                    <div class="">
                                            <label for="skucode" class="col-sm-4 col-form-label text-left">Category</label>
                                            <div class="">
                                                <select class="form-control form-control-sm" id="fcat" name="fcat">
                                                    <option value="">Select Category</option>
                                                        <?php foreach($this->allcategories as $cat){?>
                                                        <option value="<?php echo $cat['xcatsl']?>"><?php echo $cat['xcat']?>
                                                        </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="">
                                            <label for="skucode" class="col-form-label text-left">Sub-Category</label>
                                            <div class="">
                                                <select class="form-control form-control-sm" id="fsubcat" name="subcat">
                                                    <option value="">Select Sub-Category</option>
                                                      
                                                </select>
                                            </div>
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="row">
                                    <div class="col-md-2"></div>

                                        <label for="">Search For Selecting Category and Sub-category</label><br>
                                        
                                    </div>
                                   <div class="">
                                    <div class="row">
                                    <div class="col-md-2"></div>
                                        <input required class="" id="searchfilter" style="width:20rem; background-color: #fff;background-clip: padding-box;border: 1px solid #e3ebf6!important;" type="text">
                                        <div class="col-md-2"><button id="srcfbtn" class="btn btn-primary">Search</button></div>
                                    </div>
                                    
                                   
                                    </div>
</div>
                                </div><br>
                                    <hr>
                                    <div class="row">
                                     
                                    </div>
                                    <div class="row">
                                          <!--for serach result-->
                                 <div class="col-md-12" style="height:80vh;overflow-y:scroll;">
                                        <h2  class="text-center">Search Results</h2>
                                            <div class="card col-md-12 mt-2">
                                                <div id="fsearchresult" class="card-body"></div>
                                                <table id="example" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Image</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            
                                            </div>
                                        </div>
                                <!--end search result-->
                             <!--shop products-->
                             
                            <!--shop products end-->
                                    </div>
                                </div><!--end card-body--> 
                            </div><!--end card-->  
                            
                        </div><!-- end col--> 

                                                                           
                    </div><!--end row-->
                    
                    <!--end row-->
                    <div class="modal fade" id="stockmodal" tabindex="-1" role="dialog" aria-labelledby="stockmodaltitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <form id="stockform">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="stockmodaltitle">Manage Stock</h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group row">                                                            
                                                                <div class="col-sm-12">
                                                                    <select class="form-control form-control-sm" name="imtype">
                                                                        <option value="Receive">Receive</option>
                                                                        <option value="Issue">Issue</option>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                                                            
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group row">                                                            
                                                                <div class="col-sm-12">
                                                                    <span>Item No:&nbsp;</span><span id="item"></span><br>
                                                                    <span id="description"></span>
                                                                    <input type="hidden" id="itemsl" name="itemsl">
                                                                </div>
                                                            </div> 
                                                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group row">  
                                                            <label for="skucode" class="col-sm-12 col-form-label text-left">Purchase Cost</label>                                                          
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control form-control-sm" id="cost" name="cost">
                                                                </div>
                                                            </div> 
                                                                                            
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group row">                                                            
                                                                <div class="col-sm-12">
                                                                <label for="skucode" class="col-sm-12 col-form-label text-left">Quantity</label>                                                          
                                                                <input type="text" class="form-control form-control-sm" id="qty" name="qty">
                                                                </div>
                                                            </div> 
                                                                                            
                                                        </div>
                                                    </div>
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary btn-sm" id="savestock">Save changes</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                            </form>
                                        </div><!--end modal-dialog-->
                                    </div>

                                <div class="modal fade"  id="addmodal" tabindex="-1" role="dialog" aria-labelledby="subcategorymodaltitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <form id="addsubcategoryform">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="subcategorymodaltitle">Add Product In Shop</h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body" style="width:30vw;">
                                                    <div class="row">
                                                        <label for="saleprice">Your Sales Price (Must Not Be Greated Than: <span id="mrp"></span> TK)</label>
                                                        <input required type="number" id="saleprice" class="form-control">
                                                        <input type="hidden" id="itmid" >
                                                    </div>
                                                    <div class="row">
                                                        <label for="saleprice">Amar Bazar Percentage(%)</label>
                                                        <input required type="number" id="ablpercent" class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <label for="saleprice">Give Initial Stock</label>
                                                        <input required type="number" id="stck" class="form-control">
                                                    </div>
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" id="addsubcategory">Save</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                            </form>
                                        </div><!--end modal-dialog-->
                                    </div>
                                    <!-- modela end -->
                                <div class="modal fade"  id="addmodal2" tabindex="-1" role="dialog" aria-labelledby="subcategorymodaltitle" >
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <form id="edititm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="subcategorymodaltitle">Edit Product In Shop</h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body" style="width:30vw;">
                                                     <div class="row">
                                                        <label for="mrp">MRP Price (TK)</label>
                                                        <input required type="number" id="mrp2" class="form-control">
                                                        <input type="hidden" id="itmid" >
                                                    </div>
                                                    <div class="row">
                                                        <label for="saleprice">Your Sales Price (TK)</label>
                                                        <input required type="number" id="saleprice2" class="form-control">
                                                     
                                                    </div>
                                                    <div class="row">
                                                        <label for="saleprice">Amar Bazar Percentage(%)</label>
                                                        <input required type="number" id="ablpercent2" class="form-control">
                                                    </div>
                                                     <div class="row">
                                                        <label for="saleprice">Long Description</label>
                                                        <textarea id="longdesc2" class="form-control"></textarea>
                                                    </div>
                                                    
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-sm" id="updateitm">Update</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                            </form>
                                        </div><!--end modal-dialog-->
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="modal fade"  id="delsure" tabindex="-1" role="dialog" aria-labelledby="subcategorymodaltitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="subcategorymodaltitle">Are Your Sure ?..You Want To Delete The Product </h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body" style="width:60vw;">
                                                  <div class="row">
                                                      <div class="col-sm-4"></div>
                                                      <div>
                                                          <input id="delprd" type="hidden">
                                                         <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">No</button>
                                                        <button type="submit" class="ml-2 btn btn-danger btn-lg" id="delpr">Yes</button>
                                                      </div>
                                                  </div>
                                                   
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">

                                                    
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                           
                                        </div><!--end modal-dialog-->
                                    </div>
                                    
                                    
                                    
                                    
                                </div><!--end card-header-->
                               <!--end card-body--> 
                            </div><!--end card--> 
                        </div> <!--end col-->                                                   
                    </div><!--end row-->
                    
                </div><!-- container -->