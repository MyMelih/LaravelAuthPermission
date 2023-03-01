@extends('layouts.app')

@section('content')

@can('roles-ekle')
    <div class="container mt-3">
        <div class="row justify-content-center mt-5">
            <div class="col-sm-12 mt-4">
                <div class="p-5 border-2 border border-secondary rounded">
                    <h2>Kullanıcı Rol Ekleme</h2>
                    <hr>
                    <form class="row g-3" action="{{ route('roles.ekle') }}" method="post">
                        @csrf
                        <div class="col">
                            <label for="validationServer01" class="form-label">Rol Adı giriniz</label>
                            <input type="text" class="form-control" id="validationServer01" name="name" placeholder="Role Giriniz" required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary float-end" type="submit" value="Gönder">Kayıtı
                                Tamamlayın
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan

@endsection
