@extends('layouts.app')

@section('content')
    <div class="app-main__inner">
        <div class="tab-content">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div id="akun"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="formCoa">
        @csrf
        @method('POST')
        <input type="hidden" name="id_akun" id="id_akun">
        <input type="hidden" name="nama_akun" id="nama_akun">
    </form>
@endsection

@section('script')
    <script>
        $(function() {
            // Data COA Blade to JS
            const data = [
                @foreach ($akun1 as $lev1)
                    {
                        id: '{{ $lev1->kode_akun }}',
                        parent: '#',
                        text: '{{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}'
                    },
                    @foreach ($lev1->akun2 as $lev2)
                        {
                            id: '{{ $lev2->kode_akun }}',
                            parent: '{{ $lev1->kode_akun }}',
                            text: '{{ $lev2->kode_akun }}. {{ $lev2->nama_akun }}'
                        },
                        @foreach ($lev2->akun3 as $lev3)
                            {
                                id: '{{ $lev3->kode_akun }}',
                                parent: '{{ $lev2->kode_akun }}',
                                text: '{{ $lev3->kode_akun }}. {{ $lev3->nama_akun }}'
                            },
                            @foreach ($lev3->rek as $rek)
                                {
                                    id: '{{ $rek->kode_akun }}',
                                    parent: '{{ $lev3->kode_akun }}',
                                    text: '{{ $rek->kode_akun }}. {{ $rek->nama_akun }}'
                                },
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            ];

            // Inisialisasi jsTree
            $('#akun').jstree({
                'core': {
                    'data': data
                }
            });

            // Optional: Saat node dipilih, simpan id & nama
            $('#akun').on("select_node.jstree", function(e, data) {
                const node = data.node;
                $('#id_akun').val(node.id);
                $('#nama_akun').val(node.text);
            });
        });
    </script>
@endsection
