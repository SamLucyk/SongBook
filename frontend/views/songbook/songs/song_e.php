<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Song
    <form id="songUpdateForm" action="<?php echo base_url('songbook/update_song/'.$song->ID); ?>" method="post">
        <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
            <h1>
                <span id="name"><?php echo $song->name ?></span><a id="name_edit" class="glyph glyph-edit" onclick="edit('name')"><span id="name_icon" class="glyphicon glyphicon-pencil"></span></a>
            </h1>
            <h4>By 
                <span id="artist"><?php echo $song->artist ?></span><a id="artist_edit" class="glyph glyph-edit" onclick="edit('artist')"><span id="artist_icon" class="glyphicon glyphicon-pencil"></span></a></h4>
        </div>
        <div class="padd-20 col-xs-12">
            <div class="col-md-12">
            <div class="col-md-4">
                <h3>Status: 
                    <div class="form-group">
                        <select class="form-control" id="status" name="status">
                            <?php foreach($statuses as $status){ ?>
                                <option value="<?php echo $status->ID; ?>" <?php if($status->ID == $song->status_id){echo 'selected';} ?>><?php echo $status->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3>Album: 
                    <div class="form-group">
                        <select class="form-control" id="album" name="album">
                                <option value="none" selected>No Album</option>
                            <?php foreach($albums as $album){ ?>
                                <option value="<?php echo $album->ID; ?>" 
                                        <?php if(isset($song->album_id)){
                                                if($album->ID == $song->album_id){
                                                    echo 'selected';}
                                        }?>><?php echo $album->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3>Created: 
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1' style="color:black">
                            <input type='text' name='created_at' class="form-control" value="<?php echo $song->created_at?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </h3>
            </div>
                
            <div class="padd-20 col-md-12 center">
                <?php if(isset($audios) && !empty($audios)){ ?>
                <label class="control-label">Audio</label>
                <div class="audio-container">
                    <?php foreach($audios as $audio){ ?>
                    <div class="transbox-b col-md-6" id="<?php echo 'audio_'.$audio->ID; ?>">
                    <div><span id="<?php echo 'a_name'.$audio->ID; ?>"><?php echo $audio->name ?> </span><a id="<?php echo 'a_edit'.$audio->ID; ?>" class="glyph glyph-edit" onclick="editMediaName(<?php echo $audio->ID; ?>, <?php echo 'a_name'.$audio->ID; ?>, '<?php echo Audio; ?>')"><span id="<?php echo 'a_icon'.$audio->ID; ?>" class="glyphicon glyphicon-pencil"></span></a></div>
                    <audio controls>
                        <source src="<?php echo $audio->src ?>" type="audio/mp3">
                    </audio>
                    <a class="glyph" onclick="deleteMedia(<?php echo $audio->ID; ?>, <?php echo 'audio_'.$audio->ID; ?>, 'audio')"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <?php if(isset($videos) && !empty($videos)){ ?>
                <label class="control-label">Videos</label>
                <div class="video-container">
                    <?php foreach($videos as $video){ ?>
                    <div class="col-md-6" id="<?php echo 'video_'.$video->ID; ?>">
                    <div><span id="<?php echo 'v_name'.$video->ID; ?>"><?php echo $video->name ?> </span><a id="<?php echo 'v_edit'.$video->ID; ?>" class="glyph glyph-edit" onclick="editMediaName(<?php echo $video->ID; ?>, <?php echo 'v_name'.$video->ID; ?>, '<?php echo Video ?>')"><span id="<?php echo 'v_icon'.$video->ID; ?>" class="glyphicon glyphicon-pencil"></span></a></div>
                    <video style="width:300px" class="" controls=""><source src="<?php echo $video->src ?>" type="video/mp4"></video>
                    <a class="glyph" onclick="deleteMedia(<?php echo $video->ID; ?>, <?php echo 'video_'.$video->ID; ?>, 'video')"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <div class="col-xs-6 padd-20-0 center">
                    <label class="control-label">Upload Audio</label>
                    <input class="file-loading" name="file-upload" id="audio-upload" type='file' multiple>
                </div>
                
                <div class="col-xs-6 padd-20-0 center">
                    <label class="control-label">Upload Video</label>
                    <input name="file-upload" id="video-upload" type='file' multiple>
                </div>
                
            </div>
            <div class="col-md-10 col-md-offset-1 padd-20-20">
                <div class="form-group col-sm-12">
                    <label for="lyrics"><h3>Lyrics</h3></label><br/>
                    <textarea id="lyrics" name="lyrics"><?php echo $song->lyrics->content; ?></textarea>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 padd-40-20">
                <div class="col-md-6 center">
                    <a onclick='updateSong()'><input id="about-btn" class="button button-info" value="Save"></a>
                </div>
                <div class="col-md-6 center">
                    <a href="<?php echo base_url('songbook/song/v/'.$song->ID) ?>"> <input id="form-btn" class="button button-info" value="Cancel"></a>
                </div>
            </div>  
        </div>
        </div>
        </form>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
                    format: 'MM/DD/YYYY'
        });
    });
    
    function updateSong() {
        document.getElementById("songUpdateForm").submit();
    }
    
    ///Audio///
    
    function deleteMedia( audioId, elementId, type ) {
        var r = confirm("Are you sure you want to delete this?");
        if (r == true) {
            var ajax_url = '<?php echo site_url('media/delete'); ?>/' + audioId + '/' + type;
            console.log(ajax_url);
            jQuery.ajax({
            url: ajax_url,
            method: 'GET',
            success: function(res){
                if( res.result ){
                    elementId.innerHTML = 'Item Deleted';
                }
            }
            });
        }
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
        var new_name = input.value;
        icon.classList = 'glyphicon glyphicon-pencil';
        edit_div.onclick = function(){ edit(item); } ;
        var ajax_url = '<?php echo site_url('songbook/update_song_field'); ?>/' + item + '/' + <?php echo $song->ID; ?> + '/' + new_name;
        jQuery.ajax({
        url: ajax_url,
        method: 'GET',
        success: function(res){
            if( res.result ){
                console.log('success');
                name_div.innerHTML = new_name;
            }
        }
        });
    }
    
    function editMediaName( mediaId, elementId, type ) {
        var prefix = type.charAt(0);
        var edit = document.getElementById(prefix + '_edit' + mediaId);
        var name_div = document.getElementById(prefix + '_name' + mediaId);
        var name = name_div.innerHTML;
        var icon = document.getElementById(prefix + '_icon' + mediaId);
        icon.classList = 'glyphicon glyphicon-ok';
        edit.onclick = function(){ changeMediaName(mediaId, prefix + '_name' + mediaId, type); } ;
        input = createMediaInput(name, mediaId, type);
        name_div.innerHTML = '';
        name_div.appendChild(input);
    }
    
    function createMediaInput(name, mediaId, type){
        var prefix = type.charAt(0);
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("style", "width:300px; margin-right:3px; margin-bottom:5px");
        x.classList = 'black';
        x.setAttribute("id", prefix+"_input"+mediaId);
        x.value = name;
        return x;
    }
    
    function changeMediaName( mediaId, elementId, type ){
        var prefix = type.charAt(0);
        var edit = document.getElementById(prefix + '_edit' + mediaId);
        var icon = document.getElementById(prefix + '_icon' + mediaId);
        var input = document.getElementById(prefix + '_input' + mediaId);
        var name_div = document.getElementById(prefix + '_name' + mediaId);
        var new_name = input.value;
        icon.classList = 'glyphicon glyphicon-pencil';
        edit.onclick = function(){ editMediaName(mediaId, prefix + '_name' + mediaId, type); } ;
        var ajax_url = '<?php echo site_url('media/update_name'); ?>/' + mediaId + '/' + new_name + '/' + type;
            jQuery.ajax({
            url: ajax_url,
            method: 'GET',
            success: function(res){
                if( res.result ){
                    name_div.innerHTML = new_name;
                }
            }
            });
    }

    jQuery(document).ready(function(){

    CKEDITOR.replace( 'lyrics', {
        uiColor: '#94A8B1',
        height: '500px'
    });

    });
    
    $("#audio-upload").fileinput({
        browseOnZoneClick:true,         
        showUpload:true,                    
        type:'audio', 
        uploadUrl:'<?php echo site_url('media/upload/'.Audio.'/'.$song->ID); ?>', 
        initialPreviewFileType:'audio', 
        initialPreviewShowDelete:true,
        browseLabel: "Pick Audio",
        browseIcon: '<i class="glyphicon glyphicon-music"></i>',
        uploadClass: "btn btn-info",
        uploadLabel: "Upload",
        removeClass: "btn btn-danger",
        removeLabel: "Delete",
        uploadAsync: true,
        initialPreviewFileType: 'audio',
        minFileCount: 1,
        maxFileCount: 5,
        overwriteInitial: false 
    });
    
    $("#video-upload").fileinput({
        'browseOnZoneClick':true, 
        'showUpload':true, 
        'type':'video', 
        'maxFileSize': 0, 
        'maxPreviewFileSize': 0, 
        'uploadUrl':'<?php echo site_url('media/upload/'.Video.'/'.$song->ID); ?>',
        'browseLabel': "Pick Video",
        'browseIcon': '<i class="glyphicon glyphicon-film"></i>',
    });
</script>
<?php $this->load->view('footer'); ?>