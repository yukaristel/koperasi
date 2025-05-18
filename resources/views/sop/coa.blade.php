@extends('layouts.app')

@section('content')
<style>
.tree ul {
    padding-top: 10px; 
    position: relative;

    /* garis vertikal antar cabang */
    padding-left: 20px;
}

.tree li {
    list-style-type: none; 
    margin: 0; 
    padding: 10px 5px 0 5px; 
    position: relative;
}

/* Garis vertikal dari parent ke anak */
.tree li::before {
    content: '';
    position: absolute; 
    top: 0; 
    left: -10px; 
    border-left: 1px solid #999; 
    height: 100%;
}

/* Garis horizontal dari parent ke node */
.tree li::after {
    content: '';
    position: absolute; 
    top: 15px; 
    left: -10px; 
    width: 10px; 
    height: 0; 
    border-top: 1px solid #999;
}

/* Hilangkan garis di root */
.tree > ul > li::before,
.tree > ul > li::after {
    content: none;
}
</style>

<div class="app-main__inner">
    <div class="tab-content">
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="tree">
                            <ul>
                                @foreach ($akun1 as $lev1)
                                    <li>
                                        {{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}
                                        @if($lev1->akun2->count())
                                            <ul>
                                                @foreach ($lev1->akun2 as $lev2)
                                                    <li>
                                                        {{ $lev2->kode_akun }}. {{ $lev2->nama_akun }}
                                                        @if($lev2->akun3->count())
                                                            <ul>
                                                                @foreach ($lev2->akun3 as $lev3)
                                                                    <li>
                                                                        {{ $lev3->kode_akun }}. {{ $lev3->nama_akun }}
                                                                        @if($lev3->rek->count())
                                                                            <ul>
                                                                                @foreach ($lev3->rek as $rek)
                                                                                    <li>{{ $rek->kode_akun }}. {{ $rek->nama_akun }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
