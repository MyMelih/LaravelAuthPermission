@extends('layouts.app')

@section('content')

@can('roles-listele')
    <div class="container mt-5">
        <div class="mb-2" style="display: flex; justify-content: space-between; align-items: center">
            <h3>Rol Listele</h3>
            @can('roles-ekle')
                <button type="button" class="btn btn-primary" data-toggle="modal" id="rolesYukle" name="rolesYukle">Rol Ekle</button>
            @endcan
        </div>
        <table class="table table-striped table-hover table-sm table-dark table-bordered" id="table" style="padding-top: 20px">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Rol Adı</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


@endcan


{{-- List Modal --}}
@can('roles-detay')
    <div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rolesModalLabel">User Düzenle</h5>
                    <button type="button" id="exitModal" class="btn-close" data-dismi="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="row g-3 row-cols-4">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="col">
                            <label class="form-label">Rol Id</label>
                            <input type="text" class="form-control" id="id" name="id" value=" # " placeholder="Rol Id" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Rol Adı</label>
                            <input type="text" class="form-control" id="name" name="name" value=" # " placeholder="Rol Ismi" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeRolesBtn" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    @can('roles-guncelle')
                        <button type="submit" id="updateRolesBtn" class="btn btn-primary">Güncelle</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endcan

{{-- Ekle Modal --}}
<div class="modal fade" id="rolEkleModal" tabindex="-1" aria-labelledby="rolEkleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rolEkleModalLabel">Role Ekle</h5>
                    <button type="button" id="exitModal" class="btn-close" data-dismi="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" class="row" id="role-form">
                        @csrf
                        <div class="col">
                            <label class="form-label">Rol Adı</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Rol Ismi" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeRolesBtn" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    @can('roles-guncelle')
                        <button type="submit" id="createEkleBtn" class="btn btn-primary">Ekle</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    //Listeleme
    $(document).ready(function(){
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles.listele.data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    //Silme
    $(document).on('click', '#deleteRolesBtn', function(){
        var id = $(this).data('id');
        if(confirm("Silmek istediğinize emin misiniz?")){
            $.ajax({
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/roles/sil/" + id, // Değiştirildi
                success: function(data){
                    $('#table').DataTable().ajax.reload();
                },
                beforeSend: function(){
                    // Taşındı
                }
            });
        }else{
            return false;
        }
    });


    //Modal Yükleme
    $(document).on('click', '#editRolesBtn', function(){
        var id = $(this).data('id');
        $.ajax({
                type: 'GET',
                url: "/roles/detay/"+ $(this).data('id'),
                success: function(data) {
                    $('#rolesModal').modal('show');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                }
            })
    });

    //Modaldaki verileri çekme
    $(document).on('click', '#updateRolesBtn', function(){
        var id = $('#id').val();
        console.log( 'Deneme' + id);
        $.ajax({
            type:'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT'
            },
            url: "/roles/guncelle/" + id,
            data: {
                'id': $('#id').val(),
                'name': $('#name').val(),
            },
            success: function(data) {
                $('#rolesModal').modal('hide');
                $('#table').DataTable().ajax.reload();
                alert('Güncelleme işlemi başarılı');
            }
        });
    });

    // Ekleme Modalı Açma; Ekleme İşlemi
    $(document).on('click', '#rolesYukle', function(){
        $('#rolEkleModal').modal('show');
        $(document).on('click', '#createEkleBtn', function(){
            $.ajax({
                type:"POST",
                url: " {{ route('roles.ekle') }}",
                data: $('#role-form').serialize(),
                success: function(response){
                    alert('Ekleme işlemi başarılı');
                    $('#role-form').trigger("reset");
                    $('#rolEkleModal').modal('hide');
                    $('#table').DataTable().ajax.reload();
                },
                error: function(error){
                    console.log(error);
                    alert("Ekleme işlemi başarısız");
                }
            });
        });
    });



    // Modal kapatma tuşları
    $(document).on('click', '#exitModal, #closeRolesBtn', function() {
                $('#rolesModal').modal('hide');
                $('#rolEkleModal').modal('hide');
    });

        </script>
@endsection
