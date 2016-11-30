<?php $this->load->view('top'); ?>
        <div class="row col-md-6 col-md-offset-3 padd-20">
            <form id="signupform" action="<?php echo base_url('user/create_user'); ?>" method="post">
                <div class="col-md-12 transbox-b">
                <div class="col-md-6">
                    First name
                    <div class="form-group">
                        <input type="text" class="form-control" id='first' name="first" style="color:#bfbfbf; font-variant: none;" value="First" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div class="col-md-6">
                    Last name
                    <div class="form-group">
                        <input type="text" class="form-control" id='last' name="last" style="color:#bfbfbf; font-variant: none;" 
                    value="Last" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    Email
                    <div class="form-group">
                        <input type="text" class="form-control" id='email' name="email" style="color:#bfbfbf; font-variant: none;" 
                    value="Email" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        Password
                        <input type="password" class="form-control" id='pass' name="pass" style="color:#bfbfbf; font-variant: none;" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        Confirm Password
                        <input type="password" class="form-control" id='repass' name="repass" style="color:#bfbfbf; font-variant: none;" onfocus="inputFocus(this)" onblur="inputBlur(this)">
                    </div>
                </div>
                <div id="alert" class="col-md-8 col-md-offset-2 center transbox hide alert">
                    Please enter your name and a valid email address!
                </div>
                </div>                          
                <div class="col-md-4 col-md-offset-3 center padd-10-0">
                    <input onclick="validate()" id="form-btn" class="button button-info" value="Sign-up">
                </div>
            </form>
        </div>
        
    </div>
</div>
<script type="text/javascript">
    var button = document.getElementById('signup-button');
    button.classList = 'active';
    var form = document.getElementById('signupform');
    function validate() {
            var email = $("#email").val();
            var name = $("#first").val();
            var pass = $("#pass").val();
            var repass = $("#repass").val();
            if (validateEmail(email) && validateName(name) && validatePass(pass, repass)) {
                $("#alert").addClass("hide");
                document.getElementById("signupform").submit();
            } else if (!validateName(name)) {
                $("#alert").removeClass("hide");
                $("#alert").text("Please enter your name.");
                $("#first").addClass("error");
                $("#repass").removeClass("error");
                $("#name").removeClass("error");
                $("#email").removeClass("error");
            } else if (!validateEmail(email)) {
                $("#alert").removeClass("hide");
                $("#alert").text("Please enter a valid email address.");
                $("#email").addClass("error");
                $("#padd").removeClass("error");
                $("#first").removeClass("error");
                $("#repass").removeClass("error");
            } else if (!validatePass(pass, repass)) {
                $("#alert").removeClass("hide");
                $("#alert").text("Please enter a valid password at least 6 characters long.");
                 $("#pass").addClass("error");
                $("#repass").addClass("error");
                $("#first").removeClass("error");
                $("#email").removeClass("error");
            } 
            
        }
    
    function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    
    function validateName(name) {
        return ((name != '') && (name != 'First'));
    }
    
    function validatePass(pass, repass) {
        return ((pass == repass) && (pass.length >= 6));
    }
</script>
<?php $this->load->view('footer'); ?>