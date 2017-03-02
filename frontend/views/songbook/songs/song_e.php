<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    <span class="page-label">Song</span>
     <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 padd-0-20">
        <div id="video_frame"  style="display:none; background:#666">
            <video width="100%" class='under_shadow' id="video" controls>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div id="audio_frame">
            <div class="song_album_pic col-xs-12 under_shadow" style="background-image:url(<?php echo $song->album->pic->src; ?>)"></div>
            <audio class="under_shadow" style="width:100%" id="audio" controls>
                <source src="" type="audio/mp3">
            </audio>
         </div>
        <div class="">
            <a onclick="mediaActive('audio')" class="col-xs-6 no-padd"><div id="audio-button" class="center media-label media-label-active padd-5">Audio</div></a>
            <a onclick="mediaActive('video')" class="col-xs-6 no-padd"><div id="video-button" class="media-label padd-5 center ">Video</div></a>
            <ul class="media-playlist inner_layer col-xs-12" id="audio_playlist" class="col-xs-12 inner_layer">
                <div id="audio_options" class="media_options">
                    
                <?php if(isset($audios) && !empty($audios)){ 
                    $x = 1;                                 
                    foreach($audios as $audio){ ?>
                        <li class="" id="<?php echo 'audio_'.$audio->ID; ?>">
                            <a class="media" src="<?php echo $audio->src; ?>">
                                <span class="glyphicon glyphicon-play-circle float-right"></span>
                                <span id="<?php echo 'a_name'.$audio->ID; ?>"><?php echo $audio->name; ?></span>
                                <span id="<?php echo 'a_icon'.$audio->ID; ?>" class="glyphicon glyphicon-edit" onclick="editMediaName(<?php echo $audio->ID; ?>, <?php echo 'a_name'.$audio->ID; ?>, '<?php echo Audio; ?>')"></span>
                                <span onclick="deleteMedia(<?php echo $audio->ID; ?>, <?php echo 'audio_'.$audio->ID; ?>, 'audio')" id="media_icon" class="glyphicon glyphicon-trash"></span>
                            </a>
                        </li>
                <?php $x++;
                    } 
                } else { ?>
                    <li>
                            No Audios.
                    </li>
                    <?php } ?>
                </div>
            </ul>
            <ul class="media-playlist inner_layer col-xs-12" id="video_playlist" class="col-xs-12 inner_layer" style='display:none'>
                <div id="video_options" class="media_options">
                <?php if(isset($videos) && !empty($videos)){ 
                    $x = 1;                                 
                    foreach($videos as $video){ ?>
                        <li class="" id="<?php echo 'video_'.$video->ID; ?>">
                            <a class="media" src="<?php echo $video->src; ?>">
                                <span class="glyphicon glyphicon-play-circle float-right"></span>
                                <span id="<?php echo 'v_name'.$video->ID; ?>"><?php echo $video->name; ?></span>
                                <span id="<?php echo 'v_icon'.$video->ID; ?>" class="glyphicon glyphicon-edit" onclick="editMediaName(<?php echo $video->ID; ?>, <?php echo 'v_name'.$video->ID; ?>, '<?php echo Video; ?>')"></span>
                                <span onclick="deleteMedia(<?php echo $video->ID; ?>, <?php echo 'video_'.$video->ID; ?>, 'video')" id="media_icon" class="glyphicon glyphicon-trash"></span>
                            </a>
                        </li>
                <?php $x++;
                    }
                } else { ?>
                    <li>
                            No Videos.
                    </li>
                    <?php } ?>
                </div>
            </ul>
         </div>
         <div class="col-xs-12 center">
            <div class="left">
                <label class="section-label">Upload Audio</label>
            </div>
            <input class="file-loading" name="file-upload" id="audio-upload" type='file' multiple>
        </div>
                
            <div class="col-xs-12 padd-20-0 center">
            <div class="left">
                <label class="section-label">Upload Video</label>
            </div>
            <input name="file-upload" id="video-upload" type='file' multiple>
        </div>
        
         <div class="col-sm-12 padd-10-0"> 
                <span id="status_id_view">
                    <div data-toggle="tooltip" data-placement="right" title="Status" class="status_badge under_shadow "><span id="status_id_selected"><?php echo $song->status->name; ?></span><a class="glyph glyph-edit" onclick="editHidden('status_id')"><span class="glyphicon glyphicon-edit"></span></a></div>
                </span>
                <div id='status_id_edit' style="display:none">
                    <select class="form-control" id="status_id_input"  style="width:90%; float:left" name="status">
                        <?php foreach($statuses as $status){ ?>
                            <option id='status_id_option_<?php echo $status->ID; ?>' value="<?php echo $status->ID; ?>" <?php if($status->ID == $song->status_id){echo 'selected';} ?>><?php echo $status->name; ?></option>
                        <?php } ?>
                    </select>
                    <div style="float:right; width:10%">
                    <a class="input-ok-glyph" onclick="changeHidden('status_id')">
                        <span class="glyphicon glyphicon-ok"></span>
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 padd-10-0">
                <span id="created_at_view">
                    <div data-toggle="tooltip" data-placement="right" title="Created" class="status_badge under_shadow"><span id="created_at_selected"><?php echo $song->created_at; ?></span><a class="glyph glyph-edit" onclick="editHidden('created_at')"><span class="glyphicon glyphicon-edit"></span></a></div>
                </span>
                <div id='created_at_edit' style="display:none">
                    <div class='input-group date' id='created_at_div' style="width:90%; float:left; color:black">
                        <input type='text' id='created_at_input' class="form-control" value="<?php echo $song->created_at?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div style="float:right; width:10%">
                        <a class="input-ok-glyph" onclick="changeHidden('created_at')">
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 padd-10-0">
                Visibility:
                <input <?php if($song->public_enabled){ echo 'checked'; } ?> id="public_enabled" type="checkbox" data-toggle="toggle" data-on="Public" data-off="Private">
            </div>
            <div class="col-sm-7 padd-10-0">
                Comments:
                <input id='comments_enabled' <?php if($song->comments_enabled){ echo 'checked'; } ?> <?php if(!$song->public_enabled){ echo 'disabled'; } ?> type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled">
            </div>
    </div>
    <div class="title-transbox col-sm-8 col-xs-12">
        <h1>
            <span id="name"><?php echo $song->name ?></span><a id="name_edit" class="glyph glyph-edit" onclick="edit('name')"><span data-toggle="tooltip" data-placement="bottom" title="Title" id="name_icon" class="glyphicon glyphicon-edit"></span></a>
        </h1>
        <h4 class="padd-0-20">    
            <span class="col-xs-6">
            <span id="artist"><?php echo $song->artist ?></span><a id="artist_edit" class="glyph glyph-edit" onclick="edit('artist')"><span data-toggle="tooltip" data-placement="bottom" title="Artist" id="artist_icon" class="glyphicon glyphicon-edit"></span></a>
            </span>

            <span class="col-xs-6">
            <span id="album_id_view">
                <span id="album_id_selected"><?php echo $song->album->name; ?></span><a data-toggle="tooltip" data-placement="bottom" title="Album" class="glyph glyph-edit" onclick="editHidden('album_id')"><span class="glyphicon glyphicon-edit"></span></a>
            </span>
            <div id='album_id_edit' style="display:none;">
                <select class="form-control" id="album_id_input" name="album" style="width:90%; float:left">
                        <option id='album_id_option_none' value="none" selected>No Album</option>
                    <?php foreach($albums as $album){ ?>
                        <option id='album_id_option_<?php echo $album->ID; ?>' value="<?php echo $album->ID; ?>" 
                                <?php if(isset($song->album_id)){
                                        if($album->ID == $song->album_id){
                                            echo 'selected';}
                                }?>><?php echo $album->name; ?></option>
                    <?php } ?>
                </select>
                <a class="input-ok-glyph" onclick="changeHidden('album_id')" style="width:10%; float:right"><span class="glyphicon glyphicon-ok"></span></a>
            </div>
            </span>
        </h4>
    </div>
        <div id="lyric-container" class="col-xs-12 col-sm-8 padd-20 marg-20-40">
            <span id="lyrics_view">
                <span class="lyrics-label">Lyrics</span>
                <div id="scrollable-lyric-container" class="transbox-b-dark lyric-container padd-20-0 col-sm-12">
                    <a style="float:right;" onclick="editHidden('lyrics')"><span class="glyphicon glyphicon-edit"></span></a>
                    <?php echo $song->lyrics->content; ?>
                </div>
            </span>
            <span id="lyrics_edit" style="display:none">
                <span class="section-label" style="float:left; width:10%">Lyrics</span>
                <a style="float:left;" onclick="changeHidden('lyrics')"><span class="glyphicon glyphicon-ok"></span></a>
                <div class="col-xs-12">
                    <textarea style="display:none" id="lyrics_input" name="lyrics_input"><?php echo $song->lyrics->content; ?></textarea>
                </div>
            </span>
        </div>

        <div class="col-xs-12 padd-20-20">
            <div class="col-xs-6 center">
                <a href="<?php echo site_url('songbook/song/v/'.$song->ID) ?>"><input id="about-btn" class="button button-info" value="View"></a>
            </div>
            <div class="col-xs-6 center">
                <a class="confirm" href="<?php echo base_url('songbook/delete_song/'.$song->ID) ?>"> <input id="form-btn" class="button button-info" value="Delete"></a>
            </div>
        </div>    
</div>
</div>
</div>
<script>
    setActive('song');
    $(function() {
        $('.confirm').click(function() {
            return window.confirm("Are you sure you want to delete \"<?php echo $song->name ?>\"? (This can not be undone)");
        });
    });
    
    init();
    init2();
    function init(){
        var current = 0;
        var video = $('#video');
        var audio = $('#audio');
        var playlist = $('#audio_playlist');
        var tracks = playlist.find('li a');
        var len = tracks.length - 1;
        audio[0].volume = .5;
        playlist.find('.glyphicon-play-circle').click(function(e){
            e.preventDefault();
            link = $(this).parent();
            video[0].pause();
            current = link.parent().index();
            run(link, audio[0]);
        });
        audio[0].addEventListener('ended',function(e){
            current++;
            if(current == len){
                current = 0;
                link = playlist.find('a')[0];
            }else{
                link = playlist.find('a')[current];    
            }
            run($(link),audio[0]);
        });
    }
    
    function init2(){
        var current = 0;
        var video = $('#video');
        var audio = $('#audio');
        var playlist = $('#video_playlist');
        var tracks = playlist.find('li a');
        var len = tracks.length - 1;
        video[0].volume = .5;
        playlist.find('.glyphicon-play-circle').click(function(e){
            e.preventDefault();
            link = $(this).parent();
            current = link.parent().index();
            audio[0].pause();
            run(link, video[0]);
        });
        video[0].addEventListener('ended',function(e){
            current++;
            if(current == len){
                current = 0;
                link = playlist.find('a')[0];
            }else{
                link = playlist.find('a')[current];    
            }
            run($(link),audio[0]);
        });
    }
    
    function run(link, player){
            player.src = link.attr('src');
            par = link.parent();
            par.addClass('active').siblings().removeClass('active');
            player.load();
            player.play();
    }
    
    function mediaActive(active){
        if(active == 'video'){
            jQuery('#video-button').addClass('media-label-active');
            jQuery('#audio-button').removeClass('media-label-active');
            jQuery('#video_playlist').show();
            jQuery('#audio_playlist').hide();
            if ($('#video_playlist').find('a.media').length){
                jQuery('#video_frame').show();
                jQuery('#audio_frame').hide();
            }
        } 
        if(active == 'audio'){
            jQuery('#video-button').removeClass('media-label-active');
            jQuery('#audio-button').addClass('media-label-active');
            jQuery('#video_playlist').hide();
            jQuery('#audio_playlist').show();
            jQuery('#video_frame').hide();
            jQuery('#audio_frame').show();
        }
    }
    

</script>
<script type="text/javascript">
    $(function () {
        $('#created_at_div').datetimepicker({
                    format: 'MM/DD/YYYY'
        });
    });
    
    jQuery(document).ready(function(){

    CKEDITOR.replace( 'lyrics_input', {
        uiColor: '#94A8B1',
        height: '550px',
        resize_enabled: true,
        enterMode: CKEDITOR.ENTER_BR
        });
        setActive('song');
    });
    
    $('#public_enabled').change(function(){
        toggle('public_enabled', $(this).prop('checked'));
        if ($(this).prop('checked')){
            $('#comments_enabled').bootstrapToggle('enable');
        } else {
            $('#comments_enabled').bootstrapToggle('disable');
        }
    });
    
    $('#comments_enabled').change(function(){
        toggle('comments_enabled', $(this).prop('checked'));
    });
    
    function toggle(field, value){
        var ajax_url = '<?php echo site_url('songbook/update_song_field'); ?>/' + field + '/' + <?php echo $song->ID; ?>;
        var value = value ? 1 : 0;
        console.log(value);
        jQuery.ajax({
            url: ajax_url,
            method: 'POST',
            data: {update:value},
            success: function(res){
                if( res.result ){
                    console.log('success');
                } else {
                    console.log('failed');
                }
            }
        });
    }
    
    //Audio//
    
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
        var content = value;
        var content_id = item + '_option_' + value;
        var content_div = document.getElementById(content_id);
        if (content_div){
            var content = content_div.innerHTML;
        } if(item == 'lyrics') {
            var value = CKEDITOR.instances['lyrics_input'].getData();
            var content = value;
        }
        var ajax_url = '<?php echo site_url('songbook/update_song_field'); ?>/' + item + '/' + <?php echo $song->ID; ?>;
        console.log(ajax_url);
        jQuery.ajax({
        url: ajax_url,
        method: 'POST',
        data: {update:value},
        success: function(res){
            console.log('success');
            if( res.result ){
                selected.innerHTML = content;
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
        var ajax_url = '<?php echo site_url('songbook/update_song_field'); ?>/' + item + '/' + <?php echo $song->ID; ?>;
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
    
    function editMediaName( mediaId, elementId, type ) {
        var prefix = type.charAt(0);
        var name_div = document.getElementById(prefix + '_name' + mediaId);
        var name = name_div.innerHTML;
        var icon = document.getElementById(prefix + '_icon' + mediaId);
        icon.classList = 'glyphicon glyphicon-ok';
        icon.onclick = function(){ changeMediaName(mediaId, prefix + '_name' + mediaId, type); } ;
        input = createMediaInput(name, mediaId, type);
        name_div.innerHTML = '';
        name_div.appendChild(input);
    }
    
    function createMediaInput(name, mediaId, type){
        var prefix = type.charAt(0);
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("style", "width:200px; margin-right:3px; margin-bottom:5px");
        x.classList = 'black';
        x.setAttribute("id", prefix+"_input"+mediaId);
        x.value = name;
        return x;
    }
    
    function changeMediaName( mediaId, elementId, type ){
        var prefix = type.charAt(0);
        var icon = document.getElementById(prefix + '_icon' + mediaId);
        var input = document.getElementById(prefix + '_input' + mediaId);
        var name_div = document.getElementById(prefix + '_name' + mediaId);
        var value = input.value;
        icon.classList = 'glyphicon glyphicon-edit';
        icon.onclick = function(){ editMediaName(mediaId, prefix + '_name' + mediaId, type); } ;
        var ajax_url = '<?php echo site_url('media/update_name'); ?>/' + mediaId + '/' + type;
            jQuery.ajax({
            url: ajax_url,
            method: 'POST',
            data: {update:value},
            success: function(res){
                if( res.result ){
                    name_div.innerHTML = value;
                }
            }
            });
    }
    
    $("#audio-upload").fileinput({
        browseOnZoneClick:true,         
        showUpload:true,                    
        type:'audio', 
        'showPreview':false, 'showRemove':false,
        uploadUrl:'<?php echo site_url('media/upload/'.Audio.'/'.Song.'/'.$song->ID); ?>', 
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
        'showPreview':false, 'showRemove':false,
        'uploadUrl':'<?php echo site_url('media/upload/'.Video.'/'.Song.'/'.$song->ID); ?>',
        initialPreviewFileType:'video', 
        initialPreviewShowDelete:true,
        browseLabel: "Pick Video",
        browseIcon: '<i class="glyphicon glyphicon-film"></i>',
        uploadClass: "btn btn-info",
        uploadLabel: "Upload",
        removeClass: "btn btn-danger",
        removeLabel: "Delete",
        uploadAsync: true,
        initialPreviewFileType: 'video',
        minFileCount: 1,
        maxFileCount: 5,
        overwriteInitial: false 
    });
    
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>

<?php $this->load->view('songbook/footer'); ?>