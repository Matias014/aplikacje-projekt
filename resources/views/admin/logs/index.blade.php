@include('shared.html')
@include('shared.head', ['pageTitle' => 'Logi działań'])

<body class="d-flex flex-column min-vh-100">
    @include('shared.navbar')
    <main class="flex-grow-1">
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Logi działań</h1>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Użytkownik</th>
                            <th>Akcja</th>
                            <th>Obiekt</th>
                            <th>IP</th>
                            <th>UA</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ optional($log->user)->username ?? 'guest' }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->subject_type }}#{{ $log->subject_id }}</td>
                                <td>{{ $log->ip }}</td>
                                <td style="max-width: 300px; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $log->user_agent }}</td>
                                <td>{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $logs->links() }}
            </div>
        </div>
    </main>
    @include('shared.footer')
</body>

</html>
