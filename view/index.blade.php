@extends('maillog::layout')
@section('content')
    <div class="table-container">

        <table id="table-log" class="table table-striped">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $log)

                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->getRawOriginal('to') }}</td>
                        <td>{{ $log->subject }}</td>
                        <td class="action">
                            @if ($log->error_count)
                            <a class="btn btn-sm btn-danger" href="{{ route(config('maillog.route.prefix', 'mail-logs') . '.error', $log) }}">Error</a>
                            @else
                            <a class="btn btn-sm {{ $log->status ? "btn-success" : "btn-warning" }}" href="{{ route(config('maillog.route.prefix', 'mail-logs') . '.show', $log) }}">{{ $log->status ? "SEND" : "PENNDING" }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div style="width: max-content;margin: auto;">
            {{ $list->links() }}
        </div>
    </div>


    <!-- Datatables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.action a').on('click', function(e){
                e.preventDefault();
                window.open(e.target.href, '_blank', 0)
            });
            $('#table-log').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: false
            });
        });
    </script>
@endsection
