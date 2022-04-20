<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Mahasiswa</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
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
            <td>
                <a href="javascript:;" onclick="load_input('{{route('guru.attendance.edit',$item->id)}}');" class="btn btn-icon btn-warning"><i class="las la-edit fs-2"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$collection->links('theme.app.pagination')}}