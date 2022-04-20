<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Upload File</li>
            <li class="breadcrumb-item px-3 text-white">
                Tugas {{$task->title}}
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
                                <label for="pelajaran" class="required form-label">Tugas</label>
                                <input type="hidden" name="task" class="form-control" readonly value="{{$task->id}}">
                                <input type="text" class="form-control" readonly value="{{$task->title}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="file" class="required form-label">Tenggat Waktu</label>
                                <input type="text" id="due" name="due" class="form-control form-control-solid" placeholder="Tanggal Tenggat" value="{{$task_detail->due_at}}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-10">
                                <label for="file" class="required form-label">File</label>
                                <input type="file" name="file" class="form-control form-control-solid" placeholder="File" />
                            </div>
                        </div>
                        <div class="min-w-150px text-end">
                            @if ($task_detail->id)
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.task_detail.update',$task_detail->id)}}','PATCH','Simpan');" class="btn btn-primary">Simpan</button>
                            @else
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.task_detail.store')}}','POST','Simpan');" class="btn btn-primary">Simpan</button>
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
    obj_mindatetimepicker('#due');
</script>