<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Nama Mahasiswa</th>    
            <th>Kelas</th>
            <th>Mata Kuliah</th>
            <th>Kehadiran</th>
            <th>Tugas</th>
            <th>Uts</th>
            <th>Uas</th>
        </tr>
    </thead>
    <tbody>
        <a href="{{route('admin.raport.generatePDF')}}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Export PDF</a>
        @foreach ($collection as $item)
        <tr>
            <td>{{$item->siswa->name}}</td>
            <td>{{$item->room->title}}</td>
            <td>{{$item->course->title}}</td>
            <td>{{$item->kehadiran}}</td>
            <td>{{$item->tugas}}</td>
            <td>{{$item->uts}}</td>
            <td>{{$item->uas}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$collection->links('theme.app.pagination')}}