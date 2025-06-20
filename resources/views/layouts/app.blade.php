<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    {{-- select2 --}}
    <link href="{{ asset('select2/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('select2/js/select2.min.js') }}"></script>
    <style>
        .btn-primary {
            background-color: #2a4988 !important;
            border-color: #2a4988 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="d-flex flex-column">

    @include('layouts.header')
    @include('layouts.sidebar')

    <div class="content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    @include('layouts.footer')

    {{-- toggle sidebar --}}
    <script>
        $(document).ready(function() {
            $('#closeSidebar').on('click', function() {
                $('#sidebar').removeClass('show');
            });

            $('#toggleSidebar').on('click', function() {
                $('#sidebar').toggleClass('show');
            });

            $('.select2').select2();
        });
    </script>
    @stack('scripts')

    {{-- Toast notif from controller --}}
    @if (session('toast'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
            <div class="toast align-items-center text-white bg-{{ session('toast.type') }} border-0 show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('toast.message') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            var $toastEl = $('.toast');
            if ($toastEl.length) {
                var toast = new bootstrap.Toast($toastEl[0]);
                toast.show();
            }
        });
    </script>

    {{-- Toast notif on view --}}
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>
    <script>
        function showToast(message, type = 'success') {
            const id = 'toast-' + Date.now();
            const toastHTML = `
                <div id="${id}" class="toast align-items-center text-white bg-${type} border-0 show mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            $('#toast-container').append(toastHTML);
            const toastEl = document.getElementById(id);
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }
    </script>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="customConfirmModal" tabindex="-1" aria-labelledby="customConfirmLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="customConfirmLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="customConfirmMessage">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmOkBtn" type="button" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmModal(message, okCallback) {
            $('#customConfirmMessage').text(message);
            let modal = new bootstrap.Modal(document.getElementById('customConfirmModal'));
            modal.show();

            // Remove old click handlers to avoid duplicates
            $('#confirmOkBtn').off('click').on('click', function() {
                modal.hide();
                okCallback();
            });
        }
    </script>

</body>

</html>
