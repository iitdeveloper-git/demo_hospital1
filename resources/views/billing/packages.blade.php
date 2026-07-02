@extends('layouts.billing', ['title' => 'Hospital Packages'])

@section('content')
<div class="packages-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Configure Hospital Package</h2>
            </div>
            
            <form action="{{ route('billing.packages.store') }}" method="POST" class="package-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Package Name</label>
                    <input type="text" id="name" name="name" placeholder="E.g. Cardiac Executive Health Checkup" required>
                </div>

                <div class="form-group">
                    <label for="price">Package Fee ($)</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="description">Services Inclusions Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Includes ECG, Lipid Panel, Cardiology consultation..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cube"></i> Save Package</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Health Check Packages Directory</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Package ID</th>
                            <th>Name</th>
                            <th>Fee</th>
                            <th>Inclusions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $pkg)
                            <tr>
                                <td>PKG-{{ str_pad((string)$pkg->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td><strong>{{ $pkg->name }}</strong></td>
                                <td><strong>${{ number_format($pkg->price, 2) }}</strong></td>
                                <td style="font-size:12px; color:var(--text-muted);">{{ $pkg->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No hospital packages configured.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .split-layout {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 32px;
        align-items: start;
    }

    .package-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .package-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .package-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .package-form select,
    .package-form input,
    .package-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .package-form select:focus,
    .package-form input:focus,
    .package-form textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
