<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Mahasiswa</th>    
            <th>Tugas</th>
        </tr>
    </thead>
    <tbody>
        @if($collection->count()>0)
          <a href="{{route('guru.task.tugas', $task->id)}}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Download</a>
        @endif
        @foreach ($collection as $item)
        <tr>
            <td>{{$item->siswa->name}}</td>
            <td>{{$item->task->title}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$collection->links('theme.app.pagination')}}