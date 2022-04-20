<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Mata Kuliah</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $item)
        <tr>
            <td>{{$item->course->title}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->description}}</td>
            <td>
                <a href="javascript:;" onclick="load_input('{{route('guru.task.edit',$item->id)}}');" class="btn btn-icon btn-warning"><i class="las la-edit fs-2"></i></a>
                <a href="javascript:;" onclick="handle_delete('{{route('guru.task.destroy',$item->id)}}');" class="btn btn-icon btn-danger"><i class="las la-trash fs-2"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$collection->links('theme.app.pagination')}}