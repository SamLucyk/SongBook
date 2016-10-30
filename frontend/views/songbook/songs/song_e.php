<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Song
    <form id="songUpdateForm" action="<?php echo base_url('songbook/update_song/'.$song->ID); ?>" method="post">
        <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
            <h1>
                <div class="form-group">
                    <input type="text" class="form-control" id='name' name="name" style="font-variant: none;" value="<?php echo $song->name ?>" onblur="inputBlur(this)">
                </div>
            </h1>
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
                <label class="control-label">Audios</label>
                <div class="audio-container">
                    <?php foreach($audios as $audio){ ?>
                    <div class="transbox-b col-md-6" id="<?php echo 'audio_'.$audio->ID; ?>">
                    <div><span id="<?php echo 'a_name'.$audio->ID; ?>"><?php echo $audio->name ?> </span><a id="<?php echo 'a_edit'.$audio->ID; ?>" class="glyph glyph-edit" onclick='editAudioName(<?php echo $audio->ID; ?>, <?php echo 'a_name'.$audio->ID; ?>)'><span id="<?php echo 'a_icon'.$audio->ID; ?>" class="glyphicon glyphicon-pencil"></span></a></div>
                    <audio controls>
                        <source src="<?php echo $audio->src ?>" type="audio/mp3">
                    </audio>
                    <a class="glyph" onclick="deleteAudio(<?php echo $audio->ID; ?>, <?php echo 'audio_'.$audio->ID; ?>)"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <?php if(isset($videos) && !empty($videos)){ ?>
                <label class="control-label">Videos</label>
                <div class="video-container">
                    <?php foreach($videos as $video){ ?>
                    <div class="col-md-6" id="<?php echo 'video_'.$video->ID; ?>">
                    <div><span id="<?php echo 'v_name'.$video->ID; ?>"><?php echo $video->name ?> </span><a id="<?php echo 'v_edit'.$video->ID; ?>" class="glyph glyph-edit" onclick='editVideoName(<?php echo $video->ID; ?>, <?php echo 'v_name'.$video->ID; ?>)'><span id="<?php echo 'v_icon'.$video->ID; ?>" class="glyphicon glyphicon-pencil"></span></a></div>
                    <video style="width:300px" class="" controls=""><source src="<?php echo $video->src ?>" type="video/mp4"></video>
                    <a class="glyph" onclick="deleteVideo(<?php echo $video->ID; ?>, <?php echo 'video_'.$video->ID; ?>)"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <div class="col-xs-6 padd-20-0 center">
                    <label class="control-label">Upload Audio</label>
                    <input name="audio-upload" id="audio-upload" type='file'>
                </div>
                
                <div class="col-xs-6 padd-20-0 center">
                    <label class="control-label">Upload Video</label>
                    <input name="video-upload" id="video-upload" type='file'>
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
    
    function deleteAudio( audioId, elementId ) {
        var r = confirm("Are you sure you want to delete this mp3?");
        if (r == true) {
            var ajax_url = '<?php echo site_url('songbook/delete_audio'); ?>/' + audioId;
            jQuery.ajax({
            url: ajax_url,
            method: 'GET',
            success: function(res){
                if( res.result ){
                    elementId.innerHTML = 'Audio Deleted';
                }
            }
            });
        }
    }
    
    function editAudioName( audioId, elementId ) {
        var edit = document.getElementById('a_edit' + audioId);
        var name_div = document.getElementById('a_name' + audioId);
        var name = name_div.innerHTML;
        var icon = document.getElementById('a_icon' + audioId);
        icon.classList = 'glyphicon glyphicon-ok';
        edit.onclick = function(){ changeAudioName(audioId, 'a_name' + audioId); } ;
        input = createAudioInput(name, audioId);
        name_div.innerHTML = '';
        name_div.appendChild(input);
    }
    
    function createAudioInput(name, audioId){
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("style", "width:300px; margin-right:3px; margin-bottom:5px");
        x.classList = 'black';
        x.setAttribute("id", "a_input"+audioId);
        x.value = name;
        return x;
    }
    
    function changeAudioName( audioId, elementId ){
        var edit = document.getElementById('a_edit' + audioId);
        var icon = document.getElementById('a_icon' + audioId);
        var input = document.getElementById('a_input' + audioId);
        var name_div = document.getElementById('a_name' + audioId);
        var new_name = input.value;
        icon.classList = 'glyphicon glyphicon-pencil';
        edit.onclick = function(){ editAudioName(audioId, 'a_name' + audioId); } ;
        var ajax_url = '<?php echo site_url('songbook/update_audio_name'); ?>/' + audioId + '/' + new_name;
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
    
    ///Video///
    
    function deleteVideo( videoId, elementId ) {
        var r = confirm("Are you sure you want to delete this video?");
        if (r == true) {
            var ajax_url = '<?php echo site_url('songbook/delete_video'); ?>/' + videoId;
            jQuery.ajax({
            url: ajax_url,
            method: 'GET',
            success: function(res){
                if( res.result ){
                    elementId.innerHTML = 'Video Deleted';
                }
            }
            });
        }
    }
    
    function editVideoName( videoId, elementId ) {
        var edit = document.getElementById('v_edit' + videoId);
        var name_div = document.getElementById('v_name' + videoId);
        var name = name_div.innerHTML;
        var icon = document.getElementById('v_icon' + videoId);
        icon.classList = 'glyphicon glyphicon-ok';
        edit.onclick = function(){ changeVideoName(videoId, 'v_name' + videoId); } ;
        input = createVideoInput(name, videoId);
        name_div.innerHTML = '';
        name_div.appendChild(input);
    }
    
    function createVideoInput(name, videoId){
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("style", "width:300px; margin-right:3px; margin-bottom:5px");
        x.classList = 'black';
        x.setAttribute("id", "v_input"+videoId);
        x.value = name;
        return x;
    }
    
    function changeVideoName( videoId, elementId ){
        var edit = document.getElementById('v_edit' + videoId);
        var icon = document.getElementById('v_icon' + videoId);
        var input = document.getElementById('v_input' + videoId);
        var name_div = document.getElementById('v_name' + videoId);
        var new_name = input.value;
        icon.classList = 'glyphicon glyphicon-pencil';
        edit.onclick = function(){ editVideoName(videoId, 'v_name' + videoId); } ;
        var ajax_url = '<?php echo site_url('songbook/update_video_name'); ?>/' + videoId + '/' + new_name;
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
    
    $("#audio-upload").fileinput({'showUpload':false, 'type':'audio', 'uploadUrl':'<?php echo site_url('songbook/upload_audio')  ; ?>/<?php echo $song->ID; ?>'});
    $("#video-upload").fileinput({'showUpload':false, 'type':'video', 'maxFileSize': 0, 'maxPreviewFileSize': 0, 'uploadUrl':'<?php echo site_url('songbook/upload_video')  ; ?>/<?php echo $song->ID; ?>'});
</script>
<?php $this->load->view('footer'); ?>