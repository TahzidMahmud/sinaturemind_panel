<div class="container-fluid">
<br>
<div class="row sms-modal" id="smsmodal">
    <div class="card" >
        <div class="card-body scroll" style="height:80vh;width:50vw;background-color:white;" id="contacts">
        <button class="btn btn-danger float-right" id="cls">Colse X</button>
        <div class="row">
        <h4 class="text text-center">Create New Contact</h4><br>   
        </div>
            <div class="row"> 
                <div class="col-md-4">
                    <label for="text">New Number</label><br>
                    <input class="form-control" type="text " id="ctnnumber" placeholder="Put Phone Number">
                </div>
                <div class="col-md-4">
                    <label for="number">New Name</label><br>
                    <input class="form-control" type="text " id="ctnname" placeholder="Put Name">
                </div>
                <div  class="col-md-4">
                    <button id="addctnbtn" class="btn btn-success mt-4">Add New</button>
                </div>
            </div>
            <br>
            <h5 class="text text-center">Contacts</h5><hr>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">Number</th>
                        <th class="text-left">Action</th>
                    </tr>
                </thead>
            </table>
            <br>

            <br><button class="btn btn-warning float-right" onclick="selectall()">Select All</button>
            <br>
            <br>
        </div>
       
    </div>

</div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Your Current SMS Balance</h3>
                    <h5 class="text-center text-primary" id="balance"><?php echo $this->balance; ?></h5>
                </div>
            </div>
            
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                   
                        <div class="form-group">
                            <label for="number">Recipient Numbe</label>
                            <div class="row">
                                <input type="text" class="form-control col-md-8 mr-2" name="number" id="number" aria-describedby="emailHelp" required placeholder="Enter Phone Number">
                                <button class="btn btn-primary" id="contact-btn">Add From Contact</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="body">Sms Body</label>
                           <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                           <small id="emailHelp" class="form-text text-muted">The SMS Must Be Lesses Than 80 Characters.</small>
                        </div>
                   
                    <button type="submit" id="btn-smt" class="btn btn-primary">Send</button>

                </div>
            </div>
        </div>
    </div>
</div>