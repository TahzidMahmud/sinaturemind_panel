<div class="page-content">
      <h4 class="text-center"><b>Add/Update Shipping Charge</b></h4><hr>
     <form>
        <div class="form-group">
            <label for="">Shipping Charge </label>
            <input type="text" value="<?php echo $this->sdata["shipping"]?>" class="form-control"  id="shipping"  name="shipping"  placeholder="Enter Shipping">
        </div>
         <div class="form-group">
            <label for="">Express-Shipping Charge </label>
            <input type="text" value="<?php echo $this->sdata["expshipping"]?>" class="form-control"  id="expshipping"  name="expshipping"  placeholder="Enter Shipping">
        </div>
         <div class="row">
             <div class="col-md-4  col-sm-12">
               <button type="button"  class="btn btn-primary btn-lg" id="shippingsmt">Submit</button>
             </div>
        </div>
      
    </form>
    
    
    
    
    <h4 class="text-center"><b>Add/Update RIN OR ODC</b></h4><hr>

    <form>
        <div class="form-group">
            <label for="">RIN No </label>
            <input type="text" value="<?php echo $this->sdata["rin_no"]?>" class="form-control"  id="rin"  name="rin"  placeholder="Enter RIN">
        </div>
        <div class="form-group">
            <label for="">ODC No</label>
            <input type="text" value="<?php echo $this->sdata["odc_no"]?>" class="form-control"  id="odc"  name="odc"  placeholder="Enter ODC" >
        </div>
    </form>
    <div class="row">
             <div class="col-md-4  col-sm-12">
               <button type="button"  class="btn btn-primary btn-lg" id="rinodc">Submit</button>
             </div>
    </div>
    <h4 class="text-center"><b>Update Profile Informations</b></h4><hr>

    <div class="container-fluid">
    <form >
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" value="<?php echo $this->sdata["xemail"]?>" class="form-control"  id="email"  name="email" aria-describedby="emailHelp" placeholder="Enter Email" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Shop Name</label>
            <input type="text" class="form-control" value="<?php echo $this->sdata["xorgname"]?>" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Shop Name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Delivery Area</label>
            <input type="text" class="form-control" value="<?php echo $this->sdata["xdelarea"]?>"  id="delarea" name="delarea" aria-describedby="emailHelp" placeholder="Enter Delivery Area" required>
        </div>
         <div class="form-group">
            <label for="exampleInputEmail1">Delivery Area</label>
            <input type="text" class="form-control" value="<?php echo $this->sdata["xdelarea"]?>"  id="delarea" name="delarea" aria-describedby="emailHelp" placeholder="Enter Delivery Area" >
        </div>
        
    </form>
    <button id="btn-smt"  class="btn btn-primary">Update</button><br>
    
     <h4 class="text-center"><b>Update Password</b></h4><hr>

     <form >
        <div class="form-group">
            <label for="">Current Password</label>
            <input type="text" id="current_pass" class="form-control"  placeholder="Enter Current Password"  >
            <label id="curpass" class="text text-danger" style="display:none;">Wrong Password Please Try Again..!!</label>
        </div>
        <div class="form-group">
            <div class="form-group">
            <label for="">New Password</label>
            <input type="password" id="new_pass" class="form-control"  placeholder="Enter New Password"  >
        
        </div>
         <div class="form-group">
            <div class="form-group">
            <label for="">Confirm New Password</label>
            <input type="password" id="new_pass_conf" class="form-control"  placeholder="Enter New Password Again"  >
            <label id="curpass2" class="text text-danger" style="display:none;">Password Mistmatch Try Again..!!</label>
        
        </div>
    </form>
    <button id="btn-pass" class="btn btn-primary">Change Password</button>
    
    <form id="addcategoryform" name="addcategoryform" enctype="multipart/form-data">
    <div class="form-group ">
        <h4 class="text text-center">Upload Profile Picture</h4>
        <label for="categoryimage" class="col-md-12  mt-4 d-flex justify-content-center"><i class="fas fa-plus mr-2"></i><b class="text-center"> Click To Upload Image</b></label>
        <input type="file" style="display:none;"  class="form-control" id="categoryimage" name="categoryimage"  accept=".png,.jpg,.jpeg">
        <div class="row">
            <div class="col-md-5 col-sm-12"></div>
             <div class="col-md-4 col-sm-12">
                  <img src=""  style="display:none;" id="selectedimage"><span style="display:none;padding:5px;" id="crossbutton" class="text-center">x</span>
             </div>
           
        </div><br><br>
        <div class="row">
            <div class="col-md-5 col-sm-12"></div>
             <div class="col-md-4 ml-4 col-sm-12">
               <button type="button"  style="display:none;" class="btn btn-primary btn-lg" id="addcategory">Upload</button>
             </div>
           
        </div>
         
    </div>
    </form>

    
    
    </div>
</div>

