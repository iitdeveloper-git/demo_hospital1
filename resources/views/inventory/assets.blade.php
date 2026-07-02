@extends('layouts.inventory', ['title' => 'Hospital Assets Directory'])

@section('content')
<div class="assets-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Register Hospital Asset</h2>
            </div>
            
            <form action="{{ url('inventory/assets') }}" method="POST" class="asset-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Asset Item Name</label>
                    <input type="text" id="name" name="name" placeholder="E.g. MRI Machine Room A" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Asset Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="current_value">Purchase Value ($)</label>
                    <input type="number" id="current_value" name="current_value" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-landmark"></i> Register Asset Tag</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Assets Inventory Tags Registry</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Asset Tag</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Purchase Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td><code>{{ $asset->asset_tag }}</code></td>
                                <td><strong>{{ $asset->name }}</strong></td>
                                <td>{{ $asset->category->name }}</td>
                                <td>${{ number_format($asset->current_value, 2) }}</td>
                                <td><span class="status-pill status-{{ $asset->status }}">{{ ucfirst($asset->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No hospital assets registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $assets->links() }}
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

    .asset-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .asset-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .asset-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .asset-form select,
    .asset-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .asset-form select:focus,
    .asset-form input:focus {
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
