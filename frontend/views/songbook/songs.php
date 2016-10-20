<div class='col-md-8 col-md-offset-2'>
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
    $('#songs-table').DataTable();
} );
</script>