<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/DataTables/datatables.css">
    <link rel="stylesheet" href="sweetalert2.min.css">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                  @guest
                    @else
                    <ul class="navbar-nav me-auto" style="align-items: center">
                        @can('firma-listele')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Firma İşlemleri
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @can('firma-listele')
                                        <li><a class="dropdown-item" href="{{ route('firma.listele') }}">Firma Listele</a></li>
                                    @endcan
                                    @can('firma-ekle')
                                        <li><a class="dropdown-item" href="{{ route('firma.ekle') }}">Manuel Ekle</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('excel-indir')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Excel İşlemleri
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @can('excel-yukle')
                                        <li><a type="button" data-toggle="modal" class="dropdown-item" id="excelYukle" name="excelYukle">Excel Yükle</a></li>
                                    @endcan
                                    @can('excel-indir')
                                        <li><a class="dropdown-item" href=" {{ route('excel.indir') }} ">Excel İndir</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('roles-listele')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Rol İşlemleri
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @can('roles-listele')
                                        <li><a class="dropdown-item" href="{{ route('roles.listele') }}">Rol Listele</a></li>
                                    @endcan
                                    @can('roles-ekle')
                                        <li><a class="dropdown-item" href=" {{ route('roles.ekle') }}">Rol Ekle</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('user-listele')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Kullanıcı İşlemleri
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('user.listele') }}">Kullanıcı Listele</a></li>
                                </ul>
                            </li>
                        @endcan
                    </ul>
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="excelModalLabel">Excel Yükleme Formu</h5>
                        <button type="button" class="close" id="exitModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form mt-2" method="POST" enctype="multipart/form-data" action="{{ route('excel.yukle')}}">
                            @csrf
                            <input type="file" name="file" class="form-control" />
                            <div class="mt-4 butonn">
                                <button type="submit" class="btn btn-success">Gönder</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>


        <main class="py-2">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="sweetalert2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>



    <script>
        // Modalın açılması için yazılan kod
        $(document).on('click','#excelYukle', function(){
            $('#excelModal').modal('show');
        });

        $(document).on('click', '#exitModal', '#closeModal', function(){
            $('#excelModal').modal('hide');
        });
    </script>

    <script>
        const form = document.querySelector('.form');
        const fileInput = document.querySelector('input[name="file"]');
        const submitButton = document.querySelector('button[type="submit"]');
        const errorMessage = document.createElement('div');

        errorMessage.classList.add('error-message');
        form.appendChild(errorMessage);

        submitButton.disabled = true;

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            errorMessage.innerHTML = '';

            if (!file) {
                submitButton.disabled = true;
                errorMessage.innerHTML = 'Lütfen bir dosya seçiniz.';
                return;
            }

            if (!file.name.endsWith('.xlsx' && '.xls')) {
                submitButton.disabled = true;
                errorMessage.innerHTML = 'Lütfen sadece Excel dosyaları seçiniz.';
                return;
            }

            submitButton.disabled = false;
        });
    </script>

    @yield('js')




</body>
</html>
