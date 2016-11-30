<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
<?php $theme = $this->session->userdata('theme'); ?>
<?php $scheme = $this->session->userdata('scheme'); ?>
    
        Profile
        <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
            <h1>
                <div id='name_view'>
                    <span id="name_selected"><?php echo $user->first.' '.$user->last ?></span>
                    <a class="glyph glyph-edit" onclick="editName()">
                        <span id="name_icon" class="glyphicon glyphicon-edit"></span>
                    </a>
                </div>
                <div id='name_edit' class="col-xs-12 col-xs-offset-1 padd-20" style="display:none">
                    <input type="text" style="width:40%; float:left; font-size:16px; margin-right:3px; margin-bottom:5px" class="black" id="first_name_input" value="<?php echo $user->first; ?>">
                    <input type="text" style="width:40%; float:left; font-size:16px; margin-right:3px; margin-bottom:5px" class="black" id="last_name_input" value="<?php echo $user->last; ?>">
                    <a class="input-ok-glyph" style="float:left; width:10%" onclick="changeName()">
                        <span style="float:left" class="glyphicon glyphicon-ok"></span>
                    </a>
                </div>
            </h1>
        </div>
        <div class="padd-20 col-xs-12">
            <div class="col-md-12">
            <div class="col-md-4">
                <h3 style="font-size:18px"><span>Theme:</span> 
                    <span id="theme_id_view">
                        <span style="font-size:18px" id="theme_id_selected"><?php echo $theme->name; ?></span><a class="glyph glyph-edit" onclick="editHidden('theme_id')"><span class="glyphicon glyphicon-edit"></span></a>
                    </span>
                    <div id='theme_id_edit' style="display:none">
                        <select class="form-control" id="theme_id_input" style="float:left; width:90%" name="status">
                            <?php foreach($themes as $t){ ?>
                                <option id='theme_id_option_<?php echo $t->ID; ?>' value="<?php echo $t->ID; ?>" <?php if($t->ID == $theme->ID){echo 'selected';} ?>><?php echo $t->name; ?></option>
                            <?php } ?>
                        </select>
                        <a class="input-ok-glyph" style="float:right; width:10%" onclick="changeHidden('theme_id')"><span class="glyphicon glyphicon-ok"></span></a>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3 style="font-size:18px"><span>Color Scheme:</span> 
                    <span id="scheme_id_view">
                        <span style="font-size:18px" id="scheme_id_selected"><?php echo $scheme->name; ?></span><a class="glyph glyph-edit" onclick="editHidden('scheme_id')"><span class="glyphicon glyphicon-edit"></span></a>
                    </span>
                    <div id='scheme_id_edit' style="display:none">
                        <select class="form-control" id="scheme_id_input" style="float:left; width:90%" name="status">
                            <?php foreach($schemes as $s){ ?>
                                <option id='scheme_id_option_<?php echo $s->ID; ?>' value="<?php echo $s->ID; ?>" <?php if($s->ID == $scheme->ID){echo 'selected';} ?>><?php echo $s->name; ?></option>
                            <?php } ?>
                        </select>
                        <a class="input-ok-glyph" style="float:right; width:10%" onclick="changeHidden('scheme_id')"><span class="glyphicon glyphicon-ok"></span></a>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3 style="font-size:18px">Songbook: <span style="font-size:18px" id="songbook_name"><?php echo $user->songbook_name ?></span><a id="songbook_name_edit" class="glyph glyph-edit" onclick="edit('songbook_name')"><span id="songbook_name_icon" class="glyphicon glyphicon-edit"></span></a>
                </h3>
            </div>
            
            <div class="col-xs-12 padd-40-20">
                <div class="col-xs-12 col-sm-6 padd-0-20">
                    <a onclick='updateUser()'><input id="about-btn" class="button button-info" value="Apply"></a>
                </div>
                <div class="col-xs-12 col-sm-6 center">
                    <a href="<?php echo base_url('songbook') ?>"> <input id="form-btn" class="button button-info" value="Back"></a>
                </div>
            </div>  
        </div>
    </div>
<script type="text/javascript">
    
    function updateUser(){
        changeHidden('theme_id');
        window.location.replace("<?php echo base_url('profile'); ?>");
    }
    
    function editHidden(item){
        var view = document.getElementById(item + '_view');
        var edit = document.getElementById(item + '_edit');
        view.style.display = 'none';
        edit.style.display = '';
    }
    
    function changeHidden(item){
        var view = document.getElementById(item + '_view');
        var edit = document.getElementById(item + '_edit');
        var selected = document.getElementById(item + '_selected');
        var input = document.getElementById(item + '_input');
        edit.style.display = 'none';
        view.style.display = '';
        var value = input.value;
        var content_id = item + '_option_' + value;
        var content_div = document.getElementById(content_id);
        var content = content_div.innerHTML;
        var ajax_url = '<?php echo site_url('user/update_user_field'); ?>/' + item + '/' + <?php echo $user->ID; ?>;
        console.log(ajax_url);
        jQuery.ajax({
        url: ajax_url,
        method: 'POST',
        data: {update:value},
        success: function(res){
        if( res.result ){
            selected.innerHTML = content;
        }
        }
        });
    }
    
    function editName(){
        var view = document.getElementById('name_view');
        var edit = document.getElementById('name_edit');
        view.style.display = 'none';
        edit.style.display = '';
    }
    
    function changeName(){
        var view = document.getElementById('name_view');
        var edit = document.getElementById('name_edit');
        var selected = document.getElementById('name_selected');
        var first_input = document.getElementById('first_name_input');
        var last_input = document.getElementById('last_name_input');
        edit.style.display = 'none';
        view.style.display = '';
        var first = first_input.value;
        var last = last_input.value;
        var ajax_url = '<?php echo site_url('user/update_user_name'); ?>/' + <?php echo $user->ID; ?>;
        console.log(ajax_url);
        jQuery.ajax({
        url: ajax_url,
        method: 'POST',
        data: {update:{first_name:first, last_name:last}},
        success: function(res){
        if( res.result ){
            selected.innerHTML = first + ' ' + last;
        }
        },
        error: function(ts) { console.log(ts.responseText) }
        });
    }
    
    function edit(item) {
        var edit = document.getElementById(item + '_edit');
        var name_div = document.getElementById(item);
        var name = name_div.innerHTML;
        var icon = document.getElementById(item + '_icon');
        icon.classList = 'glyphicon glyphicon-ok';
        edit.onclick = function(){ change(item); } ;
        input = createInput(name, item);
        name_div.innerHTML = '';
        name_div.appendChild(input);
    }
    
    function createInput(name, item){
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("style", "width:300px; font-size:16px; margin-right:3px; margin-bottom:5px");
        x.classList = 'black';
        x.setAttribute("id", item + '_input');
        x.value = name;
        return x;
    }
    
    function change(item){
        var edit_div = document.getElementById(item + '_edit');
        var icon = document.getElementById(item + '_icon');
        var input = document.getElementById(item + '_input');
        var name_div = document.getElementById(item);
        var value = input.value;
        icon.classList = 'glyphicon glyphicon-edit';
        edit_div.onclick = function(){ edit(item); } ;
        var ajax_url = '<?php echo site_url('user/update_user_field'); ?>/' + item + '/' + <?php echo $user->ID; ?>;
        jQuery.ajax({
        url: ajax_url,
        method: 'POST',
        data: {update:value},
        success: function(res){
            if( res.result ){
                console.log('success');
                name_div.innerHTML = value;
            }
        },
        error: function(ts) { console.log(ts.responseText) }
        });
    }
    
</script>
<?php $this->load->view('songbook/footer'); ?>
