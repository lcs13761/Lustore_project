<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .containerCenter {
            height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0 15px;
            align-items: center;
        }

        #img {
            max-width: 300px;
        }

        .position_relative {
            position: relative;
        }

        .label {
            color: #fff;
            font-size: 20px;
            padding: 5px 0;
        }

        .inputForget,
        .buttonForm {
            width: calc(100% - 10px);
            height: 50px;
            border: 0px;
            border-radius: 3px;
            padding: 0 0 0 10px;
        }

        .buttonForm {
            margin-top: 10px;
            cursor: pointer;
            color: #fff;
            font-size: 20px;
            background-color: rgba(0, 103, 254, 1);
        }

        .showPasswordPosition {
            position: absolute;
            top: 46px;
            right: 10px;
            cursor: pointer;
        }

        .iconSize {
            width: 30px;
            height: 30px;
        }

    </style>
</head>

<body>
<article class="containerCenter">
    <div style="padding-top:30px;">
        <div style=" max-width: 300px;margin: 0 auto;">
            <img id="img" src="{{ asset('storage/logo/logo.png') }}">
        </div>
        <header style="margin-top:30px;  color: #fff;font-size: 16px;">
            <p>Informe e repita uma nova senha para recuperar seu acesso.</p>
        </header>
        <form style="padding-top: 10px" action="{{ url('/reset-password') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{$email ?? null}}">
            <div class="position_relative">
                <label for="password">
                    <p class="label"><span>Nova Senha:</span></p>
                </label>
                <input id="password" class="inputForget" type="password" name="password">
                <span onClick="inputPasswordActions('password','hiddenPassword','showPassword')" id="showPassword"
                      class="showPasswordPosition">
                        <x-heroicon-o-eye class="iconSize"/>

                    </span>
                <span onClick="inputPasswordActions('password','showPassword','hiddenPassword')" style="display:none;"
                      onClick="" id="hiddenPassword" class="showPasswordPosition">

                        {{ svg('tni-eye-closed',class: 'iconSize') }}

                    </span>
            </div>
            <div class="position_relative">
                <label for="password_confirmation">
                    <p class="label"><span>Repita a nova senha:</span></p>
                </label>
                <input id="password_confirmation" class="inputForget" type="password"
                       name="password_confirmation">
                <span onClick="inputPasswordActions('password_confirmation','hiddenPassword_re','showPassword_re')"
                      id="showPassword_re" class="showPasswordPosition">
                        <x-heroicon-o-eye class="iconSize"/>
                    </span>
                <span style="display:none;" id="hiddenPassword_re"
                      onClick="inputPasswordActions('password_confirmation','showPassword_re','hiddenPassword_re')"
                      class="showPasswordPosition">
                        {{ svg('tni-eye-closed',class: 'iconSize') }}
                    </span>
            </div>
            <div>
                <button class="buttonForm" id="send" style="width: 100%;">SALVAR</button>
            </div>
        </form>
    </div>
</article>

<script>

    function inputPasswordActions(typeInput, show, hidden) {
        let inputElement = document.getElementById(typeInput).type;
        let showElement = document.getElementById(show);
        let hiddenElement = document.getElementById(hidden);

        if (inputElement == "password") {
            document.getElementById(typeInput).type = "text";
            showElement.style.display = "block";
            hiddenElement.style.display = "none";
        } else {
            document.getElementById(typeInput).type = "password";
            showElement.style.display = "block";
            hiddenElement.style.display = "none";
        }

    }

    // async function setForm(e) {
    //     e.preventDefault();
    //     let form = document.querySelector("form");
    //     let url = form.getAttribute("action");
    //     let data = new FormData(form);

    //     try {
    //         let response = await fetch(url, {
    //             method: "POST",
    //             body: data,
    //         });


    //     } catch (e) {

    //         console.log("error");
    //     }
    // }

    // if (document.getElementById("send")) {
    //     document.getElementById("send").addEventListener("click", setForm);
    // }
</script>

</body>

</html>
