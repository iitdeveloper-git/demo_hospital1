@extends('layouts.public')

@section('content')
<section class="dashboard-shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('home') }}"><span class="brand-mark"><i class="fa-solid fa-heart-pulse"></i></span><span>AarogyaCare</span></a>
        <nav aria-label="{{ $roleName }} navigation">
            @foreach($nav as $item)
                <a href="#"><i class="fa-solid fa-circle-dot"></i>{{ $item }}</a>
            @endforeach
        </nav>
    </aside>
    <div class="dashboard-main">
        <header class="dashboard-topbar">
            <div>
                <span class="eyebrow">{{ $roleName }}</span>
                <h1>Command Dashboard</h1>
            </div>
            <label class="search-box"><i class="fa-solid fa-magnifying-glass"></i><input data-table-search placeholder="Search patients, invoices, doctors"></label>
            <button class="icon-button" data-theme-toggle aria-label="Toggle dark mode"><i class="fa-solid fa-moon"></i></button>
        </header>

        <div class="metric-grid">
            @foreach($metrics['cards'] as $card)
                <article class="metric-card">
                    <i class="fa-solid {{ $card['icon'] }}"></i>
                    <span>{{ $card['label'] }}</span>
                    <strong>{{ $card['value'] }}</strong>
                    <em>{{ $card['trend'] }}</em>
                </article>
            @endforeach
        </div>

        <section class="dashboard-grid">
            <div class="panel">
                <div class="panel-heading"><h2>Weekly Flow</h2><button class="btn btn-soft" data-export-table>Export CSV</button></div>
                <canvas id="flowChart" height="120" data-chart='@json($metrics["chart"])'></canvas>
            </div>
            <div class="panel">
                <div class="panel-heading"><h2>AI Alerts</h2><span class="status-dot">Live</span></div>
                @foreach($metrics['alerts'] as $alert)
                    <div class="alert-row"><strong>{{ $alert['title'] }}</strong><span>{{ $alert['body'] }}</span></div>
                @endforeach
            </div>
        </section>

        <section class="panel">
            <div class="panel-heading"><h2>Operational Queue</h2><div><button class="btn btn-soft" data-prev-page>Prev</button><button class="btn btn-soft" data-next-page>Next</button></div></div>
            <div class="table-wrap">
                <table data-smart-table>
                    <thead><tr><th>Case</th><th>Patient</th><th>Status</th><th>Priority</th><th>Owner</th></tr></thead>
                    <tbody>
                        @foreach(range(1, 18) as $row)
                            <tr>
                                <td>MC-{{ str_pad((string) $row, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ ['Anaya Rao','Vihaan Shah','Ishita Kapoor','Kabir Nair'][$row % 4] }}</td>
                                <td>{{ ['Scheduled','Checked In','In Review','Completed'][$row % 4] }}</td>
                                <td><span class="pill">{{ ['Low','Normal','High','Critical'][$row % 4] }}</span></td>
                                <td>{{ ['Reception','Doctor','Lab','Billing'][$row % 4] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</section>
@endsection
