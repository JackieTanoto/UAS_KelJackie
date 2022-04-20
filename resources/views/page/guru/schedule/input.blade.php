<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Data Jadwal</li>
            <li class="breadcrumb-item px-3 text-white">
                @if ($schedule->id)
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
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="pelajaran" class="required form-label">Mata Kuliah</label>
                                <select data-control="select2" data-placeholder="Pilih Pelajaran" name="pelajaran" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Mata Kuliah</option>
                                    @foreach ($course as $item)
                                        <option value="{{$item->id}}" {{$schedule->course_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="kelas" class="required form-label">Kelas</label>
                                <select data-control="select2" data-placeholder="Pilih Kelas" name="kelas" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{$item->id}}" {{$schedule->class_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="url" class="required form-label">Link Room</label>
                                <input type="text" id="url" name="url" class="form-control form-control-solid" placeholder="Link Room" value="{{$schedule->url}}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="name" class="required form-label">Tanggal</label>
                                <input type="text" id="tanggal" name="tanggal" class="form-control form-control-solid" placeholder="Tanggal" value="{{$schedule->start_at ? $schedule->start_at->format('Y-m-d') : ''}}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="mulai" class="required form-label">Jam Mulai</label>
                                <input type="text" id="mulai" name="mulai" class="form-control form-control-solid" placeholder="Jam Mulai" value="{{$schedule->start_at ? $schedule->start_at->format('H:i') : ''}}"/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="selesai" class="required form-label">Jam Selesai</label>
                                <input type="text" id="selesai" name="selesai" class="form-control form-control-solid" placeholder="Jam Selesai" value="{{$schedule->end_at ? $schedule->end_at->format('H:i') : ''}}"/>
                            </div>
                        </div>
                        <div class="min-w-150px text-end">
                            @if ($schedule->id)
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.schedule.update',$schedule->id)}}','PATCH','Simpan');" class="btn btn-primary">Simpan</button>
                            @else
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.schedule.store')}}','POST','Simpan');" class="btn btn-primary">Simpan</button>
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
<script type="text/javascript">
    obj_datepicker('#tanggal');
    time_picker('#mulai','00:00');
    $('#mulai').on('change', function() {
        let val = this.value;
        val = val.split(":");
        val = parseInt(val[0]) + parseInt(1);
        time_picker('#selesai',val+':00');
    });
</script>