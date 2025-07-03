<table class="table">
    <thead>
        <th>Title</th>
        <th>Sku</th>
        <th>Qty</th>
        <th>Category</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ( $data as  $val)
            <tr>
                <td> {{$val['title']}}</td>
                <td> {{$val['sku']}}</td>
                <td> {{$val['qty']}}</td>
                <td> {{$val['category']['title']}}</td>
                <td><button class="edit" data-id="{{$val['id']}}" data-product="{{json_encode($val)}}">Edit</button><button class="delete" data-id="{{$val['id']}}">Delete</button></td>
            </tr>            
        @endforeach
    </tbody>
</table>