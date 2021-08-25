<div class="container">
    <div class="row" >
        <div class="card" style="width:60vw;margin-left:10vw;margin-top:5vh;">
            <div class="card-header">Create New Group</div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Group Name</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Subject</label>
                        <select name="group" id="group" class="form-control">
                            <option value="">---Select---</option>
                            <?php foreach($this->subjects as $subject){?>
                            <option value="<?php echo $subject["xitemsl"];?>"><?php echo $subject["xdesc"];?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>