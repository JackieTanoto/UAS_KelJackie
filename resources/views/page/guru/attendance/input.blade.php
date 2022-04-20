<div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
    <!--begin::body-->
    <div class="card-body container pt-10 pb-8">
        <!--begin::Title-->
        <ol class="breadcrumb text-muted fs-6 fw-bold">
            <li class="breadcrumb-item pe-3 text-white">Absen {{$attendance->schedule->start_at->format("j F Y H:i")}} {{$attendance->siswa->name}}</li>
            <li class="breadcrumb-item px-3 text-white">
                @if ($attendance->id)
                    Update Data
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
                                <label for="st" class="required form-label">Status</label>
                                <select data-control="select2" data-placeholder="Pilih Status" name="st" class="form-select form-select-solid">
                                    <option SELECTED DISABLED>Pilih Status</option>
                                    <option value="h" {{$attendance->st == "h"? 'selected' : ''}}>Hadir</option>
                                    <option value="a" {{$attendance->st == "a" ? 'selected' : ''}}>Alfa</option>
                                </select>
                            </div>
                        </div>
                        <div class="min-w-150px text-end">
                            @if ($attendance->id)
                            <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('guru.attendance.update',$attendance->id)}}','PATCH','Simpan');" class="btn btn-primary">Simpan</button>
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