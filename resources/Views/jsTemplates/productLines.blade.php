<script id="productlines" type="text/html">
    <h1>Product Lines</h1>
    <table id='productlinesTable' class="table table-striped">
        <thead>
        <tr>
            <th>htmlDescription</th>
            <th>image</th>
            <th>productLine</th>
            <th>textDescription</th>
        </tr>
        </thead>
        @{{#productlines}}
        <tr>
            <td>@{{htmlDescription}}</td>
            <td>@{{image}}</td>
            <td>@{{productLine}}</td>
            <td>@{{textDescription}}</td>
        </tr>
        @{{/productlines}}
    </table>
</script>