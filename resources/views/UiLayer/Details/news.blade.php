<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>{{$gecerliBilgi->SirketAdi}} - {{$news->baslik}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{$news->meta_keywords}}" name="keywords">
    <meta content="{{$news->meta_description}}" name="description">
    <meta content="{{$news->meta_title}}" name="title">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Favicon -->
    @if($gecerliLogo)
        <link rel="icon" type="image/png" class="rounded-circle" href="{{ asset($gecerliLogo->FilePath) }}">
    @endif

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>


    <!-- Libraries Stylesheet -->
    <link href="{{ asset('drivin-1.0.0/') }}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ asset('drivin-1.0.0/') }}/lib/owlcarousel/assets/owl.carousel.min.css"
        rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('drivin-1.0.0/') }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('drivin-1.0.0/') }}/css/style.css" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .ornek {
            width: 900px;
            margin: auto;
        }

        .sola-kaydir {
            float: left;
            padding: 0 10px 0 0;
        }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->
    @include('UiLayer.Uilayouts.head')

    <!--Blog İçerik-->
    <div class="container">
        <div class="cs-blog-detail">
            <div class="cs-main-post">
                <h1>{{$news->baslik}}</h1>
                <div class="row">
                    @if($news->görsel2=='') 
                        <div class="col-md-6 rich-editor-text">
                                {!! $news->aciklama !!}
                        </div>
                    @else
                        <div class="ornek">
                            <img style="max-width: 500px;" src="{{ asset($news->görsel2) }}" class="sola-kaydir">
                            {!! $news->aciklama !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Start -->
    @include('UiLayer.Uilayouts.footer')
    <!-- Footer End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    @include('UiLayer.Uilayouts.script')
</body>

</html>
