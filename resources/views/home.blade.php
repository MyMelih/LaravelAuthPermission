@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>
                        Hoş Geldiniz {{ Auth::user()->name }}.
                    </h1>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->isAdmin == 1)
                        <div>
                            <h5>
                                Yapmak İstediğiniz İşlemi Üst Kısımdaki Navbar Kısmından bakabilirsiniz.
                            </h5>
                        </div>
                    @else
                        <div>
                            <h5>
                                Size atanan işlemleri görmek için sağ üst kısımdaki yetkiler kısmına bakabilrisiniz.
                            </h5>
                            <h6>
                                Yada navbardan gördüğünüz işlemleri yapabilirsiniz.
                            </h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
