<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet"
        />

        <title>Proxwebs</title>

        <!-- Bootstrap core CSS -->
        <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Onix template CSS (served from public/) -->
        <link rel="stylesheet" href="/onix/assets/css/fontawesome.css" />
        <link rel="stylesheet" href="/onix/assets/css/templatemo-onix-digital.css" />
        <link rel="stylesheet" href="/onix/assets/css/animated.css" />
        <link rel="stylesheet" href="/onix/assets/css/owl.css" />
        <link rel="stylesheet" href="/onix/assets/css/onix-custom.css" />

        @vite(['resources/js/onix/main.js'])
        <script>
            (function () {
                try {
                    var theme = localStorage.getItem('onix-theme');
                    if (theme === 'dark') {
                        document.documentElement.setAttribute('data-theme', 'dark');
                    }
                } catch (e) {}
            })();
        </script>
    </head>
    <body>
        <div id="onix-app"></div>
    </body>
</html>
