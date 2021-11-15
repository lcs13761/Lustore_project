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

        .mw-100{
            max-width: 100% !important;
        }
        .m-auto{
            margin: auto;
        }

        .text-center{
            text-align: center;
        }

        .mt-5{
            margin-top: 3rem !important;
        }

        .mx-3 {
            margin-right: 1rem !important;
            margin-left: 1rem !important;
        }

        .d-inline-block{
            display: inline-block;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        @media (prefers-reduced-motion: reduce) {
            .btn {
                transition: none;
            }
        }
        .btn:hover {
            color: #212529;
        }

        .rounded {
            border-radius: 0.25rem !important;
        }

        .bg-primary {

            background-color: rgba(100, 161, 157, 1) !important;
        }

        .text-white{
            color: #e2e8f0;
        }

        .container{
            width: 100%;
            /*padding-right: var(--bs-gutter-x, 0.75rem);*/
            /*padding-left: var(--bs-gutter-x, 0.75rem);*/
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 576px) {
           .container {
                max-width: 540px;
            }
        }
        @media (min-width: 768px) {
           .container {
                max-width: 720px;
            }
        }
        @media (min-width: 992px) {
             .container {
                max-width: 960px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                max-width: 1170px;
            }
        }
        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }
        }
    </style>
</head>

<body>
<article class="optin_page">
    <div class="container">
        <div class="mw-100 m-auto text-center mt-5" style="width: 600px;">
            <img class="mw-100 mt-5" style="width:400px" alt="{{ $value->title}}" title="{{$value->title}}"
                 src="{{asset($value->image)}}"/>
            <h1 class="text-white">{{ $value->title}}</h1>
            <p style="margin-bottom: 10px" class="mx-3 text-white">{{ $value->desc}}</p>
            @if (!empty($value->link))
                <a class="d-inline-block btn bg-primary rounded"
                   href="{{ $value->link}}" title="{{ $value->linkTitle}}">{{ $value->linkTitle}}</a>
            @endif
        </div>
    </div>
</article>
</body>
</html>
