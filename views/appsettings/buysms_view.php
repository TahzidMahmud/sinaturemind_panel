<div class="container-fluid">
<br>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">Your Current SMS Rate</h3>
                    <h5 class="text-center text-primary" id="balance">20 Paisa each(0.20tk)</h5>
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
                            <label for=smscount">Amount Of Sms Want to Buy</label>
                           <div class="row">

                           <button class="btn btn-danger col-md-2 mr-2 ml-2" id="dec">- Remove</button> <input value="0" type="number" class=" col-md-6 form-control" name="smscount" id="smscount" aria-describedby="emailHelp" required placeholder="Enter Sms Count"> <button class="btn btn-success col-md-2 ml-2 mr-2" id="inc" >+ Add</button>
                           </div>
                        </div>
                        <div class="form-group">
                            <label for="amount">Buy Amount (TK)</label>
                            <input value="0" type="number" class="form-control" name="amount" id="amount" aria-describedby="emailHelp" required placeholder="Buying Amount">
                        </div>
                    
                    <button type="" id="btn-smt" class="btn btn-primary">Buy</button>

                </div>
            </div>
        </div>
    </div>
</div>