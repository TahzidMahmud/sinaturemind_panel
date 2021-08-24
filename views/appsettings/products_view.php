<div class="container">
                                        <div class="row ml-4">
                                          <h4 class="text-center  mr-4" >Total Shop Items (Total = <span id="total"></span>)</h4> <h4>See Only <button class="btn btn-success ml-2 mr-2" id="activesrc">Active</button> Or <button class=" ml-2 btn btn-warning" id="inactivesrc">Inactive</button></h4>
                                          <hr>
                                      </div>
                                       <h4 class="text text-warning ml-4">Search Your Shop Product Here</h4><br>
                                      <div class="row ml-4">
                                          
                                         <div class="row" style="width:100vw;">
                                             <input id="srctxt"  class="form-control  ml-1" style="width:60vw;"><button class="btn btn-primary ml-2" style="30vw;" id="btnsrc">Search</button>
                                         </div>
                                      </div>
                                       <h2 class="text text-center">Shop Products</h2><hr>
                                      <div class="col-md-12" style="height:80vh;overflow-y:scroll;">
                                             
                                            <div class="card col-md-12 mt-2">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                             <th class="border-top-0">Active Status</th>
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
                                            </div>
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
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
                                                                        <option value="Receive">Add (+)</option>
                                                                        <option value="Issue">Reduce (-)</option>
                                                                        
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
                                                        <label for="saleprice">Stock</label>
                                                        <input required type="number" id="stockedt" class="form-control">
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
                                    
</div>