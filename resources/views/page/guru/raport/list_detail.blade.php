<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Data Nilai</li>
            <li class="breadcrumb-item px-3 text-white">
                @if ($raport)
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
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($course as $item)
                                <label for="url" class="required form-label">Pelajaran</label>
                                <input type="text" id="courses_id" name="courses_id" class="form-control form-control-solid" placeholder="Pelajaran" value="{{$item->title}}" readonly/>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($room as $item)
                                <label for="url" class="required form-label">Kelas</label>
                                <input type="text" id="kelas_id" name="kelas_id" class="form-control form-control-solid" placeholder="Kelas" value="{{$item->title}}" readonly/>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($user as $item)
                                <label for="url" class="required form-label">Nama Mahasiswa</label>
                                <input type="text" id="siswa_id" name="siswa_id" class="form-control form-control-solid" placeholder="Siswa" value="{{$item->name}}" readonly/>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($raport as $item)
                                <label for="url" class="required form-label">Kehadiran</label>
                                <input type="text" id="kehadiran" name="kehadiran" class="form-control form-control-solid" placeholder="{{$item->kehadiran}}"/>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($raport as $item)
                                <label for="url" class="required form-label">Tugas</label>
                                <input type="text" id="tugas" name="tugas" class="form-control form-control-solid" placeholder="{{$item->tugas}}"/>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($raport as $item)
                                <label for="url" class="required form-label">UTS</label>
                                <input type="text" id="uts" name="uts" class="form-control form-control-solid" placeholder="{{$item->uts}}"/>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                            @foreach ($raport as $item)
                                <label for="url" class="required form-label">UAS</label>
                                <input type="text" id="uas" name="uas" class="form-control form-control-solid" placeholder="{{$item->uas}}"/>
                            @endforeach
                            </div>
                        </div>
                        <div class="min-w-150px text-end">
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.raport.update', $item->id)}}','POST','Simpan');" class="btn btn-primary">Simpan</button>
                        </div>
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