<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="IMPROMISE" name="description" />
    <meta content="Era Konsultan" name="author" />
    <!-- Favicon icon -->
    <link href="{{ asset('assets/media/logos/favicon.ico') }}" rel="shortcut icon" />
    <title>IMPROMISE</title>
</head>

<body>
    <iframe src="https://docs.google.com/gview?url={!! asset('storage/' . $documentName) !!}&embedded=true" width="100%" height="800"
        allowfullscreen webkitallowfullscreen></iframe>
</body>

</html>
