<ul class="nav nav-tabs" >
    <li role="presentation"><a href="./<?php echo MODULE_LINK ?>">url</a></li>
    <li role="presentation" class="active"><a href="./<?php echo MODULE_LINK ?>&action=manage_ip/ip">ip</a></li>
</ul>
<form action="" method="post" enctype="multipart/form-data" class="form-inline" style="margin:20px">
    <div class="form-group">
    <input type="text" name="ip" class="form-control">
    <select name="status" class="form-control">
        <option value="blocked">blocked</option>
        <option value="open">open</option>
    </select>
    <input type="submit" class="btn btn-info" value="add">
    </div>
    <div class="form-group import">
    <input type="file" class="import_excel" name="import_excel" value="import">
    <input type="submit" class="btn btn-info btn-import" value="import">
    </div>

</form>
<form action="" method="post">
    <table class="table table-striped">
        <thead>
        <th>url</th>
        <th>status</th>
        <th>created at</th>
        <th>option</th>
        </thead>
        <?php collect($ips)->each(function ($ip) { ?>
            <tr>
                <td><?php echo $ip->ip ?></td>
                <td><?php echo $ip->status ?></td>
                <td><?php echo $ip->created_at ?></td>
                <td>
                    <input type="checkbox" class="btn btn-danger" name="removes[]" value="<?php echo $ip->id ?>">
                </td>
            </tr>
        <?php }); ?>
    </table>
    <input type="submit" class="btn btn-danger" value="remove">
</form>

<script>
    $('.btn-import').on('click', function (e) {
        e.preventDefault();
        var file_data = $('.import_excel').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: "/whmcs/admin/<?php echo MODULE_LINK?>&action=manage_ip/import_ip",
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (result) {
                location.reload();
            }
        });
    });
</script>
