<script id="payments" type="text/html">
    <h1>Payments</h1>
    <table id='paymentsTable' class="table table-striped">
        <thead>
        <tr>
            <th>checkNumber</th>
            <th>customerNumber</th>
            <th>paymentDate</th>
            <th>amount</th>
        </tr>
        </thead>
        @{{#payments}}
        <tr>
            <td>@{{checkNumber}}</td>
            <td>@{{customerNumber}}</td>
            <td>@{{paymentDate}}</td>
            <td>@{{amount}}</td>
        </tr>
        @{{/payments}}
    </table>
</script>