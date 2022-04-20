<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Data Tugas</li>
            <li class="breadcrumb-item px-3 text-white">
                @if ($task->id)
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
                                <select data-control="select2" data-placeholder="Pilih Pelajaran" name="courses_id" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Mata Kuliah</option>
                                    @foreach ($course as $item)
                                        <option value="{{$item->id}}" {{$task->course_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="pelajaran" class="required form-label">Kelas</label>
                                <select data-control="select2" data-placeholder="Pilih Kelas" name="kelas_id" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Kelas</option>
                                    @foreach ($room as $item)
                                        <option value="{{$item->id}}" {{$item->class_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="pelajaran" class="required form-label">Nama Mahasiswa</label>
                                <select data-control="select2" data-placeholder="Pilih Siswa" name="siswa_id" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Mahasiswa</option>
                                    @foreach ($user as $item)
                                        <option value="{{$item->id}}" {{$item->user_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Kehadiran</label>
                                <input type="text" id="kehadiran" name="kehadiran" class="form-control form-control-solid" placeholder="Kehadiran"/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Nilai Tugas</label>
                                <input type="text" id="tugas" name="tugas" class="form-control form-control-solid" placeholder="Nilai Tugas"/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Nilai UTS</label>
                                <input type="text" id="uts" name="uts" class="form-control form-control-solid" placeholder="Nilai UTS"/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Nilai UAS</label>
                                <input type="text" id="uas" name="uas" class="form-control form-control-solid" placeholder="Nilai UAS"/>
                            </div>
                        </div>
                        <div class="min-w-150px text-end">

                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.raport.store')}}','POST','Simpan');" class="btn btn-primary">Simpan</button>

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