<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Albums
    <div class="transbox-b col-sm-8 col-sm-offset-2 col-xs-12">
        <h1>New Album</h1>
    </div>
    <div class="padd-20 col-xs-12">
        <form id="newalbumform" action="<?php echo base_url('songbook/create_album'); ?>" method="post">
                <div class="col-md-12">
                <div class="col-md-6 col-md-offset-3">
                    Album Name
                    <div class="form-group">
                        <input type="text" class="form-control" id='name' name="name" style="color:#bfbfbf; font-variant: none;" value="Name" onchange='enable()' onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="status">Status</label>
                    <div class="form-group">
                    <select class="form-control" id="status" name="status">
                        <?php foreach($statuses as $status){ ?>
                            <option value="<?php echo $status->ID; ?>"><?php echo $status->name; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div id="alert" class="col-md-8 col-md-offset-2 center transbox hide alert">
                    Please enter a song name!
                </div>
                </div>                          
                <div class="col-md-4 col-md-offset-4 center padd-10-0">
                    <input onclick="validate()" id="form-btn" class="button button-info" value="Create Album">
                </div>
            </form>
    </div>
</div>
</div>
<script>
    var form = document.getElementById('newsongform');
    var can_submit = false;
    function validate() {
        if (can_submit) {
            $("#alert").addClass("hide");
            document.getElementById("newalbumform").submit();
        } else {
            $("#alert").removeClass("hide");
            $("#alert").text("Please enter a song name.");
            $("#name").addClass("error");
        } 
    }
    function enable(){
        can_submit = true;
    }
    setActive('create');
</script>
<?php $this->load->view('songbook/footer'); ?>