<html>
<head>
	<title>Laporan Data Nilai PDF</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Data Nilai Mahasiswa</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
                <th>No</th>
                <th>Mahasiswa</th>    
                <th>Kelas</th>
                <th>Mata Kuliah</th>
                <th>Kehadiran</th>
                <th>Tugas</th>
                <th>Uts</th>
                <th>Uas</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($raport as $item)
			<tr>
				<td>{{ $i++ }}</td>
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
 
</body>
</html>