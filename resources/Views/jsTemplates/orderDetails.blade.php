<script id="orderdetails" type="text/html">
    <h1>Order Details</h1>
    <table id='orderdetailsTable' class="table table-striped">
        <thead>
        <tr>
            <th>orderLineNumber</th>
            <th>orderNumber</th>
            <th>priceEach</th>
            <th>productCode</th>
            <th>quantityOrdered</th>
        </tr>
        </thead>
        @{{#orderdetails}}
        <tr>
            <td>@{{orderLineNumber}}</td>
            <td>@{{orderNumber}}</td>
            <td>@{{priceEach}}</td>
            <td>@{{productCode}}</td>
            <td>@{{quantityOrdered}}</td>
        </tr>
        @{{/orderdetails}}
    </table>
</script>