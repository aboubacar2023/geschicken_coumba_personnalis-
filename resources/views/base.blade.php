<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <title>GESCHICKEN</title>
</head>
<body>
    <div class="conteneur">
        <div class="menu">
          @php
            $route = Route::currentRouteName();
            $niveau = Auth::user()->niveau;
          @endphp
            <nav>
                <div class="image" ><img src="{{asset('image/geschicken.jpg')}}" height="170" width="160" alt=""></div>
                <ul>
                  @if ($niveau === 'admin')
                    <li>
                      <a href="{{route('activite-journaliere')}}">
                        <div @class(['lien', 'selection'  => str_contains($route, 'activite-journaliere')])>
                          Activités du Jour
                        </div>
                      </a>
                    </li>
                  @endif
                  <li>
                    <a href="{{route('fournisseur.apercu')}}">
                      <div @class(['lien', 'selection'  => str_contains($route, 'fournisseur.')])>
                        Fournisseurs
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('client.apercu')}}">
                      <div @class(['lien', 'selection'  => str_contains($route, 'client.')])>
                        Clients
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('stock')}}">
                      <div @class(['lien', 'selection'  => str_contains($route, 'stock')])>
                        Stock
                      </div>
                    </a>
                  </li>
                  @if ($niveau === 'admin')
                    <li>
                      <a href="{{route('caisse')}}">
                        <div @class(['lien', 'selection'  => str_contains($route, 'caisse')])>
                          Caisse
                        </div>
                      </a>
                    </li>
                    {{-- <li>
                      <a href="{{route('caisse')}}">
                        <div @class(['lien', 'selection'  => str_contains($route, 'caisse')])>
                          Administrateur
                        </div>
                      </a>
                    </li> --}}
                  @endif
                  <li>
                    <div class="lien_deconnect">
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn">Se Déconnecter</button>
                      </form>
                    </div>
                    <p style="padding-top: 15px; margin-left: 5px">{{Auth::user()->name}}</p>
                  </li>
                </ul>
            </nav>
        </div>
        @yield('content')
    </div>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}}
</body>
</html>