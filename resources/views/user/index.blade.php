@extends('layouts.app')

@section('content')
    @can('user-listele')
        <div class="container mt-5">
            <div>
                <h1 style="display: flex; justify-content: center">Kullanıcılar</h1>
            </div>
            <table class="table table-striped table-hover table-sm table-dark table-bordered" id="table" style="padding-top: 20px">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Adı</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    @endcan


    <!-- Modal -->
    @can('user-detay')
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">User Düzenle</h5>
                        <button type="button" id="exitModal" class="btn-close" data-dismi="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" class="row g-3 ">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="id" id="id">
                            <div class="col">
                                <label class="form-label">Kullanıcı Ismi</label>
                                <input type="text" class="form-control" id="name" name="name" value=" # " placeholder="Kullanıcı Ismi" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Kullanıcı Email</label>
                                <input type="email" class="form-control" id="email" name="email" value=" # " placeholder="Kullanıcı Email" disabled >
                            </div>
                            <div class="col">
                                <label class="form-label">Kullanıcı Rolü</label>
                                <select class="form-select" id="isAdmin" type="text" name="isAdmin" required>
                                    <option value="">Rolü Seçin</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="roles">Yetkileri:</label><br>
                                <div class="row">
                                    @foreach ($roles as $role)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" id="{{ $role->id }}" name="roles[]" value="{{ $role->id }}" class="form-check-input">
                                            <label for="{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeUserBtn" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        @can('user-guncelle')
                            <button type="submit" id="updateUserBtn" class="btn btn-primary">Güncelle</button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //Listeleme
        $(document).ready(function() {
            $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('user.listele.data') }}",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'isAdmin', name: 'isAdmin', render: function(data) {
                        return (data == 1) ? 'Admin' : 'User'; }},
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ]
            });
        });

        //Silme
        $(document).on('click', '#deleteUserBtn', function(){
            var id = $(this).attr('id');
            if(confirm("Kullanıcıyı silmek isteğinizi onaylıyor musunuz?")) {
                $.ajax({
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/user/sil/"+ $(this).data('id'),
                    beforeSend: function() {
                        $('#table').DataTable().ajax.reload();
                    },
                    success: function(data) {
                        setTimeout(function (params) {
                            $('#table').DataTable().ajax.reload();
                            alert('Kullanıcı Silindi');
                        }, 2000);
                    }
                });
            } else {
                return false;
            }
        });

        // Modal yükleme
        $(document).on('click', '#editUserBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $.ajax({
                type: 'POST',
                url: "/user/detay/"+ $(this).data('id'),
                success: function(data) {
                    $('#userModal').modal('show');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#isAdmin').val(data.isAdmin);

                    $.ajax({
                        type: 'GET',
                        url: "/user/roles/"+ id,
                        success: function(roles) {
                            roles.forEach(function(role_id) {
                                $('#' + role_id).prop('checked', true);
                            });
                        }
                    })
                }
            })
        });


        // Modal user güncelleme
        $(document).ready(function() {
            $('#updateUserBtn').on('click', function() {
                var userId = $('#id').val();
                var roleIds = $('input[name="roles[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var name = $('#name').val();
                var email = $('#email').val();
                var isAdmin = $('#isAdmin').val();

                $.ajax({
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: '/save-user-roles',
                    data: {
                        'user_id': userId,
                        'role_ids': roleIds,
                        'name' : $('#name').val(),
                        'email' : $('#email').val(),
                        'isAdmin' : $('#isAdmin').val(),
                    },
                    success: function(response) {
                        alert('Kullanıcı yetkileri başarıyla güncellendi.');
                    },
                    error: function(xhr) {
                        alert('Bir hata oluştu, kullanıcı yetkileri güncellenemedi.');
                    }
                });
            });
        });

        // Modal Kapatma Tuşları
        $(document).on('click', '#closeUserBtn', function(){
            $('#userModal').modal('hide');
        });

    </script>
@endsection
