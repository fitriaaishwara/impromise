<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.1.8
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
    <title>IMPROMISE</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root">
        <style>
            body {
                background-image: url('assets/media/auth/bg10.jpeg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('assets/media/auth/bg10-dark.jpeg');
            }
        </style>
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid">
                <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                    <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="{{ asset('assets/media/auth/agency.png') }}" alt="" />
                    <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                        src="{{ asset('assets/media/auth/agency-dark.png') }}" alt="" />
                    <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Impromise</h1>
                </div>
            </div>
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                        <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                            <form class="form w-100" action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="text-center mb-10">
                                    <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                                        <a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a>
                                    </div>
                                </div>
                                @if (session('token'))
                                    <div class="alert alert-danger">
                                        {{ session('token') }}
                                    </div>
                                @endif
                                <div class="fv-row mb-8">
                                    <div class="mb-1">
                                        <div class="position-relative mb-3">
                                            <input class="form-control bg-transparent" type="password" id="password"
                                                placeholder="Password" name="password" required />
                                        </div>
                                    </div>
                                    <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &
                                        symbols.</div>
                                </div>
                                <div class="fv-row mb-8">
                                    <input type="password" placeholder="Repeat Password" name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control bg-transparent @error('password') is-invalid @enderror"
                                        required />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    {{-- <script src="assets/js/custom/authentication/sign-in/general.js"></script> --}}
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
