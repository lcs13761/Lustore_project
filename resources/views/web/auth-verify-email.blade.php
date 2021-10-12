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
          
            </div>
         
            <form style="padding-top: 10px" action="{{ url('/reset-password') }}" method="post">
                @csrf
        
                <div>
                    <button class="buttonForm" id="send" style="width: 100%;">SALVAR</button>
                </div>
            </form>
        </div>
    </article>

</body>

</html>
