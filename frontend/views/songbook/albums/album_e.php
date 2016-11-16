<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    <span class="page-label">Album</span>
        <div class="col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 padd-0-20">
            <div class="album_pic" style="background-image:url(<?php echo $album->pic->src; ?>)"></div>
            <div class="col-xs-12 padd-20-0 center">
                <div class="left">
                    <label class="section-label"><span style="font-size:60%"> (Square images work best)</span></label>
                </div>
                <input class="file-loading" name="file-upload" id="picture-upload" type='file'>
            </div>
        </div>
        <div class="transbox-b-dark col-sm-6 col-xs-12">
            <h1>
                <h1>
                <span id="name"><?php echo $album->name ?></span><a id="name_edit" class="glyph glyph-edit" onclick="edit('name')"><span id="name_icon" class="glyphicon glyphicon-edit"></span></a>
            </h1>
            </h1>
        </div>
        <div class="col-sm-9 col-xs-12 padd-20-0">
            <div class="col-sm-6">
                <h3><span id="status_id_display">Status:</span> 
                    <span id="status_id_view">
                        <span id="status_id_selected"><?php echo $album->status->name; ?></span><a id="status_id_icon_div" class="glyph glyph-edit" onclick="editHidden('status_id')"><span id="status_id_icon" class="glyphicon glyphicon-edit"></span></a>
                    </span>
                    <div id='status_id_edit' style="display:none">
                        <select class="form-control" id="status_id_input" name="status">
                            <?php foreach($statuses as $status){ ?>
                                <option id='status_id_option_<?php echo $status->ID; ?>' value="<?php echo $status->ID; ?>" <?php if($status->ID == $album->status_id){echo 'selected';} ?>><?php echo $status->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </h3>
            </div>
            <div class="col-sm-6">
                <h3><span id="created_at_display">Created at:</span> 
                    <span id="created_at_view">
                        <span style="font-size:18px" id="created_at_selected"><?php echo $album->created_at; ?></span><a id="created_at_icon_div" class="glyph glyph-edit" onclick="editHidden('created_at')"><span id="created_at_icon" class="glyphicon glyphicon-edit"></span></a>
                    </span>
                    <div id='created_at_edit' style="display:none">
                        <div class='input-group date' id='created_at_div' style="color:black">
                            <input type='text' id='created_at_input' class="form-control" value="<?php echo $album->created_at?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </h3>
            </div>
        </div>
        <div class="col-sm-9">
        <table id="songs-table" class="table table-striped table-bordered songs-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                <?php if(count($album->songs) == 0){ ?>
                    <th>Songs</th>
                <?php } else { ?>
                    <th>Track</th>
                    <th>Name</th>
                    <th>Created</th>
                    <th>Status</th>
                <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php if(count($album->songs) == 0){ ?>
                <tr class='clickable-row' data-href='<?php echo site_url('songbook/newsong/?aid='.$album->ID)?>'>
                    <td>Create Song</td>
                </tr>
                <?php } else {
                    foreach($album->songs as $song){ ?>
                <tr>
                    <td width="10%"><div class="track-select" >
                        <select onchange="updateSongField('track_num', '<?php echo $song->ID ?>')"  id="<?php echo "track_num_".$song->ID ?>">
                        <?php 
                        $count = 1;
                        foreach($album->songs as $songa){ ?>
                            <option value="<?php echo $count; ?>" <?php if($song->track_num == $count){echo 'selected';} ?>><?php echo $count; ?> </option>
                        <?php echo $count++; ?>
                        <? } ?>
                    </select></div></td>
                    <td><?php echo $song->name ?></td>
                    <td><?php echo $song->created_at ?></td>
                    <td><?php echo $song->status->name ?></td>
                </tr>
                <?php }
                    } ?>
            </tbody>
        </table>
    </div>
            <div class="col-xs-12 padd-40-20">
                <div class="col-sm-6 center padd-0-20">
                    <a href="<?php echo base_url('songbook/album/v/'.$album->ID) ?>"><input id="about-btn" class="button button-info" value="Save"></a>
                </div>
                <div class="col-sm-6 center padd-0-20">
                    <a href="<?php echo base_url('songbook/album/v/'.$album->ID) ?>"> <input id="form-btn" class="button button-info" value="Cancel"></a>
                </div>
            </div>  
</div>
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
                    format: 'MM/DD/YYYY'
        });
    });
    
    $(document).ready(function() {
    $('#songs-table').DataTable( {
        "info": false,
        "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false
    } );
        addNewSongButton();
        setActive('album');
    } );
    
    $("#picture-upload").fileinput({'showPreview':false, 'showRemove':false,
            'allowedFileExtensions' : ['jpg', 'png','gif'],
        uploadUrl:'<?php echo site_url('media/upload/'.Picture.'/'.Album.'/'.$album->ID); ?>'
    });
    
    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
    
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
        var ajax_url = '<?php echo site_url('songbook/update_album_field'); ?>/' + item + '/' + <?php echo $album->ID; ?>;
        jQuery.ajax({
        url: ajax_url,
        method: 'POST',
        data: {update:value},
        success: function(res){
            if( res.result ){
                console.log('success');
                name_div.innerHTML = value;
            }
        }
        });
    }
    
    function editHidden(item){
        var view = document.getElementById(item + '_view');
        var item_dis = document.getElementById(item + '_display');
        var edit = document.getElementById(item + '_edit');
        var icon = document.getElementById(item + '_icon');
        var icon_div = document.getElementById(item + '_icon_div');
        view.style.display = 'none';
        edit.style.display = '';
        icon.classList = 'glyphicon glyphicon-ok';
        icon_div.onclick = function(){ changeHidden(item); } ;
        item_dis.appendChild(icon_div);
        
    }
    
    function changeHidden(item){
        console.log(item);
        var view = document.getElementById(item + '_view');
        var icon = document.getElementById(item + '_icon');
        var edit = document.getElementById(item + '_edit');
        var selected = document.getElementById(item + '_selected');
        var input = document.getElementById(item + '_input');
        var icon_div = document.getElementById(item + '_icon_div');
        edit.style.display = 'none';
        view.style.display = '';
        icon.classList = 'glyphicon glyphicon-edit';
        icon_div.onclick = function(){ editHidden(item); } ;
        var value = input.value;
        if (item != 'created_at'){
        var content_id = item + '_option_' + value;
        var content_div = document.getElementById(content_id);
        var content = content_div.innerHTML;
        } else {
        var content = value;
        }

        var ajax_url = '<?php echo site_url('songbook/update_album_field'); ?>/' + item + '/' + <?php echo $album->ID; ?>;
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
    
    function updateSongField(field, song_id){
        var id = field + '_' + song_id;
        var input = document.getElementById(id);
        var value = input.value;
        var ajax_url = '<?php echo site_url('songbook/update_song_field'); ?>/' + field + '/' + song_id;
        jQuery.ajax({
        url: ajax_url,
        method: 'POST',
        data: {update:value},
        success: function(res){
            if( res.result ){
                console.log(ajax_url);
            }
        }
        });
    }

    function addNewSongButton(){
        var a = document.createElement("a");
        a.setAttribute("href", "<?php echo site_url('songbook/newsong/?aid='.$album->ID)?>");
        a.setAttribute("style", "padding-right:5px");
        a.classList = 'glyph glyph-edit';
        var span = document.createElement('span');
        span.classList = "glyphicon glyphicon-plus";
        a.appendChild(span);
        var search = document.getElementById('songs-table_filter');
        search.prepend(a);
    }
    
</script>
<?php $this->load->view('songbook/footer'); ?>