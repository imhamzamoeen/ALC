<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<style>
    .error-wrapper {
        height: 100vh;
    }
</style>

<body>
    <div class="d-flex align-items-center justify-content-center error-wrapper container">
        <div class="text-center">
            <img src="{{ asset('images/500-error.svg') }}" alt="404-error" class="mb-4" />
            <h4 class="mb-4 fw-bold" style="font-size: 26px">{{ __('SERVER ERROR') }}</h4>
            <h5 class="mb-4" style="font-size: 16px;max-width:600px">{{ __('The server undergoes an internal error or misconfiguration, unable to complete your request. Please contact at') }}<a class="text-decoration-none" href="mailto:support@alquranclasses.com"> support@alquranclasses.com</a></h5>
            <a class="btn btn-primary px-4 py-3" href="javascript: history.go(-1)">{{ __('Go back to the Home Page') }}</a>
        </div>
    </div>
</body>

</html>
