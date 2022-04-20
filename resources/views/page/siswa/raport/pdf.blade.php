<html>
<head>
	<title>Laporan Data Nilai Mahasiswa</title>
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
		<h5>Laporan Data Nilai Mahasiswa</h5>
	</center><br>
	<h5><center>Nama Siswa : {{ Auth::user()->name}}</center></hh54>
	<h5><center>NISN : {{ Auth::user()->nisn}}</center></h5>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
                <th>No</th> 
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
			@php $i=1 @endphp
			@foreach($raport as $item)
			<tr>
				<td>{{ $i++ }}</td>
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
 
</body>
</html>