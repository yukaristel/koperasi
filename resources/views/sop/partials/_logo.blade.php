<div class="row">
    <div class="col-md-8">
        <div class="card mt-4 border" data-animation="true">
            <div class="card-body d-flex justify-content-between align-items-end">
                <div>
                    <img src="{{ asset('storage/logo/' . Session::get('logo')) }}" alt="Logo Kecamatan"
                        class="img-fluid shadow border-radius-lg previewLogo" data-logo="{{ Session::get('logo') }}"
                        style="width: 200px; height: auto;">
                </div>
                <div class="text-end">
                    <button class="btn btn-info border-0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        title="Edit" id="EditLogo">Edit Logo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="/pengaturan/logo/{{ $kec->id }}" method="post" enctype="multipart/form-data" id="FormLogo">
    @csrf
    @method('PUT')
    <input type="file" name="logo_kec" id="logo_kec" class="d-none">
</form>
