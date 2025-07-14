@extends('layouts.app')

@section('title', $title)

@section('content')
    <h2>{{ $title }}</h2>
    <!-- New Row for DataTable -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 d-none d-md-block">Data {{ $title }}</h5>
                    <div>
                        {{-- <button id="add-btn" class="btn btn-sm btn-success" title="Add">Add <i
                                class="fas fa-plus"></i></button>
                        <button id="delete-btn" class="btn btn-sm btn-danger ms-2" title="Delete">Hapus <i
                                class="fas fa-trash-alt"></i></button> --}}
                        <button id="edit-btn" class="btn btn-sm btn-primary ms-2" title="Edit">Edit <i
                                class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table-wrapper">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Saldo Awal</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let table = $('#example').DataTable({
                // dom: 'Bfrtip',
                columnDefs: [{
                    targets: 0,
                    width: '50px'
                }, ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('saldos.data') }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'saldo_awal',
                        name: 'saldo_awal'
                    },
                ]
            });

            // Keep your checkbox logic here
            $(document).on('click', '#select-all', function() {
                $('.row-checkbox').prop('checked', this.checked);
            });

            $(document).on('change', '.row-checkbox', function() {
                if (!this.checked) {
                    $('#select-all').prop('checked', false);
                }
            });

            // Edit
            $('#edit-btn').on('click', function() {
                let selected = $('.row-checkbox:checked');
                if (selected.length !== 1) {
                    showToast('Please select exactly one item to edit.', 'danger');
                    return;
                }
                let id = selected.val();
                window.location.href = `/saldo/${id}/edit`;
            });
        });
    </script>
@endsection
