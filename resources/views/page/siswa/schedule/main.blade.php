<x-app-layout title="Data Jadwal">
    <!--begin::Search form-->
    <div id="content_list">
        <div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover" style="background-color: #663259;background-size: auto 100%; background-image: url({{asset('keenthemes/media/misc/taieri.svg')}})">
            <!--begin::body-->
            <div class="card-body container pt-10 pb-8">
                <!--begin::Title-->
                <div class="d-flex align-items-center">
                    <h1 class="fw-bold me-3 text-white">Data Jadwal</h1>
                    <span class="fw-bold text-white opacity-50"></span>
                </div>
                <!--end::Title-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-column">
                    <!--begin::Block-->
                    <div class="d-lg-flex align-lg-items-center">
                        <!--begin::Simple form-->
                        <form id="content_filter">
                            <input type="hidden" class="form-control form-control-flush flex-grow-1" onkeyup="load_list(1);" id="start" name="start" value="{{date('Y-m-d')}}" placeholder="Tanggal..." />
                        </form>
                        <!--end::Simple form-->
                        <!--begin::Action-->
                        <!--end::Action-->
                    </div>
                    <!--end::Block-->
                </div>
                <!--end::Wrapper-->
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
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <div class="col-sm-12 col-md-12">
                                <div class="table-responsive">
                                    <div id="list_result"></div>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
    </div>
    <div id="content_input"></div>
    <div id="content_detail"></div>
    @section('custom_js')
    <script type="text/javascript">
        load_list(1);
    </script>
    @endsection
</x-app-layout>