<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Nama Mahasiswa</th>
            <th>Total Absen</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{$item->nama_siswa}}</td>
            <td>{{$item->total_absen}}</td>
            <td>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>