<a href="?do=Add" class="btn btn-success float-right">
    <i class="fa fa-plus"></i> Add New Category
</a>
<br><br>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th class="no-sort"><input type="checkbox" class="checkall"/></th>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Options</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><input type="checkbox" class="checkall"/></th>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Options</th>
            </tr>
        </tfoot>
    </table>
    <br>
    <button onclick="confirmationDel()" class="btn btn-danger float-right delAll" disabled="disabled">Delete All</button>