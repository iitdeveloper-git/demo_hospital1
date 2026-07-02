@extends('layouts.cms', ['title' => 'Marketing Campaigns'])

@section('content')
<div class="glass-panel">
    <div style="display:grid; grid-template-columns: 0.9fr 1.1fr; gap:32px; align-items:start;">
        <!-- Left: Form to Add new campaign -->
        <div>
            <h2>Schedule New Campaign</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Send bulk marketing updates to verified patient channels.</p>

            <form action="{{ route('cms.campaigns.store') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                <div>
                    <label for="name">Campaign Name</label>
                    <input type="text" name="name" id="name" placeholder="E.g. Cardiology Free Camp Notice" required>
                </div>

                <div>
                    <label for="channel">Dispatch Channel</label>
                    <select name="channel" id="channel" required>
                        <option value="email">Email Broadcast</option>
                        <option value="sms">SMS Text Alert</option>
                        <option value="whatsapp">WhatsApp Message</option>
                        <option value="push">Web Push Notification</option>
                    </select>
                </div>

                <div>
                    <label for="template_content">Template Body (HTML / Rich Text)</label>
                    <textarea name="template_content" id="template_content" rows="4" placeholder="Dear Patient, we are hosting a free cardiac wellness camp..." required></textarea>
                </div>

                <div style="margin-top:8px;">
                    <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fa-solid fa-paper-plane"></i> Schedule Broadcast</button>
                </div>
            </form>
        </div>

        <!-- Right: Campaigns lists -->
        <div style="border-left:1px solid var(--glass-border); padding-left:32px; min-height:360px;">
            <h2>Scheduled Broadcasts Queue</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Daemon logs for scheduled dispatches.</p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Channel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns as $camp)
                            <tr>
                                <td>
                                    <strong>{{ $camp->name }}</strong>
                                    <span style="display:block; font-size:10px; color:var(--text-muted);">Schedule: {{ $camp->schedule_at }}</span>
                                </td>
                                <td><span class="pill" style="text-transform:uppercase; font-size:9px;">{{ $camp->channel }}</span></td>
                                <td>
                                    <span class="status-pill status-{{ $camp->status === 'sent' ? 'paid' : 'pending' }}">
                                        {{ strtoupper($camp->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">No campaigns scheduled.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
