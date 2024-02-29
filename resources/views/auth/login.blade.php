<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>GESCHICKEN</title>
</head>
<body class="body_login">
    <div class="conteneur_login">
        <div class="card_login">
            <div class="gradient_image">
            <img src="{{asset('image/geschicken.jpg')}}" alt="">
            </div>
            <div style="padding-right: 30px;">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="cote_logo">
                        <div class="entete_welcome">
                            BIENVENUE SUR GESCHICKEN
                        </div>
                        <div class="row" style="justify-content: center;">
                            <div class="col-md-8">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Saississez votre email">
                                </div>
                                <div class="col-md-8">
                                  <label for="password" class="col-form-label">Mot de passe</label>
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Saississez le mot de passe">
                                </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-md-8">
                                <button type="submit" class="btn" style="background-color: #821435; color: white; width : 200px">Se Connecter</button>
                            </div>
                        </div>
                        {{-- <div class="pt-3"><a href="{{route('register')}}" style="color: #821435">S'inscrire</a></div> --}}
                    </div>  
                </form>
            </div>
        </div>
    </div>
</body>
</html>