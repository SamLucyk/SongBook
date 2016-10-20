<div class='col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 padd-20'>
<table id="songs-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Album</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($songs as $song){ ?>
            <tr>
                <td><?php echo $song->name ?></td>
                <td>1/23/4</td>
                <td>Album name</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<script>
$(document).ready(function() {
    $('#songs-table').DataTable( {
        "info": false,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false
} );
} );
</script>