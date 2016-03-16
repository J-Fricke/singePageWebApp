<script id="orders" type="text/html">
    <h1>Orders</h1>
    <table id='ordersTable' class="table table-striped">
        <thead>
        <tr>
            <th>orderNumber</th>
            <th>orderDate</th>
            <th>customerNumber</th>
            <th>requiredDate</th>
            <th>shippedDate</th>
            <th>status</th>
            <th>comments</th>
        </tr>
        </thead>
        @{{#orders}}
        <tr>
            <td>@{{orderNumber}}</td>
            <td>@{{orderDate}}</td>
            <td>@{{customerNumber}}</td>
            <td>@{{requiredDate}}</td>
            <td>@{{shippedDate}}</td>
            <td>@{{status}}</td>
            <td>@{{comments}}</td>
        </tr>
        @{{/orders}}
    </table>
</script>