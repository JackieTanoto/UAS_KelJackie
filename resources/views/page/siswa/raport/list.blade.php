<table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Kelas</th>
            <th>Mata Kuliah</th>
            <th>Kehadiran</th>
            <th>Tugas</th>
            <th>Uts</th>
            <th>Uas</th>
            <th>Nilai Akhir</th>
            <th>Predikat</th>
        </tr>
    </thead>
    <tbody>
        <a href="{{route('siswa.raport.generatePDF')}}" class="btn btn-sm btn-primary"><i class="bi bi-download"></i> Export PDF</a><br>
        <h4><center>Nama Siswa : {{ Auth::user()->name}}</center></h4>
        <h4><center>Nim : {{ Auth::user()->nim}}</center></h4>
        @foreach ($collection as $item)
        <tr>
            <td>{{$item->room->title}}</td>
            <td>{{$item->course->title}}</td>
            <td>{{$item->kehadiran}}</td>
            <td>{{$item->tugas}}</td>
            <td>{{$item->uts}}</td>
            <td>{{$item->uas}}</td>
            @php
					$total = (($item->tugas+$item->uts)+($item->uas))/3;
					if($total>=90){
						$hasil = 'A';
					}else if($total<90 && $total>=80){
						$hasil = 'B';
					}
					else if($total<80 && $total>=70){
						$hasil = 'C';
					}
					else{
						$hasil = 'D';
					}
			@endphp
			<td>{{number_format($total)}}</td>
			<td>{{$hasil}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$collection->links('theme.app.pagination')}}