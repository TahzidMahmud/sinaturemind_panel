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
                                            <li class="breadcrumb-item active">Item Database</li>
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
                                <div class="card-body" id="frmm"> 
                                    <form id="itemform">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-8 col-form-label text-left"><h5>Search By Item Description (Minimum of 3 characters required to search)</h5></label></label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="text" palceholder="Search Item" id="itemsearch">
                                                    </div>
                                                </div>
                                                                                 
                                            </div>
                                        </div>  
                                        <hr>
                                        <hr>
                                        <h4 class="text text-center">Fill The Foloowing Fields To Create New Item</h4>
                                         <div class="row">
                                             
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Category</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control form-control-sm" id="cat" name="cat">
                                                            <option value="">Select Category...</option>
                                                           <?php foreach($this->allcategories as $cat){?>
                                                           <option value="<?php echo $cat['xcatsl']?>"><?php echo $cat['xcat']?></option>
                                                           <?php }?>
                                                        </select>
                                                    </div>

                                                </div>
                                                                                 
                                            </div>
                                            <div class="col-lg-2">
                                            <button type="button" class="btn btn-primary btn-sm " style="margin-top:6vh;"  data-toggle="modal" data-target="#categorymodal">Add</button>
                                            <!-- category modal -->

                                            <!-- Modal -->
                                            </div>


                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label for="itemdesc" class="col-sm-4 col-form-label text-left">Sub Category</label>
                                                    <div class="col-sm-12">
                                                    
                                                    <select class='form-control form-control-sm' id='subcat' name='subcat'>
                                                    <option value='Refrigaretor'>Select Sub Category...</option>
                                                     
                                                     </select>
                                                    
                                                        
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>
                                            <div class="col-lg-2">
                                            <button type="button" class="btn btn-primary btn-sm " style="margin-top:6vh;"  data-toggle="modal" data-target="#subcategorymodal">Add</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">SKU Code (Optional)</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="text" palceholder="SKU Code" id="skucode" name="skucode">
                                                        <input type="hidden" id="itemno" name="itemno">
                                                    </div>
                                                </div>
                                                                                 
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="itemdesc" class="col-sm-4 col-form-label text-left">Item Description / Name</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="text" id="itemdesc" name="itemdesc">
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>
                                        </div>
                                         
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Brand</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control form-control-sm" id="brand" name="brand">
                                                            <option value="Toshiba">Select Brand...</option>
                                                           
                                                        </select>


                                                       
                                                    </div>
                                                </div>                                  
                                            </div>
                                            <div class="col-lg-2">
                                            <button type="button" class="btn btn-primary btn-sm " style="margin-top:6vh;"  data-toggle="modal" data-target="#brandmodal">Add</button>
                                            </div>
                                              <div class="col-lg-2">
                                                <div class="form-group row">
                                                    <label for="itemdesc" class=" col-form-label text-left">Initial Stock</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="number" id="stock" name="stock">
                                                        <input type="hidden" value="" name="itemprops" id="itemprops"> 
                                                        <input type="hidden" value="" name="itemfeatures" id="itemfeatures">  
                                                        <input type="hidden" value="" name="itemimages" id="itemimages">
                                                        <input type="hidden" value="" name="relateditems" id="relateditems"> 
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>
                                            
                                            <div class="col-lg-2">
                                                <div class="form-group row">
                                                    <label for="itemdesc" class=" col-form-label text-left">MRP Price</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="number" id="mrp" name="mrp">
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group row">
                                                    <label for="itemdesc" class=" col-form-label text-left">Sales Price</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="number" id="salesprice" name="salesprice">
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group row">
                                                    <label for="itemdesc" class="col-form-label text-left">ABL Percentage</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control form-control-sm" type="number" id="ablpercent" name="ablpercent">
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Price Basis</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control form-control-sm" id="pricebasis" name="pricebasis">
                                                            <option value="">Item Price</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                                                 
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label for="relateditems" class="col-sm-4 col-form-label text-left">Unit</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control form-control-sm" id="itemunit" name="itemunit">
                                                            <option value="PCS">PCS</option>
                                                            <option value="BOX">BOX</option>
                                                            <option value="BOX">SET</option>
                                                            <option value="BOX">KG</option>
                                                            <option value="BOX">LITRE</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                                                                          
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-4 col-form-label text-left">Long Description</label>
                                                    <div class="col-sm-12">
                                                        <textarea id="longdesc" name="longdesc"></textarea>
                                                    </div>
                                                </div>
                                                                                 
                                            </div>

                                        </div>
                                                 


                                        <?php $props = array("Color","Size"); 
                                        
                                            foreach($props as $val){?>
                                        <!--<div class="row">-->
                                        <!--    <div class="col-lg-12">-->
                                            
                                        <!--        <div class="form-group row">-->
                                                
                                        <!--            <div class="col-sm-5">-->
                                        <!--            <label for="<?php echo $val;?>" class="col-sm-4 col-form-label text-left"><?php echo $val;?></label>-->
                                        <!--                <input class="form-control form-control-sm" type="text" id="<?php echo strtolower($val);?>_attr">-->
                                        <!--            </div>-->
                                        <!--            <div class="col-sm-5">-->
                                        <!--            <label for="<?php echo $val;?>" class="col-sm-4 col-form-label text-left">Sales Price</label>-->
                                        <!--                <input class="form-control form-control-sm" type="text" value="0" id="<?php echo strtolower($val);?>_price">-->
                                        <!--            </div>-->
                                        <!--            <div class="col-sm-2">-->
                                        <!--                <br><br>-->
                                        <!--                <button class="btn btn-primary btn-sm btnadd" id="<?php echo strtolower($val);?>">Add</button>-->
                                        <!--            </div>-->
                                        <!--        </div>-->
                                        <!--        <div class="col-lg-12">-->
                                        <!--            <table class="table table-striped attr_result" id="<?php echo strtolower($val);?>_result"></table>-->
                                        <!--        </div> -->
                                                                              
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <?php } ?>
                                        <!--<div class="row">-->
                                        <!--    <div class="col-lg-12">-->
                                        <!--    <label for="feature" class="col-sm-4 col-form-label text-left">Features</label>-->
                                        <!--        <div class="form-group row">-->
                                                    
                                        <!--            <div class="col-sm-5">-->
                                        <!--                <input class="form-control form-control-sm" type="text" id="feature">-->
                                        <!--            </div>-->
                                        <!--            <div class="col-sm-5">-->
                                        <!--                <input class="form-control form-control-sm" type="text" id="featuredesc">-->
                                        <!--            </div>-->
                                        <!--            <div class="col-sm-2">-->
                                        <!--                <button class="btn btn-primary btn-sm" id="btnfeatureadd">Add</button>-->
                                        <!--            </div>-->
                                        <!--        </div>-->
                                        <!--        <div class="col-lg-12" >-->
                                        <!--        <table class="table table-striped" id="feature_result"><tbody></tbody></table>-->
                                        <!--        </div> -->
                                                                              
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <!--<div class="row">-->
                                        <!--    <div class="col-lg-12">-->
                                        <!--    <label for="feature" class="col-sm-8 col-form-label text-left">Related Item Search By Item Description (Minimum of 3 characters required to search)</label>-->
                                        <!--        <div class="form-group row">-->
                                                    
                                        <!--            <div class="col-sm-12">-->
                                        <!--                <input class="form-control form-control-sm" type="text" id="relateditems" name="relateditems">-->
                                        <!--            </div>-->
                                                    
                                        <!--        </div>-->
                                        <!--        <div class="col-lg-12" >-->
                                        <!--        <table class="table table-striped" id="relateditem_result"><tbody></tbody></table>-->
                                        <!--        </div> -->
                                                                              
                                        <!--    </div>-->
                                        <!--</div>-->
                                        
                                       
                                    </form> 
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel">
                                                <div class="panel-head">
                                                    <h5 class="panel-title">Only One User Photo Upload</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <form action="<?php echo URL;?>?page=itemdatabase&action=uploadimage" class="dropzone dz-clickable" id="itemimage">
                                                        <div class="dz-default dz-message"><span><i class="icon-plus">
                                                            </i>Drop files here or click here to upload. <br> Only Images Allowed</span>
                                                        </div>
                                                    </form>
                                                    <div class="row mt-1 ml-1 mr-1 border" id="imglist">No Image found!</div>        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="row">
                                            <div class="col-lg-12">
                                                <button id="btnitemsave" class="btn btn-primary btn-sm">Submit</button>
                                                <button id="btnitemupdate" class="btn btn-primary btn-sm">Update</button>
                                                                                  
                                            </div>

                                        </div> 
                                </div><!--end card-body--> 
                            </div><!--end card-->  
                            
                        </div><!-- end col--> 

                                                                           
                    </div><!--end row-->
                    
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                    <div class="col-md-1">                      
                                        <select class="form-control" id="showcount" name="showcount">
                                            <option value="5" selected>5</option>
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="50">100</option>
                                            <option value="50">150</option>
                                            <option value="50">200</option>
                                        </select>                                                       
                                    </div>
                                       <!--end col--> 
                                        <div class="col-md-2">     

                                            <select class="form-control " id="fcat" name="fcat">
                                                <option value="">Select Category...</option>
                                                    <?php foreach($this->allcategories as $cat){?>
                                                <option value="<?php echo $cat['xcatsl']?>"><?php echo $cat['xcat']?></option>
                                                    <?php }?>
                                            </select>     
                                        
                                        </div>  
                                        <div class="col-md-2">                      
                                        
                                            <select class="form-control" id="fsubcat" name="fsubcat">
                                            <option value="">Select Sub-Category...</option>
                                            </select>                      
                                        </div><!--end col-->  
                                        <div class="col"> 
                                            <div class="row">
                                                <input class="form-control col-md-10" id="searchfilter" name="searchfilter" type="text">
                                                <button class="btn btn-primary ml-2" id="srcfbtn">search</button>
                                            </div>                                          
                                        </div>
                                       <!--end col-->                                        
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    
                                                    <th class="border-top-0">Product Desc</th>
                                                    <th class="border-top-0">Unit</th>
                                                    <th class="border-top-0">Price</th>
                                                    <th class="border-top-0">Stock</th>
                                                    <th class="border-top-0">Properties</th>
                                                    <th class="border-top-0">Status</th>
                                                    <th class="border-top-0">Action</th>
                                                </tr><!--end tr-->
                                            </thead>
                                            <tbody id="lastitems">
                                                  
                                                                              
                                            </tbody>
                                        </table> <!--end table-->                                               
                                    </div><!--end /div-->

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
                                    </div><!--end modal-->

                                </div><!--end card-body--> 
                            </div><!--end card--> 
                        </div> <!--end col-->                                                   
                    </div><!--end row-->
                                                      
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                                                                  
                                    </div><!--end /div-->
                                                    <!-- Category modal -->
                                    <div class="modal fade"  id="categorymodal" tabindex="-1" role="dialog" aria-labelledby="categorymodaltitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <form id="addcategoryform" name="addcategoryform" enctype="multipart/form-data">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="categorymodaltitle">Add Category</h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body" style="width:30vw;">
                                                    <div class="row">
                                                    <div class="col-lg-1"></div>
                                                        <div class="col-lg-10">
                                                            <div class="form-group row">                                                            
                                                                <div class="col-sm-12">
                                                                <label for="category">Category Name</label>
                                                                   <input type="text" class="form-control" id="category" name="category" >
                                                                </div>
                                                                <div class="col-sm-12">
                                                                <div class="col-md-2"></div>
                                                                <label for="categoryimage" class="col-md-10 ml-4 mt-4 d-flex justify-content-center"><i class="fas fa-plus mr-2"></i><b class="text-center">Upload Image</b></label>
                                                                   <input type="file" style="display:none;"  class="form-control" id="categoryimage" name="categoryimage"  accept=".png,.jpg,.jpeg">
                                                                </div>
                                                                <img src="" style="display:none;" id="selectedimage"><span style="display:none;" id="crossbutton" class="text-center">x</span>

                                                            </div> 
                                                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div><!--end modal-body-->
                                              
                                    
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary btn-sm" id="addcategory">Save</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                            </form>
                                   
                                        </div><!--end modal-dialog-->
                                    </div><!--end modal-->




                                    <!-- brand modal -->

                                    <div class="modal fade"  id="brandmodal" tabindex="-1" role="dialog" aria-labelledby="brandmodaltitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <form id="addbrandform">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="brandmodaltitle">Add Brand</h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body" style="width:30vw;">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Category</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control form-control-sm" id="cat" name="cat">
                                                            <option value="">Select Category...</option>
                                                           <?php foreach($this->allcategories as $cat){?>
                                                           <option value="<?php echo $cat['xcatsl']?>"><?php echo $cat['xcat']?></option>
                                                           <?php }?>
                                                        </select>
                                                    </div>

                                                </div>
                                                    <div class="row">
                                                   
                                                        <div class="col-lg-12">
                                                            <div class="form-group row">                                                            
                                                                <div class="col-sm-12">
                                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Brand</label>
                                                                   <input type="text" class="form-control" id="brand" name="brand" >
                                                                </div>
                                                            </div> 
                                                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary btn-sm" id="addbrand">Save</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                            </form>
                                        </div><!--end modal-dialog-->
                                    </div>
                                    <!-- modela end -->






                                     <!-- subcategory modal -->

                                    <div class="modal fade"  id="subcategorymodal" tabindex="-1" role="dialog" aria-labelledby="subcategorymodaltitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <form id="addsubcategoryform">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="subcategorymodaltitle">Add subcategory</h6>
                                                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body" style="width:30vw;">
                                                <div class="form-group row">
                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Category</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control form-control-sm" id="cat" name="cat">
                                                            <option value="">Select Category...</option>
                                                           <?php foreach($this->allcategories as $cat){?>
                                                           <option value="<?php echo $cat['xcatsl']?>"><?php echo $cat['xcat']?></option>
                                                           <?php }?>
                                                        </select>
                                                    </div>

                                                </div>
                                                    <div class="row">
                                                   
                                                        <div class="col-lg-12">
                                                            <div class="form-group row">                                                            
                                                                <div class="col-sm-12">
                                                                    <label for="skucode" class="col-sm-4 col-form-label text-left">Subcategory</label>
                                                                   <input type="text" class="form-control" id="subcategory" name="subcategory" >
                                                                </div>
                                                            </div> 
                                                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary btn-sm" id="addsubcategory">Save</button>
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
                                                      <div class="col-sm-6">
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

                                </div><!--end card-body--> 
                            </div><!--end card--> 
                        </div> <!--end col-->                                                   
                    </div><!--end row-->
                    
                </div><!-- container -->