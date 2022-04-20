<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Upload Skripsi {{$schedule->course->title}}</li>
            <li class="breadcrumb-item px-3 text-white">
                Pertemuan {{$schedule->start_at->format('j F Y')}} - {{$schedule->start_at->format('H:i')}} s/d {{$schedule->end_at->format('H:i')}}
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
                        <input type="hidden" name="task_id" value="{{$task->id}}">
                        <!--begin::Label-->
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="title" class="required form-label">Judul Skripsi</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Judul Tugas" value="{{$task->title}}" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="file" class="required form-label">File Skripsi</label>
                                <input type="file" id="file" name="file" class="form-control form-control-solid" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="due" class="required form-label">Tenggat Waktu</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Tenggat Waktu" value="{{$task->due_at ? $task->due_at->format('Y-m-d') : ''}}" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="mb-10">
                                <label for="description" class="required form-label">Deskripsi Skripsi</label>
                                <textarea class="form-control form-control-solid" placeholder="Deskripsi Tugas" readonly>{{$task->description}}</textarea>
                            </div>
                        </div>
                        <div class="min-w-150px text-end">

                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('siswa.task.store')}}','POST','Simpan');" class="btn btn-primary">Simpan</button>

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
    obj_mindatetimepicker('#due');
</script>