<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Nama Kelas</th>
            <th>Mata Kuliah</th>
            <th>Total Jadwal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{$item->kelas}}</td>
            <td>{{$item->pelajaran}}</td>
            <td>{{$item->total_jadwal}}</td>
            <td>
                <a href="{{route('guru.room.show',$item->id)}}">Data  Mahasiswa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>