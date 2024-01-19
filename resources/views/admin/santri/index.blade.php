@extends('layouts.main')
@section('title', 'Santri')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
@endpush
@section('content')
    <div class="page-heading">
        <h3>@yield('title')</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.tambahSantri') }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus-square"></i> Tambah</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.modal-hapus.hapus')
@endsection
@push('js')
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        let table;

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(function() {
            table = $('#datatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('admin.dataSantri') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nis'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function modalHapus(url) {
            $('#modal-form').modal('show');
            $('.modal-title').text('Hapus Data Santri')
            $('#confirmHapusData').on('click', function() {
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    type: 'DELETE',
                    success: function(data) {
                        // Close the modal
                        $('#modal-form').modal('hide');
                        // Optionally, update the table to reflect the deleted data
                        table.ajax.reload(); // Reload the table
                        toastr.success('Data Santri berhasil dihapus', 'Sukses');
                    },
                    error: function(error) {
                        alert('Tidak dapat menghapus data', error);
                        return;
                    }
                });
            });
        }
    </script>
@endpush
