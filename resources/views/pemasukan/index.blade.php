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
                        <button id="add-btn" class="btn btn-sm btn-success" title="Add">Add <i
                                class="fas fa-plus"></i></button>
                        <button id="edit-btn" class="btn btn-sm btn-primary ms-2" title="Edit">Edit <i
                                class="fas fa-edit"></i></button>
                        <button id="delete-btn" class="btn btn-sm btn-danger ms-2" title="Delete">Hapus <i
                                class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="table-wrapper">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>Tanggal</th>
                                        <th>Total Pemasukan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- model detail data --}}
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel">Detail Pemasukan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="detailContent">
                                <!-- Detail will be loaded here -->
                            </div>
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
                ajax: "{{ route('pemasukans.data') }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
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

            // Add
            $('#add-btn').on('click', function() {
                window.location.href = `/pemasukan/create`;
            });

            // Edit
            $('#edit-btn').on('click', function() {
                let selected = $('.row-checkbox:checked');
                if (selected.length !== 1) {
                    showToast('Please select exactly one item to edit.', 'danger');
                    return;
                }
                let id = selected.val();
                window.location.href = `/pemasukan/${id}/edit`;
            });

            // Delete
            $('#delete-btn').on('click', function() {
                let selected = $('.row-checkbox:checked');
                if (selected.length === 0) {
                    showToast('Please select at least one item to delete.', 'danger');
                    return;
                }

                let ids = selected.map(function() {
                    return $(this).val();
                }).get();

                confirmModal('Are you sure you want to delete selected pemasukan?', function() {
                    $.ajax({
                        url: '/pemasukan/delete-multiple',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids
                        },
                        success: function(res) {
                            table.ajax.reload(null,
                                false); // false = keep current pagination
                            showToast('pemasukan deleted successfully!', 'success');
                        },
                        error: function() {
                            alert('Failed to delete. Please try again.');
                        }
                    });
                });
            });

            $('#example').on('click', '.showDetail', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/pemasukan/${id}`, // Example route
                    method: 'GET',
                    success: function(response) {
                        $('#detailContent').html(response);
                        $('#detailModal').modal('show');
                    }
                });
            });

        });
    </script>
@endsection
