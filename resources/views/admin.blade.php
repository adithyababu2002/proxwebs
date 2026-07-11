<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="/onix/assets/css/fontawesome.css" />
        <title>Proxwebs Admin</title>
        <link rel="icon" type="image/png" href="/onix/assets/images/LOGO10.png" />
        <link rel="apple-touch-icon" href="/onix/assets/images/LOGO10.png" />
        @vite(['resources/js/admin/main.js'])
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
        <div id="admin-app"></div>
    </body>
</html>
