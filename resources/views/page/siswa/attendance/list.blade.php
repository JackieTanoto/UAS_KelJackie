<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Siswa</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        @php
        $status = $item->st;
        if($status == "h"){
            $status = "Hadir";
        }else{
            $status = "Alfa";
        }
        @endphp
        <tr>
            <td>{{$item->siswa->name}}</td>
            <td>{{$item->present_at->format("j F Y H:i")}}</td>
            <td>{{$status}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$collection->links('theme.app.pagination')}}