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
                <p>Informe o email para recuperar.</p>
            </header>
            <form style="padding-top: 10px" action="{{ url('/reset-password') }}" method="post">
                @csrf
                <label for="email">

                    <p class="label"><span>Nova Senha:</span></p>
                    <input id="email" class="inputForget" type="email" name="email">
                </label>
                <div>
                    <button class="buttonForm" id="send" style="width: 100%;">SALVAR</button>
                </div>
            </form>
        </div>
    </article>

    <script>
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
