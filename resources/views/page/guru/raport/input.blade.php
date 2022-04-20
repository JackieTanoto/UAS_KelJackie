<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Data Nilai</li>
            <li class="breadcrumb-item px-3 text-white">
                @if ($raport->id)
                    Update Data
                @else
                    Tambah Data
                @endif
            </li>
            <li class="breadcrumb-item pe-3 "><a href="javascript:;" onclick="load_list(1);" class="pe-3 text-white">Kembali</a></li>
        </ol>
        <!--end::Title-->
    </div>
    <!--end::body-->
</div>
<!--end::Search form-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container" id="kt_content_container">
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Row-->
                <form id="form_input">
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="pelajaran" class="required form-label">Mata Kuliah</label>
                                <select data-control="select2" data-placeholder="Pilih Pelajaran" id="pelajaran" name="courses_id" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Mata Kuliah</option>
                                    @foreach ($course as $item)
                                        <option value="{{$item->id}}" {{$raport->courses_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="pelajaran" class="required form-label">Kelas</label>
                                <select data-control="select2" data-placeholder="Pilih Kelas" id="kelas" name="kelas_id" class="form-select form-select-solid">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="pelajaran" class="required form-label">Nama Mahasiswa</label>
                                <select data-control="select2" data-placeholder="Pilih Siswa" id="siswa" name="siswa_id" class="form-select form-select-solid">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="kehadiran" class="required form-label">Kehadiran</label>
                                <input type="text" class="form-control form-control-solid" readonly name="kehadiran" id="kehadiran">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Nilai Tugas</label>
                                <input type="text" id="tugas" name="tugas" class="form-control form-control-solid" value="{{$raport->tugas}}"/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Nilai PTS</label>
                                <input type="text" id="uts" name="uts" class="form-control form-control-solid" value="{{$raport->uts}}"/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Nilai PAS</label>
                                <input type="text" id="uas" name="uas" class="form-control form-control-solid" value="{{$raport->uas}}"/>
                            </div>
                        </div>
                        <div class="min-w-150px text-end">
                            @if ($raport->id)
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.raport.update',$raport->id)}}','PATCH','Simpan');" class="btn btn-primary">Simpan</button>
                            @else
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.raport.store')}}','POST','Simpan');" class="btn btn-primary">Simpan</button>
                            @endif
                        </div>
                        <!--end::Col-->
                    </div>
                </form>
                <!--end::Row-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<script>
    @if($raport->courses_id)
    $('#pelajaran').val('{{$raport->courses_id}}');
    setTimeout(function(){ 
        $('#pelajaran').trigger('change');
        setTimeout(function(){ 
            $('#kelas').val('{{$raport->kelas_id}}');
            $('#kelas').trigger('change');
            setTimeout(function(){ 
                $('#siswa').val('{{$raport->siswa_id}}');
            }, 2000);
            $('#kelas').trigger('change');
            setTimeout(function(){ 
                $('#kehadiran').val('{{$raport->siswa_id}}');
            }, 2000)
        }, 2000);
    }, 1000);
    @endif
    $("#pelajaran").change(function(){
        $.ajax({
            type: "POST",
            url: '{{route('guru.raport.list_kelas')}}',
            data: {pelajaran : $("#pelajaran").val()},
            success: function(response){
                $("#kelas").html(response);
            }
        });
    });
    $("#kelas").change(function(){
        $.ajax({
            type: "POST",
            url: '{{route('guru.raport.list_siswa')}}',
            data: {kelas : $("#kelas").val()},
            success: function(response){
                $("#siswa").html(response);
            }
        });
    });
    $("#siswa").change(function(){
        $.ajax({
            type: "POST",
            url: '{{route('guru.raport.getKehadiran')}}',
            data: {
                pelajaran : $("#pelajaran").val(),
                kelas : $("#kelas").val(),
                siswa : $("#siswa").val()
            },
            success: function(response){
                $("#kehadiran").val(response);
            }
        });
    });
</script>